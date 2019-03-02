<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\Price;
use GuzzleHttp\Pool;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\DomainServices\ClientContainer;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class UpdatePrices
 * @package App\Jobs
 */
class UpdatePrices implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * UpdatePrices constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param ClientContainer $client
     */
    public function handle(ClientContainer $client) : void
    {
        $symbols = Company::all()->pluck('symbol');
        $requests = function ($symbols) {
            foreach ($symbols as $symbol) {
                yield new Request('GET', config('iextrading.IEX_BASEPATH').'stock/'.$symbol.'/price');
            }
        };
        Pool::batch($client->client, $requests($symbols), [
            'concurrency' => 20,
            'fulfilled' => function ($response, $index) {
                $price = new Price();
                $price->price = $response->getBody()->getContents();
                $price->company_id = $index;
                $price->created_at = date('Y-m-d H:i:s');
                $price->save();
            },
            'rejected' => function ($reason, $index) {
                Log::error('Could not update price: ' . $reason);
            },
        ]);
    }
}

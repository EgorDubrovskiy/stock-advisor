<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\Price;
use GuzzleHttp\Pool;
use Illuminate\Bus\Queueable;
use Illuminate\Http\JsonResponse;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\DomainServices\ClientContainer;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Class UpdatePrices
 * @package App\Jobs
 */
class UpdatePrices implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param ClientContainer $client
     */
    public function handle(ClientContainer $client): void
    {
        $symbols = Company::all()->pluck('symbol');
        $requests = function ($symbols) {
            foreach ($symbols as $symbol) {
                yield new Request(
                    'GET',
                    config('iextrading.IEX_BASEPATH').'stock/'.$symbol.'/price'.
                    '?token='.config('iextrading.IEX_AUTH_TOKEN')
                );
            }
        };
        Pool::batch($client->client, $requests($symbols), [
            'concurrency' => 20,
            'fulfilled' => function ($response, $index) use ($symbols) {
                $price = new Price();
                $price->price = $response->getBody()->getContents();
                $price->company_id = Company::query()->where('symbol', $symbols[$index])->firstOrFail()->id;
                $price->created_at = date('Y-m-d H:i:s');
                $price->save();
            },
            'rejected' => function (Exception $exception, $index) use ($symbols) {
                if ($exception->getCode() === JsonResponse::HTTP_NOT_FOUND) {
                    Company::query()->where('symbol', $symbols[$index])->delete();
                    Log::error('Company: ' . $symbols[$index] . ' was not found because it was deleted');
                } else {
                    throw $exception;
                }
            },
        ]);
    }
}

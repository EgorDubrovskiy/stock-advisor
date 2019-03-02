<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class ReportController
 * @package App\Http\Controllers
 */
class ReportController extends Controller
{
    /**
     *  @const CHUNKSIZE;
     */
    const CHUNKSIZE = 5000;

    /**
     *Half an hour in seconds;
     */
    const HALFHOUR = 1800;

    /**
     * @param Request $request
     */
    public function pricesToCSV(Request $request)
    {
        $symbols = Company::pluck('name');
        $from = $request->query->get(
            'from',
            (new Carbon())->modify(sprintf('-%d seconds', self::HALFHOUR))->format('Y-m-d H:i:s')
        );
        $to = $request->query->get('to', (Carbon::now()));
        $handle = fopen(storage_path() . '/app/public/source.csv', 'a');

        Price::whereBetween('created_at', [$from, $to])
            ->chunk(self::CHUNKSIZE, function ($prices) use ($handle, $symbols) {
                foreach ($prices as $price) {
                    fputcsv($handle, array_merge(['symbol' => $symbols[$price['company_id']]], $price->only('price')));
                }
            });

        fclose($handle);

        $filePath = storage_path() . '/app/public/source.csv';
        $fileName = 'prices.csv';

        header('Content-Description: File Transfer');
        header('Content-Type: text/plain');
        header('Content-Disposition: inline; filename=' . $fileName);
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($filePath));

        readfile($filePath);
        Storage::delete('public/source.csv');
    }
}

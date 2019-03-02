<?php

namespace App\Jobs;

use App\Interfaces\Documents\PDFInterface;
use App\Services\Models\CompanyService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class ReportCompanies
 * @package App\Jobs
 */
class ReportCompanies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var false|string|null $date */
    protected $date;

    /** @var int COUNT_ROWS_IN_PAGE */
    private const COUNT_ROWS_IN_PAGE = 49;

    /** @var int COUNT_ROWS_IN_CHUNK */
    private const COUNT_ROWS_IN_CHUNK = 490;

    /** @var string START_HTML */
    private const START_HTML = '
                        <table>
                            <tr>
                                <th>Symbol</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th>AVG</th>
                            </tr>';

    /** @var string END_HTML */
    private const END_HTML = '
                            </table>
                                <style type="text/css">
                                    table {
                                        width: 400px;
                                        border-collapse: collapse;
                                    }
                                    td, th {
                                        padding: 3px;
                                        border: 1px solid black;
                                    }
                                </style>
                        ';

    /**
     * ReportCompanies constructor.
     * @param string|null $date
     */
    public function __construct(string $date = null)
    {
        $this->date = $date ?? date('Y-m-d');
    }

    public function handle(PDFInterface $pdf, CompanyService $companyService)
    {
        $fileName =
            config('reports.basePath').'/'.
            config('reports.pricesBasePath').'/'.
            date('Y-m-d H-i-s').'.pdf';

        //Create empty pdf
        $pdf->output($fileName, 'F');

        $parameters = ['date' => $this->date];
        $chunksCompanies = $companyService
            ->getCompaniesForReport($parameters)
            ->chunk(self::COUNT_ROWS_IN_CHUNK);

        foreach ($chunksCompanies as $companies) {
            $pdf = $pdf->newInstance();
            $pdf->importPages($fileName);

            $indexFirstCompany = $companies->keys()[0];
            $indexLastCompany = $indexFirstCompany + count($companies) - 1;

            //Add pages with tables to pdf begin
            for ($i = $indexFirstCompany; $i <= $indexLastCompany; $i += self::COUNT_ROWS_IN_PAGE) {
                $pdf->addPage();
                $html = self::START_HTML;
                for ($j = $i; $j < $i + self::COUNT_ROWS_IN_PAGE && $j <= $indexLastCompany; $j++) {
                    $html .= '
                        <tr>
                            <td>'.$companies[$j]->symbol.'</td>
                            <td>'.$companies[$j]->min.'</td>
                            <td>'.$companies[$j]->max.'</td>
                            <td>'.round($companies[$j]->avg, 2).'</td>
                        </tr>
                    ';
                }
                $html .= self::END_HTML;
                $pdf->writeHTML($html);
            }
            //Add pages with tables to pdf end

            $pdf->output($fileName, 'F');
        }

        $pdf->saveWithoutFirstPage($fileName);
    }
}

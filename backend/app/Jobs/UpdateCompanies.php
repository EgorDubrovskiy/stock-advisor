<?php

namespace App\Jobs;

use App\DomainServices\ClientContainer;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Bus\Queueable;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Exception;
use Log;
use App\Models\{Industry, IssueType, Sector, Company, Tag, CompanyTag};

/**
 * Class UpdateCompanies
 * @package App\Jobs
 */
class UpdateCompanies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ClientContainer
     */
    protected $client;

    /** @var DatabaseManager $DB */
    protected $DB;

    /**
     * UpdateCompanies constructor.
     * @param ClientContainer $client
     * @param DatabaseManager $DB
     */
    public function __construct(ClientContainer $client, DatabaseManager $DB)
    {
        $this->client = $client;
        $this->DB = $DB;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $companies = $this->client->get(
            config('iextrading.IEX_BASEPATH').'ref-data/symbols'.
            '?token='.config('iextrading.IEX_AUTH_TOKEN')
        );

        foreach ($companies as $company) {
            $symbol = $company['symbol'];
            try {
                $companyInfo = $this->client->get(
                    config('iextrading.IEX_BASEPATH'). 'stock/'. $symbol. '/company'.
                    '?token='.config('iextrading.IEX_AUTH_TOKEN')
                );
                $this->client->get(
                    config('iextrading.IEX_BASEPATH').'stock/'.$symbol.'/price'.
                    '?token='.config('iextrading.IEX_AUTH_TOKEN')
                );
                $news = $this->client->get(
                    config('iextrading.IEX_BASEPATH') . 'stock/' . $symbol . '/news/last/1'.
                    '?token='.config('iextrading.IEX_AUTH_TOKEN')
                );
                if (count($news) == 0) {
                    Company::query()->where('symbol', $symbol)->delete();
                    Log::error('News for company: ' . $symbol . ' was not found because it was deleted');
                    continue;
                }
            } catch (ClientException $exception) {
                if ($exception->getResponse()->getStatusCode() === JsonResponse::HTTP_NOT_FOUND) {
                    Log::error('Price for company: ' . $symbol . ' was not found because it was deleted');
                    continue;
                } else {
                    throw $exception;
                }
            }

            try {
                $this->DB->beginTransaction();
                $newCompany = [
                    'industry_id' => !is_null($companyInfo['industry']) ? Industry::firstOrCreate(
                        ['name' => $companyInfo['industry']]
                    )->id : null,
                    'issue_type_id' => !is_null($companyInfo['issueType']) ? IssueType::firstOrCreate(
                        ['description' => $companyInfo['issueType']]
                    )->id : null,
                    'sector_id' => !is_null($companyInfo['sector']) ? Sector::firstOrCreate(
                        ['name' => $companyInfo['sector']]
                    )->id : null,
                    'name' => $company['name'],
                    'created_at' => $company['date'],
                    'is_enabled' => $company['isEnabled'],
                    'exchange' => $companyInfo['exchange'],
                    'website' => $companyInfo['website'],
                    'description' => $companyInfo['description'],
                    'ceo' => $companyInfo['CEO'],
                    'symbol' => $companyInfo['symbol'],
                ];

                $idCompany = Company::updateOrCreate(['symbol' => $symbol], $newCompany)->id;

                foreach ($companyInfo['tags'] as $tag) {
                    $idTag = Tag::firstOrCreate(['name' => $tag])->id;
                    CompanyTag::firstOrCreate([
                        'company_id' => $idCompany,
                        'tag_id' => $idTag
                    ]);
                }
                $this->DB->commit();
            } catch (Exception $exception) {
                $this->DB->rollBack();
                Log::error('Could not create company: ' . $exception->getMessage());
            }
        }
    }
}

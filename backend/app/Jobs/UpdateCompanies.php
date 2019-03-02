<?php

namespace App\Jobs;

use App\DomainServices\ClientContainer;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Bus\Queueable;
use Illuminate\Http\JsonResponse;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\{Industry, IssueType, Sector, Company, Tag, CompanyTag};

class UpdateCompanies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ClientContainer
     */
    protected $client;

    /**
     * UpdateCompanies constructor.
     * @param ClientContainer $client
     */
    public function __construct(ClientContainer $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $companies = $this->client->get(config('iextrading.IEX_BASEPATH').'ref-data/symbols');

        foreach ($companies as $company) {
            $symbol = $company['symbol'];
            try {
                $companyInfo = $this->client->get(
                    config('iextrading.IEX_BASEPATH'). 'stock/'. $symbol. '/company'
                );
            } catch (ClientException $exception) {
                if ($exception->getResponse()->getStatusCode() === JsonResponse::HTTP_NOT_FOUND) {
                    continue;
                }
            }


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
        }
    }
}

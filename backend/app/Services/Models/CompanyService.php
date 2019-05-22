<?php

namespace App\Services\Models;

use App\DomainServices\ClientContainer;
use App\Interfaces\Services\CompanyInterface;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CompanyService
 * @package App\Services\Models
 */
class CompanyService implements CompanyInterface
{
    /** @var ConditionsService $conditionsService */
    protected $conditionsService;

    /** @var ClientContainer $client */
    protected $client;

    /**
     * CompanyService constructor.
     * @param ConditionsService $conditionsService
     * @param ClientContainer $client
     */
    public function __construct(ConditionsService $conditionsService, ClientContainer $client)
    {
        $this->conditionsService = $conditionsService;
        $this->client = $client;
    }

    /**
     * @param array $parameters
     * @return Collection
     */
    public function getCompaniesForReport(array $parameters) : Collection
    {
        $companies = Company::join('prices', 'prices.company_id', 'companies.id')
            ->select(
                'symbol',
                DB::raw('(SELECT MIN(prices.price) FROM prices WHERE company_id = companies.id) AS min'),
                DB::raw('(SELECT MAX(prices.price) FROM prices WHERE company_id = companies.id) AS max'),
                DB::raw('(SELECT AVG(prices.price) FROM prices WHERE company_id = companies.id) AS avg')
            )
            ->whereRaw('DATE(prices.created_at) = ?', [$parameters['date']])
            ->get();

        return $companies;
    }

    /**
     * @param string|null $date
     * @param array|null $parameters
     * @param int $limit
     * @return Collection
     */
    public function getTopCompanies(string $date = null, array $parameters = null, int $limit = 10) : Collection
    {
        if (is_null($date)) {
            $date = date('Y-m-d');
        }

        $dateFrom = $date . ' 00:00:00';
        $dateTo = $date . ' 23:59:59';
        /** @var Builder $companies */
        $companies = Company::leftJoin('industries', 'companies.industry_id', 'industries.id')
            ->leftJoin('issue_types', 'companies.issue_type_id', 'issue_types.id')
            ->leftJoin('sectors', 'companies.sector_id', 'sectors.id')
            ->join(
                DB::raw(
                    '
                        (
                            SELECT AVG(prices.price) AS price, prices.company_id
                            FROM prices
                            WHERE prices.created_at BETWEEN ? AND ?
                            GROUP BY company_id
                        ) AS avg_prices
                    '
                ),
                function($join)
                {
                    $join->on('companies.id', '=', 'avg_prices.company_id');
                }
            )
            ->setBindings([$dateFrom, $dateTo])
            ->select(
                'companies.symbol AS сокращение',
                'companies.name AS название',
                'sectors.name AS сектор',
                'industries.name AS индустрия',
                'avg_prices.price AS цена'
            )
            ->orderBy('price', 'DESC')
            ->limit($limit);

        if (is_null($parameters)) {
            return $companies->get();
        }

        /** Adding search parameters to query */
        if (array_key_exists('search', $parameters)) {
            foreach ($parameters['search'] as $parameter) {
                $this->conditionsService->addWhere(
                    $companies,
                    $parameter['parameter'],
                    $parameter['field'],
                    $parameter['value']
                );
            }
        }

        /** Adding sorting parameters to query */
        if (array_key_exists('sorting', $parameters)) {
            foreach ($parameters['sorting'] as $parameter) {
                $this->conditionsService->addOrderBy(
                    $companies,
                    $parameter['field'],
                    $parameter['parameter']
                );
            }
        }

        return $companies->get();
    }

    /**
     * @param array $symbols
     * @param bool $allNews
     * @return array
     */
    public function getNews(array $symbols, bool $allNews = false) : array
    {
        $urls = [];
        $urlsEnd = $allNews ? '' : '/last/1';

        foreach ($symbols as $symbol) {
            array_push(
                $urls,
                config('iextrading.IEX_BASEPATH') . 'stock/' . $symbol . '/news' . $urlsEnd
            );
        }

        $news = $this->client->batchGet($urls);

        if (!$allNews) {
            $news = array_map(
                function ($arrayNews) {
                    return $arrayNews[0];
                },
                $news
            );
        }

        return $news;
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getBookmarks(int $userId) : Collection
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime("-1 days"));

        $queryAvgPrice =
                        '
                            (
                                SELECT AVG(prices.price) FROM prices
                                WHERE DATE(prices.created_at) = ?
                                AND prices.company_id = companies.id
                            )
                        ';
        $companies = Company::join('bookmarks', 'companies.id', 'bookmarks.company_id')
            ->leftJoin('sectors', 'companies.sector_id', 'sectors.id')
            ->select(
                'companies.name',
                'sectors.name AS sector',
                DB::raw($queryAvgPrice . ' AS \'price yesterday\'')
            )
            ->addBinding($yesterday, 'select')
            ->addSelect(DB::raw($queryAvgPrice . ' AS \'price today\''))
            ->addBinding($today, 'select')
            ->where('bookmarks.user_id', $userId)
            ->get();

        return $companies;
    }

    /**
     * @param array $parameters
     * @param int $itemsCount
     * @param int $pageNumber
     * @return Builder
     */
    private function searchBuilder(array $parameters, int $itemsCount = null, int $pageNumber = null) : Builder
    {
        $date = date('Y-m-d');
        $queryAvgPrice =
                        '
                            (
                                SELECT AVG(prices.price) FROM prices
                                WHERE DATE(prices.created_at) = ?
                                AND prices.company_id = companies.id
                            )
                        ';
        /** @var Builder $companies */
        $companies = Company::leftJoin('industries', 'companies.industry_id', 'industries.id')
            ->leftJoin('issue_types', 'companies.issue_type_id', 'issue_types.id')
            ->leftJoin('sectors', 'companies.sector_id', 'sectors.id')
            ->select(
                'companies.id',
                'companies.ceo',
                'companies.created_at',
                'companies.deleted_at',
                'companies.description',
                'companies.exchange',
                'companies.name',
                'companies.symbol',
                'companies.website',
                'companies.is_enabled',
                'industries.name AS industryName',
                'issue_types.description AS issueTypeDescription',
                'sectors.name AS sectorName',
                DB::raw($queryAvgPrice . ' AS price')
            )
            ->addBinding($date, 'select')
            ->havingRaw($queryAvgPrice . ' IS NOT NULL', [$date]);

        $companies = Company::query()->fromSub($companies, 'companies');

        /** Adding search parameters to query */
        if (array_key_exists('search', $parameters)) {
            foreach ($parameters['search'] as $parameter) {
                $this->conditionsService->addWhere(
                    $companies,
                    $parameter['parameter'],
                    $parameter['field'],
                    $parameter['value']
                );
            }
        }

        /** Adding sorting parameters to query */
        if (array_key_exists('sorting', $parameters)) {
            foreach ($parameters['sorting'] as $parameter) {
                $this->conditionsService->addOrderBy(
                    $companies,
                    $parameter['field'],
                    $parameter['parameter']
                );
            }
        }

        /** Adding pagination parameters to query */
        if (!is_null($itemsCount) && !is_null($pageNumber)) {
            $this->conditionsService->addPagination($companies, $itemsCount, $pageNumber);
        }

        return $companies;
    }

    /**
     * @param array $parameters
     * @param int $itemsCount
     * @param int $pageNumber
     * @return Collection
     */
    public function searchGet(array $parameters, int $itemsCount = null, int $pageNumber = null) : Collection
    {
        return $this->searchBuilder($parameters, $itemsCount, $pageNumber)->get();
    }

    /**
     * @param array $parameters
     * @param int $itemsCount
     * @param int $pageNumber
     * @return int
     */
    public function searchCount(array $parameters, int $itemsCount = null, int $pageNumber = null) : int
    {
        return $this->searchBuilder($parameters, $itemsCount, $pageNumber)->get()->count();
    }

    /**
     * @return int
     */
    public function countAllCompanies() : int
    {
        $total = Company::all()->count();

        return $total;
    }
}

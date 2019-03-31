<?php

namespace App\Services\Models;

use App\Interfaces\Services\PriceInterface;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PriceService
 * @package App\Services\Models
 */
class PriceService implements PriceInterface
{
    /**
     * @param array $symbols
     * @param array $years
     * @param array|null $months
     * @return Collection
     */
    public function getAvgPrices(array $symbols, array $years, array $months = null) : Collection
    {
        /** @var Builder $prices */
        $prices = Company::select('name');

        for ($i = 0; $i < count($years); $i++) {
            $tableAvgPrices = $i . 'avg_prices' . $years[$i] . (is_null($months) ? '' : '_' . $months[$i]);
            $avgPriceColumn = $i . 'price' . $years[$i] . (is_null($months) ? '' : '_' . $months[$i]);
            $monthCondition = is_null($months) ? '' : ' AND MONTH(prices.created_at) = ' . $months[$i];
            $prices
                ->leftJoin(
                    DB::raw(
                        '
                        (
                            SELECT AVG(prices.price) AS ' . $avgPriceColumn . ', prices.company_id
                            FROM prices
                            WHERE YEAR(prices.created_at) = ? ' . $monthCondition .'
                            GROUP BY company_id
                        ) AS ' . $tableAvgPrices
                    ),
                    function($join) use ($tableAvgPrices)
                    {
                        $join->on('companies.id', '=', $tableAvgPrices . '.company_id');
                    }
                )
                ->addBinding([$years[$i]])
                ->addSelect($tableAvgPrices . '.' . $avgPriceColumn);
        }

        $prices->whereIn('symbol', $symbols);

        return $prices->get();
    }
}

<?php

namespace App\Interfaces\Services;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface PriceInterface
 * @package App\Interfaces\Services
 */
interface PriceInterface
{
    /**
     * @param array $years
     * @param array|null $months
     * @return Collection
     */
    public function getAvgPrices(array $years, array $months = null) : Collection;
}

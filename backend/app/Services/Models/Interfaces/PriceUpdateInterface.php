<?php

namespace App\Services\Models\Interfaces;

use App\DomainServices\ClientContainer;

/**
 * Interface PriceUpdateInterface
 * @package App\Services\Models\Interfaces
 */
interface PriceUpdateInterface
{
    /**
     * @return mixed
     */
    public function getPricesOfCompanies();
}

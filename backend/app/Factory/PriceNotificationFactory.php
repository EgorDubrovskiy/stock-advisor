<?php

namespace App\Factory;

use App\Models\PriceNotification;

/**
 * Class PriceNotificationFactory
 * @package App\Factory
 */
class PriceNotificationFactory
{

    /**
     * @param array $fields
     * @return PriceNotification
     */
    public function makePriceNotification(array $fields) : PriceNotification
    {
        $priceNotification = new PriceNotification();
        $priceNotification->fill($fields);
        return $priceNotification;
    }
}

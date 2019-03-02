<?php

namespace App\Services\Models;

use App\Factory\PriceNotificationFactory;
use App\Models\PriceNotification;

/**
 * Class PriceNotificationService
 * @package App\Services\Models
 */
class PriceNotificationService
{

    /**
     * @var PriceNotificationFactory
     */
    protected $priceNotification;

    /**
     * PriceNotificationService constructor.
     * @param PriceNotificationFactory $priceNotification
     */
    public function __construct(PriceNotificationFactory $priceNotification)
    {
        $this->priceNotification = $priceNotification;
    }

    /**
     * @param array $fields
     * @return PriceNotification
     */
    public function create(array $fields) : PriceNotification
    {
        $priceNotification = $this->priceNotification->makePriceNotification($fields);
        $priceNotification->save();

        return $priceNotification;
    }

    /**
     * @param PriceNotification $priceNotification
     * @param array $newFields
     * @return PriceNotification
     */
    public function update(PriceNotification $priceNotification, array $newFields) : PriceNotification
    {
        $priceNotification->fill($newFields);
        $priceNotification->save();

        return $priceNotification;
    }

    /**
     * @param PriceNotification $priceNotification
     * @throws \Exception
     */
    public function delete(PriceNotification $priceNotification) : void
    {
        $priceNotification->delete();
    }
}

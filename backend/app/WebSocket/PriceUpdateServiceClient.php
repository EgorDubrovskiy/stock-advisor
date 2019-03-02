<?php
/**
 * Created by PhpStorm.
 * User: Uladzislau
 * Date: 18.01.2019
 * Time: 17:53
 */

namespace App\WebSocket;

use App\Services\Models\Interfaces\PriceUpdateInterface;

/**
 * Class PriceUpdateServiceClient
 * @package App\WebSocket
 */
class PriceUpdateServiceClient
{
    /**
     * @var PriceUpdateInterface
     */
    private $updater;

    /**
     * PriceUpdateServiceClient constructor.
     * @param PriceUpdateInterface $updater
     */
    public function __construct(PriceUpdateInterface $updater)
    {
        $this->updater = $updater;
    }

    /**
     * @return mixed
     */
    public function getPricesOfCompanies()
    {
        return $this->updater->getPricesOfCompanies();
    }
}

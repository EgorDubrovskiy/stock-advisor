<?php

namespace App\Providers;


use App\Services\Models\PriceUpdateService;
use Illuminate\Support\ServiceProvider;
use App\Services\Models\Interfaces\PriceUpdateInterface;

class PriceUpdateServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PriceUpdateInterface::class, PriceUpdateService::class);
    }
}

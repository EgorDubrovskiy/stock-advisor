<?php

namespace App\Providers;

use App\Http\Middleware\Cors;
use App\Interfaces\Documents\PDFInterface;
use App\Interfaces\Services\CompanyInterface;
use App\Services\Documents\PDFService;
use App\Services\Models\CompanyService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $kernel = $this->app->make(Kernel::class);
        $kernel->prependMiddleware(Cors::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PDFInterface::class, PDFService::class);

        $this->app->bind(CompanyInterface::class, CompanyService::class);
    }
}

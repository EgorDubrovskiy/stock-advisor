<?php

use App\DomainServices\ClientContainer;
use App\Jobs\UpdateCompanies;
use App\Jobs\UpdatePrices;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('trading:companies:update', function () {
    app()->make(UpdateCompanies::class)->handle();
})->describe('Update companies list from xtrading');

Artisan::command('trading:prices:update', function () {
    app()->make(UpdatePrices::class)->handle(app()->make(ClientContainer::class));
})->describe('Update companies list from xtrading');
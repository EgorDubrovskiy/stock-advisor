<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('cors')->group(function () {
    Route::prefix('companies')->group(function () {

        Route::get('topNow', 'CompanyController@getTopNow');

        Route::get('news/{symbols}', 'CompanyController@getNews');

        Route::get('', 'CompanyController@getBySymbol');

        Route::get('search', 'CompanyController@search');

        Route::get('total', 'CompanyController@getTotalNumberOfCompanies');
    });

    Route::prefix('prices')->group(function () {
        Route::get('', 'PriceController@getPrice');
    });

    Route::middleware('auth')->group(function () {

        Route::get('v1/_healthcheck', 'MessageController@healthCheck');

        Route::get('v2/poll', 'MessageController@poll');

        Route::get('names', 'MessageController@getNames');

        Route::get('version', 'MessageController@version');

        Route::prefix('prices')->group(function () {

            Route::get('downloadCSV', 'ReportController@pricesToCSV');
        });

        Route::prefix('bookmarks')->group(function () {
            Route::get('{userId}', 'BookmarkController@getBookmarks');

            Route::post('{userId}/{companyId}', 'BookmarkController@addBookmark');

            Route::get('{userId}', 'BookmarkController@getBookmarks');

            Route::delete('{userId}/{companyId}', 'BookmarkController@deleteBookmark');
        });

        Route::prefix('companies')->group(function () {
            Route::get('top/{date}', 'CompanyController@getTop');

            Route::post('', 'CompanyController@create');

            Route::delete('{id}', 'CompanyController@delete');
        });

        Route::prefix('users')->group(function () {

            Route::get('{id}/avatar', 'UserController@getUserAvatar');

            Route::get('{id}', 'UserController@readInfo');

            Route::post('{id}/avatar', 'UserController@saveUserAvatar');

            Route::put('{id}', 'UserController@update');

            Route::delete('{id}', 'UserController@deleteUser');
        });

        Route::prefix('notifications')->group(function () {

            Route::get('prices', 'PriceNotificationController@getAllPriceNotifications');

            Route::get('prices/{id}', 'PriceNotificationController@getPriceNotification');

            Route::post('prices', 'PriceNotificationController@createPriceNotification');

            Route::put('prices/{id}', 'PriceNotificationController@updatePriceNotification');

            Route::delete('prices/{id}', 'PriceNotificationController@deletePriceNotification');
        });
    });

    Route::group(
        ['prefix' => 'auth'],
        function ($router) {

            Route::post('register', 'UserController@saveUser');

            Route::post('login', 'AuthController@login');

            Route::post('activate/{token}', 'UserController@activateUser');

            Route::middleware('auth')->group(function () {

                Route::post('logout', 'AuthController@logout');

                Route::post('refresh', 'AuthController@refresh');

                Route::post('me', 'AuthController@me');
            });
        }
    );

    Route::group(
        [
            'namespace' => 'Auth',
            'prefix' => 'password',
        ],
        function () {
            Route::post('send', 'PasswordController@sendToken');
            Route::get('find/{token}', 'PasswordController@findToken');
            Route::post('reset', 'PasswordController@resetPassword');
        }
    );
});

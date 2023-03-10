<?php

declare(strict_types=1);

use App\Http\Controllers\Api\v1\NewYorkTimes\BestSellersController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('1')->name('api.v1.')->group( function () {
        Route::prefix('nyt')->name('nyt.')->group( function () {
                Route::get('/best-sellers', BestSellersController::class)->name('best_sellers');
            }
        );
    }
);

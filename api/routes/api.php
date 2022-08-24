<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PairController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
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

Route::get('/ping', function () {
    return response('API online', 200)->header('Content-Type', 'text/plain');
});


Route::middleware('auth:sanctum')->group( function () {
    // Route for custom function with PAIR CONTROLLER
    Route::controller(PairController::class)->group(function() {
        Route::post('pairs/convert', 'convertCurrencies');
        Route::get('decompte', 'decompte');
    });

    // Ressource for PAIR CRUD
    Route::apiResource('pairs', PairController::class);
    Route::apiResource('currencies', CurrencyController::class);
});

Route::controller(RegisterController::class)->group(function(){
    Route::post('login', 'login');
});


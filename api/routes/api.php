<?php

use App\Http\Controllers\PairController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(PairController::class)->group(function() {
    Route::get('/pairs', 'index')->name('pair.list');
    // Route::get('produits/{id}', 'getByID')->name('product.show')->where(['id' => '[0-9]+']);
    // Route::get('/produits/categorie/{id}', 'getByCategory')->name('product.category')->where(['id' => '[0-9]+']);;
    // Route::get('/produits/soldes', 'getBySales')->name('product.sales');
});


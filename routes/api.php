<?php

use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\PaymentController;
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

Route::group(['middleware' => 'auth:api'], function () {
    Route::controller(TransactionController::class)->prefix('transactions')->group(function() {
        Route::get('get', 'index');
        Route::post('store', 'store');
        Route::post('report', 'generateReport');
    });
    Route::controller(PaymentController::class)->prefix('payments')->group(function() {
        Route::get('get', 'index');
        Route::post('store', 'store');
    });
});
require __DIR__.'/auth.php';

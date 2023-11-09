<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\VeritasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::group([
    'prefix' => 'SINEIN',
], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('selectores', [UtilityController::class, 'selectores']);
    Route::post('Veritas', [VeritasController::class, 'Veritas']);

});

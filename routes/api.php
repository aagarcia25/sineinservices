<?php

use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\InteligenciaController;
use App\Http\Controllers\InvestigacionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PruebaController;
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
    Route::post('informes', [UtilityController::class, 'informes']);
    Route::post('Investigacion', [InvestigacionController::class, 'Investigacion']);
    Route::post('Inteligencia', [InteligenciaController::class, 'Inteligencia']);
    Route::post('Analisis', [AnalisisController::class, 'Analisis']);
    Route::post('Prueba', [PruebaController::class, 'Prueba']);
    Route::post('Veritas', [VeritasController::class, 'Veritas']);
    Route::post('FilesAdmin', [UtilityController::class, 'FilesAdmin']);
    Route::post('GetDocumento', [UtilityController::class, 'GetDocumento']);

});

<?php

use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\EmpleosController;
use App\Http\Controllers\InteligenciaController;
use App\Http\Controllers\InvestigacionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\UsuariosController;
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


// Grupo principal con el middleware aplicado a las demás rutas
Route::group([
    'prefix' => 'SINEIN_API_JGV',
    'middleware' => ['api'],
], function () {
    Route::post('login', [LoginController::class, 'login'])->middleware('throttle:5,10');
    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('logoutuser', [LoginController::class, 'logoutuser']);
    Route::post('ChangePassword', [LoginController::class, 'ChangePassword']);
    Route::post('selectores', [UtilityController::class, 'selectores']);
    Route::post('informes', [UtilityController::class, 'informes']);
    Route::post('Investigacion', [InvestigacionController::class, 'Investigacion']);
    Route::post('Inteligencia', [InteligenciaController::class, 'Inteligencia']);
    Route::post('Inteligencia2', [InteligenciaController::class, 'Inteligencia2']);
    Route::post('Analisis', [AnalisisController::class, 'Analisis']);
    Route::post('Prueba', [PruebaController::class, 'Prueba']);
    Route::post('Veritas', [VeritasController::class, 'Veritas']);
    Route::post('FilesAdmin', [UtilityController::class, 'FilesAdmin']);
    Route::post('SaveFiles', [UtilityController::class, 'SaveFiles']);
    Route::post('GetDocumento', [UtilityController::class, 'GetDocumento']);
    Route::post('GetImageInteligencia', [UtilityController::class, 'GetImageInteligencia']);
    Route::post('usuarios', [UsuariosController::class, 'usuarios']);
    Route::post('Empleos', [EmpleosController::class, 'Empleos']);
    Route::post('Graficas', [UtilityController::class, 'Graficas']);
});

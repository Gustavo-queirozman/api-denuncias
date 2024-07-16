<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Denuncia\CriarController AS CriarDenunciaController;
use App\Http\Controllers\Denuncia\ExcluirController AS ExcluirDenunciaController;
use App\Http\Controllers\Denuncia\ListarController AS ListarDenunciaController;
use App\Http\Controllers\Esclarecimento\CriarController AS CriarEsclarecimentoController;
use App\Http\Controllers\Usuario\EditarController AS EditarUsuarioController;
use App\Http\Controllers\Usuario\ExcluirController AS ExcluirUsuarioController;
use App\Http\Controllers\Usuario\ListarController AS ListarUsuarioController;
use Illuminate\Http\Request;
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

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register']);
Route::post('forgot', [AuthController::class, 'forgot']);
Route::post('reset', [AuthController::class, 'reset']);



Route::middleware('auth:api')->group(function () {
    Route::get('usuarios', ListarUsuarioController::class)->middleware('admin');
    Route::post('usuario/{id}', EditarUsuarioController::class)->middleware('admin');
    Route::delete('usuario/{id}', ExcluirUsuarioController::class)->middleware('admin');

    Route::get('denuncias', ListarDenunciaController::class);
    Route::post('denuncia', CriarDenunciaController::class);
    Route::delete('denuncia/{id}', ExcluirDenunciaController::class);
});

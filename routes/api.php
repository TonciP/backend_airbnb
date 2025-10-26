<?php

use App\Http\Controllers\ArrendatarioController;
use App\Http\Controllers\LugarController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/hola', function () {
    return response()->json(['message' => 'Hola mundo']);
});

//Route::get('/users', [UserController::class, 'GetAll']);
Route::post('/cliente/login', [UserController::class, 'login']);
Route::post('/cliente/registro', [UserController::class, 'save']);

Route::post('/arrendatario/login', [ArrendatarioController::class, 'login']);
Route::post('/arrendatario/registro', [ArrendatarioController::class, 'save']);

Route::get('/lugares/{id}', [LugarController::class, 'getLugarById']);
Route::get('/lugares/arrendatario/{id}', [LugarController::class, 'lugarArrendatarioById']);
Route::post('/lugares/search', [LugarController::class, 'searchLugar']);
Route::post('/lugares/advancedsearch', [LugarController::class, 'searchLugarAvance2']);
//Route::post('/lugares2/advancedsearch', [LugarController::class, 'searchLugarAvance']);
Route::post('/lugares', [LugarController::class, 'guardarLugar']);
Route::put('/lugares/{id}', [LugarController::class, 'editarLugar']);
Route::post('/lugares/{id}/foto', [LugarController::class, 'guardarFotoById']);


//Route::get('/reservas/lugar/{lugar_id}', [ReservaController::class, 'getByIdLugar']);
Route::get('/reservas/lugar/{lugar_id}', [LugarController::class, 'getByIdLugar']);

Route::get('/reservas/cliente/{clienteId}', [ReservaController::class, 'getByIdCliente']);
Route::post('/reservas', [ReservaController::class, 'saveReserva']);

<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\PedidoController;

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

Route::post('/register', [AuthController::class, 'createUser']);
Route::post('/login', [AuthController::class, 'loginUser']);

Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::apiResources([
        'produto' => ProdutoController::class,
        'vendedor' => VendedorController::class,
        'pedido' => PedidoController::class,
    ]);

    Route::get('/vendedor/pedidos/comissao', [VendedorController::class, 'listarVendedoresComissao']);
    Route::get('/vendedor/{id}/pedidos', [VendedorController::class, 'listarPedidos']);
    Route::get('/pedidos/totalDia', [PedidoController::class, 'totalPedidoDia']);
});

<?php

use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'loginUser']);
Route::post('/uploadImage', [UploadController::class, 'uploadImage']);

Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/me', [UserController::class, 'me']);
    Route::apiResources([
        'produto' => ProdutoController::class,
        'vendedor' => VendedorController::class,
        'pedido' => PedidoController::class,
    ]);

    Route::get('/vendedor/pedidos/comissao', [VendedorController::class, 'listarVendedoresComissao']);
    Route::get('/vendedor/{id}/pedidos', [VendedorController::class, 'listarPedidos']);
    Route::get('/pedidos/totalDia', [PedidoController::class, 'totalPedidoDia']);
});

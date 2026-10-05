<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PedidoController;

Route::get('/', function () {
    return redirect()->route('pedidos.index');
});

Route::resource('clientes', ClienteController::class);
Route::resource('produtos', ProdutoController::class);
Route::resource('pedidos', PedidoController::class);
Route::patch('/pedidos/{pedido}/status', [PedidoController::class, 'updateStatus'])
    ->name('pedidos.status');

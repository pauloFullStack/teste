<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/cadastrar-produto', [ProdutoController::class, 'store']);

Route::get('/', [ProdutoController::class, 'index']);
Route::get('/carrega-produtos', [ProdutoController::class, 'carregaProdutos']);
Route::get('/lista-cidades', [ProdutoController::class, 'listaCidades']);
Route::get('/filtro-por-cidade/{nome_produto}', [ProdutoController::class, 'filtraPorCidade']);
Route::get('/filtro-por-valor/{valor_inicial}/{valor_final}', [ProdutoController::class, 'filtraPorValor']);

Route::put('/produto-update', [ProdutoController::class, 'update']);

Route::delete('/produto/{id}', [ProdutoController::class, 'destroy']);
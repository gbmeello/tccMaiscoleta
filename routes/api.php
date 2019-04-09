<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('tipo-residuo')->group(function() {

    Route::get('/listar', 'Api\TipoResiduoController@list')->name('api.tipo_residuo.list');

    Route::post('/cadastrar', 'Api\TipoResiduoController@store')->name('api.tipo_residuo.store');

    Route::put('/editar/{id}', 'Api\TipoResiduoController@update')->name('api.tipo_residuo.update');

    Route::delete('/deletar/{id}', 'Api\TipoResiduoController@delete')->name('api.tipo_residuo.delete');

});


Route::prefix('coleta')->group(function() {

    Route::get('/listar', 'Api\ColetaController@list')->name('api.coleta.list');

    Route::post('/cadastrar', 'Api\ColetaController@store')->name('api.coleta.store');

    Route::put('/editar/{id}', 'Api\ColetaController@update')->name('api.coleta.update');

    Route::delete('/deletar/{id}', 'Api\ColetaController@delete')->name('api.coleta.delete');

});


Route::prefix('fornecedor')->group(function() {

    Route::get('/listar', 'Api\FornecedorController@list')->name('api.fornecedor.list');

    Route::post('/cadastrar', 'Api\FornecedorController@store')->name('api.fornecedor.store');

    Route::put('/editar/{id}', 'Api\FornecedorController@update')->name('api.fornecedor.update');

    Route::delete('/deletar/{id}', 'Api\FornecedorController@delete')->name('api.fornecedor.delete');


});


Route::prefix('cliente')->group(function() {

    Route::get('/listar', 'Api\ClienteController@list')->name('api.cliente.list');

    Route::post('/cadastrar', 'Api\ClienteController@store')->name('api.cliente.store');

    Route::put('/editar/{id}', 'Api\ClienteController@update')->name('api.cliente.update');

    Route::delete('/deletar/{id}', 'Api\ClienteController@delete')->name('api.cliente.delete');

});


Route::prefix('veiculo')->group(function() {

    Route::get('/listar', 'Api\VeiculoController@list')->name('api.veiculo.list');

    Route::post('/cadastrar', 'Api\VeiculoController@store')->name('api.veiculo.store');

    Route::put('/editar/{id}', 'Api\VeiculoController@update')->name('api.veiculo.update');

    Route::delete('/deletar/{id}', 'Api\VeiculoController@delete')->name('api.veiculo.delete');

});
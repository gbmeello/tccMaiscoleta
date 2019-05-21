<?php
/**
 * Created by PhpStorm.
 * User: marci
 * Date: 13/04/2019
 * Time: 18:16
 */


Route::namespace('Api\v1')->prefix('v1')->group(function() {

    Route::prefix('veiculo')->group(function() {

        Route::get('/listar', 'VeiculoController@list')->name('api.veiculo.list');

        Route::post('/cadastrar', 'VeiculoController@store')->name('api.veiculo.store');

        Route::put('/editar/{id}', 'VeiculoController@update')->name('api.veiculo.update');

        Route::delete('/deletar/{id}', 'VeiculoController@delete')->name('api.veiculo.delete');

    });

    Route::prefix('tipo-residuo')->group(function() {

        Route::get('/listar', 'TipoResiduoController@list')->name('api.tipo_residuo.list');

        Route::post('/cadastrar', 'TipoResiduoController@store')->name('api.tipo_residuo.store');

        Route::put('/editar/{id}', 'TipoResiduoController@update')->name('api.tipo_residuo.update');

        Route::delete('/deletar/{id}', 'TipoResiduoController@delete')->name('api.tipo_residuo.delete');

    });


    Route::prefix('coleta')->group(function() {

        Route::get('/listar', 'ColetaController@list')->name('api.coleta.list');

        Route::post('/cadastrar', 'ColetaController@store')->name('api.coleta.store');

        Route::put('/editar/{id}', 'ColetaController@update')->name('api.coleta.update');

        Route::delete('/deletar/{id}', 'ColetaController@delete')->name('api.coleta.delete');

    });


    Route::prefix('fornecedor')->group(function() {

        Route::get('/listar', 'FornecedorController@list')->name('api.fornecedor.list');

        Route::post('/cadastrar', 'FornecedorController@store')->name('api.fornecedor.store');

        Route::put('/editar/{id}', 'FornecedorController@update')->name('api.fornecedor.update');

        Route::delete('/deletar/{id}', 'FornecedorController@delete')->name('api.fornecedor.delete');

    });


    Route::prefix('cliente-final')->group(function() {

        Route::get('/listar', 'ClienteFinalController@list')->name('api.clienteFinal.list');

        Route::post('/cadastrar', 'ClienteFinalController@store')->name('api.clienteFinal.store');

        Route::put('/editar/{id}', 'ClienteFinalController@update')->name('api.clienteFinal.update');

        Route::delete('/deletar/{id}', 'ClienteFinalController@delete')->name('api.clienteFinal.delete');

    });


    Route::prefix('cliente')->group(function() {

        Route::get('/listar', 'ClienteFinalController@list')->name('api.cliente.list');

        Route::post('/cadastrar', 'ClienteFinalController@store')->name('api.cliente.store');

        Route::put('/editar/{id}', 'ClienteFinalController@update')->name('api.cliente.update');

        Route::delete('/deletar/{id}', 'ClienteFinalController@delete')->name('api.cliente.delete');

    });

});
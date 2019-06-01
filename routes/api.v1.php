<?php

Route::namespace('Api\v1')->prefix('v1')->group(function() {

    Route::prefix('estado')->group(function() {

        Route::get('/listar', 'EstadoController@index')->name('api.estado.listar');

        Route::get('/exibir/{id}', 'EstadoController@show')->name('api.estado.exibir');

    });

    Route::prefix('municipio')->group(function() {

        Route::get('/listar', 'MunicipioController@index')->name('api.municipio.listar');

        Route::get('/exibir/{id}', 'MunicipioController@show')->name('api.municipio.exibir');

        Route::get('/listar-por-estado/{id}', 'MunicipioController@getByEstado')->name('api.municipio.listarPorEstado');

    });

    Route::prefix('veiculo')->group(function() {

        Route::get('/listar', 'VeiculoController@index')->name('api.veiculo.listar');

        Route::get('/exibir/{id}', 'VeiculoController@show')->name('api.municipio.exibir');

        Route::post('/cadastrar', 'VeiculoController@store')->name('api.veiculo.cadastrar');

        Route::put('/editar/{id}', 'VeiculoController@update')->name('api.veiculo.editar');

        Route::delete('/deletar/{id}', 'VeiculoController@destroy')->name('api.veiculo.deletar');

    });

    Route::prefix('tipo-residuo')->group(function() {

        Route::get('/listar', 'TipoResiduoController@index')->name('api.tipo_residuo.listar');

        Route::get('/exibir/{id}', 'TipoResiduoController@show')->name('api.municipio.exibir');

        Route::post('/cadastrar', 'TipoResiduoController@store')->name('api.tipo_residuo.cadastrar');

        Route::put('/editar/{id}', 'TipoResiduoController@update')->name('api.tipo_residuo.editar');

        Route::delete('/deletar/{id}', 'TipoResiduoController@destroy')->name('api.tipo_residuo.deletar');

    });


    Route::prefix('coleta')->group(function() {

        Route::get('/listar', 'ColetaController@index')->name('api.coleta.listar');

        Route::get('/exibir/{id}', 'ColetaController@show')->name('api.municipio.exibir');

        Route::post('/cadastrar', 'ColetaController@store')->name('api.coleta.cadastrar');

        Route::put('/editar/{id}', 'ColetaController@update')->name('api.coleta.editar');

        Route::delete('/deletar/{id}', 'ColetaController@destroy')->name('api.coleta.deletar');

    });


    Route::prefix('fornecedor')->group(function() {

        Route::get('/listar', 'FornecedorController@index')->name('api.fornecedor.listar');

        Route::get('/exibir/{id}', 'FornecedorController@show')->name('api.municipio.exibir');

        Route::post('/cadastrar', 'FornecedorController@store')->name('api.fornecedor.cadastrar');

        Route::put('/editar/{id}', 'FornecedorController@update')->name('api.fornecedor.editar');

        Route::delete('/deletar/{id}', 'FornecedorController@destroy')->name('api.fornecedor.deletar');

    });


    Route::prefix('cliente-final')->group(function() {

        Route::get('/listar', 'ClienteFinalController@index')->name('api.cliente.listar');

        Route::get('/exibir/{id}', 'ClienteFinalController@show')->name('api.municipio.exibir');

        Route::post('/cadastrar', 'ClienteFinalController@store')->name('api.cliente.cadastrar');

        Route::put('/editar/{id}', 'ClienteFinalController@update')->name('api.cliente.editar');

        Route::delete('/deletar/{id}', 'ClienteFinalController@destroy')->name('api.cliente.deletar');

    });


    Route::prefix('ponto-coleta')->group(function() {

        Route::get('/listar', 'PontoColetaController@index')->name('api.pontoColeta.listar');

        Route::get('/exibir/{id}', 'PontoColetaController@show')->name('api.pontoColeta.exibir');

        Route::post('/cadastrar', 'PontoColetaController@store')->name('api.pontoColeta.cadastrar');

        Route::put('/editar/{id}', 'PontoColetaController@update')->name('api.pontoColeta.editar');

        Route::delete('/deletar/{id}', 'PontoColetaController@destroy')->name('api.pontoColeta.deletar');

    });

});
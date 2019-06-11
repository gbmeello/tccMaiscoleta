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

    Route::prefix('fardo')->group(function() {

        Route::get('/listar', 'FardoController@index')->name('api.fardo.listar');

        Route::get('/exibir/{id}', 'FardoController@show')->name('api.fardo.exibir');

        Route::post('/cadastrar', 'FardoController@store')->name('api.fardo.cadastrar');

        Route::put('/editar/{id}', 'FardoController@update')->name('api.fardo.editar');

        Route::delete('/deletar/{id}', 'FardoController@destroy')->name('api.fardo.deletar');

    });

    Route::prefix('tipo-residuo')->group(function() {

        Route::get('/listar', 'TipoResiduoController@index')->name('api.tipo_residuo.listar');

        Route::get('/exibir/{id}', 'TipoResiduoController@show')->name('api.tipo_residuo.exibir');

        Route::post('/cadastrar', 'TipoResiduoController@store')->name('api.tipo_residuo.cadastrar');

        Route::put('/editar/{id}', 'TipoResiduoController@update')->name('api.tipo_residuo.editar');

        Route::delete('/deletar/{id}', 'TipoResiduoController@destroy')->name('api.tipo_residuo.deletar');

    });


    Route::prefix('coleta')->group(function() {

        Route::get('/listar', 'ColetaController@index')->name('api.coleta.listar');

        Route::get('/exibir/{id}', 'ColetaController@show')->name('api.coleta.exibir');

        Route::post('/cadastrar', 'ColetaController@store')->name('api.coleta.cadastrar');

        Route::put('/editar/{id}', 'ColetaController@update')->name('api.coleta.editar');

        Route::delete('/deletar/{id}', 'ColetaController@destroy')->name('api.coleta.deletar');

    });


    Route::prefix('triagem')->group(function() {

        Route::get('/listar', 'TriagemController@index')->name('api.triagem.listar');

        Route::get('/exibir/{id}', 'TriagemController@show')->name('api.triagem.exibir');

        Route::post('/cadastrar', 'TriagemController@store')->name('api.triagem.cadastrar');

        Route::put('/editar/{id}', 'TriagemController@update')->name('api.triagem.editar');

        Route::delete('/deletar/{id}', 'TriagemController@destroy')->name('api.triagem.deletar');

    });


    Route::prefix('fornecedor')->group(function() {

        Route::get('/listar', 'FornecedorController@index')->name('api.fornecedor.listar');

        Route::get('/exibir/{id}', 'FornecedorController@show')->name('api.fornecedor.exibir');

        Route::post('/cadastrar', 'FornecedorController@store')->name('api.fornecedor.cadastrar');

        Route::put('/editar/{id}', 'FornecedorController@update')->name('api.fornecedor.editar');

        Route::delete('/deletar/{id}', 'FornecedorController@destroy')->name('api.fornecedor.deletar');

    });


    Route::prefix('cliente-final')->group(function() {

        Route::get('/listar', 'ClienteFinalController@index')->name('api.clienteFinal.listar');

        Route::get('/exibir/{id}', 'ClienteFinalController@show')->name('api.clienteFinal.exibir');

        Route::post('/cadastrar', 'ClienteFinalController@store')->name('api.clienteFinal.cadastrar');

        Route::put('/editar/{id}', 'ClienteFinalController@update')->name('api.clienteFinal.editar');

        Route::delete('/deletar/{id}', 'ClienteFinalController@destroy')->name('api.clienteFinal.deletar');

    });


    Route::prefix('ponto-coleta')->group(function() {

        Route::get('/listar', 'PontoColetaController@index')->name('api.pontoColeta.listar');

        Route::get('/exibir/{id}', 'PontoColetaController@show')->name('api.pontoColeta.exibir');

        Route::post('/cadastrar', 'PontoColetaController@store')->name('api.pontoColeta.cadastrar');

        Route::put('/editar/{id}', 'PontoColetaController@update')->name('api.pontoColeta.editar');

        Route::delete('/deletar/{id}', 'PontoColetaController@destroy')->name('api.pontoColeta.deletar');

    });


    Route::prefix('rota')->group(function() {

        Route::get('/listar', 'RotaController@index')->name('api.rota.listar');

        Route::get('/exibir/{id}', 'RotaController@show')->name('api.rota.exibir');

        Route::post('/cadastrar', 'RotaController@store')->name('api.rota.cadastrar');

        Route::put('/editar/{id}', 'RotaController@update')->name('api.rota.editar');

        Route::delete('/deletar/{id}', 'RotaController@destroy')->name('api.rota.deletar');

    });
});
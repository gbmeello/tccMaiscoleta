<?php

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

//Auth::routes();

Route::get('/', function () {
    return view('index');
});

//Route::prefix('tipo-residuo')->middleware('auth')->group(function () {
Route::prefix('tipo-residuo')->group(function () {
    Route::get('/', 'TipoResiduoController@index');
    Route::get('index', 'TipoResiduoController@index');
    Route::get('cadastrar', 'TipoResiduoController@create');
    Route::get('editar/{id}', 'TipoResiduoController@edit');
    Route::get('listar', 'TipoResiduoController@listar');
});


//Route::prefix('tipo-residuo')->middleware('auth')->group(function () {
Route::prefix('usuario')->group(function () {
    Route::get('/', 'UsuarioController@index');
    Route::get('index', 'UsuarioController@index');
    Route::get('cadastrar', 'UsuarioController@create');
    Route::get('editar/{id}', 'UsuarioController@edit');
    Route::get('listar', 'UsuarioController@listar');
});


//Route::prefix('tipo-residuo')->middleware('auth')->group(function () {
Route::prefix('coleta')->group(function () {
    Route::get('/', 'ColetaController@index');
    Route::get('index', 'ColetaController@index');
    Route::get('cadastrar', 'ColetaController@create');
    Route::get('editar/{id}', 'ColetaController@edit');
    Route::get('listar', 'ColetaController@listar');
});


//Route::prefix('tipo-residuo')->middleware('auth')->group(function () {
Route::prefix('veiculo')->group(function () {
    Route::get('/', 'VeiculoController@index');
    Route::get('index', 'VeiculoController@index');
    Route::get('cadastrar', 'VeiculoController@create');
    Route::get('editar/{id}', 'VeiculoController@edit');
    Route::get('listar', 'VeiculoController@listar');
});


//Route::prefix('tipo-residuo')->middleware('auth')->group(function () {
Route::prefix('ponto-coleta')->group(function () {
    Route::get('/', 'PontoColetaController@index');
    Route::get('index', 'PontoColetaController@index');
    Route::get('cadastrar', 'PontoColetaController@create');
    Route::get('editar/{id}', 'PontoColetaController@edit');
    Route::get('listar', 'PontoColetaController@listar');
});


//Route::prefix('tipo-residuo')->middleware('auth')->group(function () {
Route::prefix('triagem')->group(function () {
    Route::get('/', 'TriagemController@index');
    Route::get('index', 'TriagemController@index');
    Route::get('cadastrar', 'TriagemController@create');
    Route::get('editar/{id}', 'TriagemController@edit');
    Route::get('listar', 'TriagemController@listar');
});


//Route::prefix('tipo-residuo')->middleware('auth')->group(function () {
Route::prefix('rota')->group(function () {
    Route::get('/', 'RotaController@index')->name('rota');
    Route::get('index', 'RotaController@index')->name('rota.index');
    Route::get('cadastrar', 'RotaController@create')->name('rota.cadastrar');
    Route::get('editar/{id}', 'RotaController@edit')->name('rota.editar');
    Route::get('listar', 'RotaController@listar')->name('rota.listar');
});
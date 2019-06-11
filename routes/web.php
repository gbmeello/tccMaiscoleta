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

// Route::get('/', function () {
//     return view('auth.login');
// });

// Auth::routes();

// Route::get('/login', function () { return view('auth.login'); });
// Route::post('auth/login', 'Auth/LoginController@authenticate');

// // Route::get('/home', 'HomeController@index')->name('home');

// Route::group(['middleware' => ['web']], function() {

    Route::get('', 'DashboardController@index');
    Route::get('/', 'DashboardController@index');

    Route::prefix('dashboard', function () {
        Route::get('/', 'DashboardController@index');
        Route::get('index', 'DashboardController@index');
    });

    Route::prefix('tipo-residuo')->group(function () {
        Route::get('/', 'TipoResiduoController@index');
        Route::get('index', 'TipoResiduoController@index');
        Route::get('cadastrar', 'TipoResiduoController@create');
        Route::get('editar/{id}', 'TipoResiduoController@edit');
        Route::get('listar', 'TipoResiduoController@listar');
    });


    Route::prefix('usuario')->group(function () {
        Route::get('/', 'UsuarioController@index');
        Route::get('index', 'UsuarioController@index');
        Route::get('cadastrar', 'UsuarioController@create');
        Route::get('editar/{id}', 'UsuarioController@edit');
        Route::get('listar', 'UsuarioController@listar');
    });


    Route::prefix('coleta')->group(function () {
        Route::get('/', 'ColetaController@index');
        Route::get('index', 'ColetaController@index');
        Route::get('cadastrar', 'ColetaController@create');
        Route::get('editar/{id}', 'ColetaController@edit');
        Route::get('listar', 'ColetaController@listar');
    });


    Route::prefix('veiculo')->group(function () {
        Route::get('/', 'VeiculoController@index');
        Route::get('index', 'VeiculoController@index');
        Route::get('cadastrar', 'VeiculoController@create');
        Route::get('editar/{id}', 'VeiculoController@edit');
        Route::get('listar', 'VeiculoController@listar');
    });


    Route::prefix('ponto-coleta')->group(function () {
        Route::get('/', 'PontoColetaController@index');
        Route::get('index', 'PontoColetaController@index');
        Route::get('cadastrar', 'PontoColetaController@create');
        Route::get('editar/{id}', 'PontoColetaController@edit');
        Route::get('listar', 'PontoColetaController@listar');
    });


    Route::prefix('triagem')->group(function () {
        Route::get('/', 'TriagemController@index');
        Route::get('index', 'TriagemController@index');
        Route::get('cadastrar', 'TriagemController@create');
        Route::get('editar/{id}', 'TriagemController@edit');
        Route::get('listar', 'TriagemController@listar');
    });


    Route::prefix('fornecedor')->group(function () {
        Route::get('/', 'FornecedorController@index');
        Route::get('index', 'FornecedorController@index');
        Route::get('cadastrar', 'FornecedorController@create');
        Route::get('editar/{id}', 'FornecedorController@edit');
        Route::get('listar', 'FornecedorController@listar');
    });


    Route::prefix('fardo')->group(function () {
        Route::get('/', 'FardoController@index');
        Route::get('index', 'FardoController@index');
        Route::get('cadastrar', 'FardoController@create');
        Route::get('editar/{id}', 'FardoController@edit');
        Route::get('listar', 'FardoController@listar');
    });


    Route::prefix('cliente-final')->group(function () {
        Route::get('/', 'ClienteFinalController@index');
        Route::get('index', 'ClienteFinalController@index');
        Route::get('cadastrar', 'ClienteFinalController@create');
        Route::get('editar/{id}', 'ClienteFinalController@edit');
        Route::get('listar', 'ClienteFinalController@listar');
    });


    Route::prefix('rota')->group(function () {
        Route::get('/', 'RotaController@index')->name('rota');
        Route::get('index', 'RotaController@index')->name('rota.index');
        Route::get('cadastrar', 'RotaController@create')->name('rota.cadastrar');
        Route::get('editar/{id}', 'RotaController@edit')->name('rota.editar');
        Route::get('listar', 'RotaController@listar')->name('rota.listar');
    });


// });
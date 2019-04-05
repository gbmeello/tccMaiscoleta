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


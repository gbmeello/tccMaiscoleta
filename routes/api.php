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

Route::prefix('api')->group(function() {

    Route::prefix('tipo-residuo')->group(function() {

        Route::get('/tipo-residuo', 'TaskController@list')->name('tipo_residuo.list');

        Route::post('/tipo-residuo', 'TipoResiduoController@store')->name('tipo_residuo.store');

        Route::get('/tipo-residuo/{id}', 'TipoResiduoController@show')->name('tipo_residuo.show');

        Route::put('/tipo-residuo/{id}', 'TipoResiduoController@update')->name('tipo_residuo.update');

        Route::delete('/tipo-residuo/{id}', 'TipoResiduoController@delete')->name('tipo_residuo.delete');

    });

});


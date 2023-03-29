<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication
Route::prefix('auth')->group(function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/signup', 'AuthController@signup');
});

// Categoria produto
Route::prefix('/categorias')->middleware('auth:api')->group(function () {
    Route::get('/list', 'CateogriaProductoController@list');
});

// Producto
Route::prefix('/productos')->middleware('auth:api')->group(function () {
    Route::get('/', 'ProductoController@search');
    Route::post('/create', 'ProductoController@create');
    Route::put('/update/{id}', 'ProductoController@update');
    Route::get('/show/{id}', 'ProductoController@show');
    Route::delete('/delete/{id}', 'ProductoController@delete');
    Route::get('/puntos-venta', 'ProductoController@puntosVenta');
    Route::get('/aditamentos/{id}', 'ProductoController@aditamentos');
    Route::post('/aditamentos/create', 'ProductoController@addAditamento');
    Route::delete('/aditamentos/remove/{id}', 'ProductoController@removeAditamento');
});

// Producto
Route::prefix('/ventas')->middleware('auth:api')->group(function () {
    Route::get('/', 'VentaController@index');
    Route::post('/create', 'VentaController@create');
    Route::get('/show/{id}', 'VentaController@show');
    Route::delete('/delete/{id}', 'VentaController@delete');
});
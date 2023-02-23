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

// Producto
Route::prefix('/productos')->middleware('auth:api')->group(function () {
    Route::get('/', 'ProductoController@search');
    Route::post('/create', 'ProductoController@create');
    Route::put('/upate', 'ProductoController@update');
    Route::get('/show', 'ProductoController@show');
    Route::delete('/delete', 'ProductoController@delete');
    Route::get('/puntos-venta', 'ProductoController@puntosVenta');
});
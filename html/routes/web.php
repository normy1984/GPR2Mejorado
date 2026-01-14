<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/test-log', function () {
    Log::error('MENSAJE DE PRUEBA LOG FILE RUTA');
    return 'Log enviado!';
});Route::get('/test-log', function () {
    Log::error('MENSAJE DE PRUEBA LOG FILE RUTA');
    return 'Log enviado!';
});

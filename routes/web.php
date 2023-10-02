<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Ruta para mostrar el formulario de inicio de sesión
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');

// Ruta para procesar la solicitud de inicio de sesión
Route::post('/login', 'Auth\LoginController@login')->name('login.submit');

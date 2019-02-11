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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/view-register', function () {
    return view('usuarios.register');
});
Route::get('/edit-company', function () {
    return view('empresa.editar-empresa');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

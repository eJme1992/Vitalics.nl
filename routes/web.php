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
Route::get('/user-empresa', function () {
    return view('usuarios.user-empresa');
});
Route::get('/services', function () {
    return view('servicios.services-list');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::resource('empresas', 'EmpresasController');
Route::post('registrar_empresa', 'EmpresasController@store');

Route::resource('usuarios', 'UsersController');
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

//Rutas de autentificacion url
Auth::routes();
//Home Url
Route::get('/home', 'HomeController@index')->name('home');
//Empresas URL 
Route::resource('empresas', 'EmpresasController');
Route::post('registrar_empresa', 'EmpresasController@nuevaempresa');
Route::get('listadeempresas', 'EmpresasController@todasmisempresas');
//Usuario Url
Route::resource('usuarios', 'UsersController');
Route::post('usuarios/nuevo', 'UsersController@crearusuario')->name('usuarios.nuevo');
Route::resource('notificacion', 'NotificacionController');



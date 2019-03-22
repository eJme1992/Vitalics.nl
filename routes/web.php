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
//Vamos a app/Http/Kernerl.php y desactivamos la línea \App\Http\Middleware\VerifyCsrfToken::class,
Route::resource('servicios', 'serviciosController');
Route::post('registrar_servicio', 'serviciosController@nuevoservicio');
Route::post('editar_servicio', 'serviciosController@editservicio');
Route::get('listadeservicios', 'serviciosController@todosmisservicios');
Route::get('verservicio/{id}', 'serviciosController@verservicio');

// Route::resource('seccioness', 'seccionessController');
// Route::post('registrar_secciones', 'seccionessController@nuevosecciones');
// Route::post('editar_secciones', 'seccionessController@editsecciones');
// Route::get('listadeseccioness', 'seccionessController@todosmisseccioness');
// Route::get('versecciones/{id}', 'seccionessController@verservicio');
//Usuario Url
Route::resource('usuarios', 'UsersController');
Route::post('usuarios/nuevo', 'UsersController@crearusuario')->name('usuarios.nuevo');
Route::delete('usuarios/delete/{usuario}','UsersController@delete')->name('usuarios.delete'); ##DESPEDIR USUARIO

Route::post('servicios/filtrar', 'ServiciosController@filtros')->name('servicios.filtro');
Route::resource('notificacion', 'NotificacionController');
Route::get('/importar-empleados','ExcelController@index')->name('excel.index');
Route::post('/importando','ExcelController@importExcel')->name('excel.import');


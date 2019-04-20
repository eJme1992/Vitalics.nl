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

// Store Point
Route::resource('/point','StorePointController');
//Route::post('/pago', 'StorePointController@store');


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
Route::get('verempresa/{id}', 'EmpresasController@verempresa');
//Vamos a app/Http/Kernerl.php y desactivamos la línea \App\Http\Middleware\VerifyCsrfToken::class,
Route::resource('servicios', 'serviciosController');
Route::post('registrar_servicio', 'serviciosController@nuevoservicio');
Route::post('editar_servicio', 'serviciosController@editservicio');
Route::get('listadeservicios', 'serviciosController@todosmisservicios');
Route::get('verservicio/{id}', 'serviciosController@verservicio');

 Route::resource('seccioness',           'SectionsController');
 Route::post('registrar_secciones',      'SectionsController@nuevosection');
 Route::post('editar_secciones',         'SectionsController@editsecciones');
 Route::get('listadeseccioness/{id}',    'SectionsController@todosmisseccioness');
 Route::get('versecciones/{id}',         'SectionsController@versecciones');


 Route::post('registrar_fechas', 'FechasController@nuevoFecha');
 Route::post('editar_fechas',    'FechasController@editfechas');
 Route::get('listadefechas/{id}',    'FechasController@todosmisfechas');
 Route::get('verfechas/{id}',    'FechasController@verfechas');

//Usuario Url
Route::resource('usuarios', 'UsersController');
Route::post('usuarios/nuevo', 'UsersController@crearusuario')->name('usuarios.nuevo');
Route::delete('usuarios/delete/{usuario}','UsersController@delete')->name('usuarios.delete'); ##DESPEDIR USUARIO

Route::post('servicios/filtrar', 'ServiciosController@filtros')->name('servicios.filtro');
Route::resource('notificacion', 'NotificacionController');
Route::get('/importar-empleados','ExcelController@index')->name('excel.index');
Route::post('/importando','ExcelController@importExcel')->name('excel.import');

Route::get('/asignar-puntos', 'EmpresasController@asignarPuntos')->name('asignar.puntos');
Route::post('/save-puntos', 'EmpresasController@savePuntos')->name('save.puntos');
Route::post('/search-employee', 'EmpresasController@filtro')->name('user.filtro');

Route::post('/assign-points/{usuario}', 'UsersController@asignarPuntos')->name('user.puntos');



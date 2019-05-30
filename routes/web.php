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

Route::group(['middleware'=>['guest']],function(){
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware'=>['auth']],function(){

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');
    

    Route::group(['middleware'=>['Administrador']],function(){
        Route::get('/insumos', 'InsumosController@index');
        Route::post('/insumos/registrar', 'InsumosController@store');
        Route::put('/insumos/actualizar', 'InsumosController@update');
        Route::put('/insumos/desactivar', 'InsumosController@desactivar');
        Route::put('/insumos/activar', 'InsumosController@activar');
        Route::get('/insumos/buscarInsumoServicio', 'InsumosController@buscarInsumoServicio');
        Route::get('/insumos/buscarInsumoMantenimiento', 'InsumosController@buscarInsumoMantenimiento');
        Route::get('/insumos/listarInsumo', 'InsumosController@listarInsumo');


        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::put('/cliente/desactivar', 'ClienteController@desactivar');
        Route::put('/cliente/activar', 'ClienteController@activar');
        Route::get('/cliente/selectCliente','ClienteController@selectCliente');
        
        Route::get('/rol','RolController@index' );
        Route::get('/rol/selectRol','RolController@selectRol' );
        Route::put('/rol/desactivar', 'RolController@desactivar');
        Route::put('/rol/activar', 'RolController@activar');
        
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');
        
        
        Route::get('/vehiculo','VehiculoController@index' );
        Route::post('/vehiculo/registrar', 'VehiculoController@store');
        Route::put('/vehiculo/actualizar', 'VehiculoController@update');
        Route::get('/vehiculo/selectVehiculo','VehiculoController@selectVehiculo' );
        Route::put('/vehiculo/desactivar', 'VehiculoController@desactivar');
        Route::put('/vehiculo/activar', 'VehiculoController@activar');
        Route::get('/vehiculo/selectVehicu','VehiculoController@selectVehicu');
        
        Route::get('/chofer', 'ChoferController@index');
        Route::post('/chofer/registrar', 'ChoferController@store');
        Route::put('/chofer/actualizar', 'ChoferController@update');
        Route::put('/chofer/desactivar', 'ChoferController@desactivar');
        Route::put('/chofer/activar', 'ChoferController@activar');

        Route::get('/servicio', 'ServicioController@index');
        Route::post('/servicio/registrar', 'ServicioController@store');
        Route::put('/servicio/desactivar', 'ServicioController@desactivar');
        Route::put('/servicio/activar', 'ServicioController@activar');
        Route::get('/servicio/obtenerCabecera', 'ServicioController@obtenerCabecera');
        Route::get('/servicio/obtenerDetalles', 'ServicioController@obtenerDetalles');
        Route::get('/servicio/selectServicio','ServicioController@selectServicio');


        Route::get('/mantenimiento', 'MantenimientoController@index');
        Route::post('/mantenimiento/registrar', 'MantenimientoController@store');
        Route::put('/mantenimiento/desactivar', 'MantenimientoController@desactivar');
        Route::put('/mantenimiento/activar', 'MantenimientoController@activar');
        Route::get('/mantenimiento/obtenerCabecera', 'MantenimientoController@obtenerCabecera');
        Route::get('/mantenimiento/obtenerDetalles', 'MantenimientoController@obtenerDetalles');

        Route::get('/devolucion', 'DevolucionController@index');
        Route::post('/devolucion/registrar', 'DevolucionController@store');
        Route::put('/devolucion/desactivar', 'DevolucionController@desactivar');
        Route::put('/devolucion/activar', 'DevolucionController@activar');
        Route::get('/devolucion/obtenerCabecera', 'DevolucionController@obtenerCabecera');
        Route::get('/devolucion/obtenerDetalles', 'DevolucionController@obtenerDetalles');
    });

    Route::group(['middleware'=>['Almacenero']],function(){
        Route::get('/insumos', 'InsumosController@index');
        Route::post('/insumos/registrar', 'InsumosController@store');
        Route::put('/insumos/actualizar', 'InsumosController@update');
        Route::put('/insumos/desactivar', 'InsumosController@desactivar');
        Route::put('/insumos/activar', 'InsumosController@activar');
        
     
    });

    Route::group(['middleware'=>['Vendedor']],function(){
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::put('/cliente/desactivar', 'ClienteController@desactivar');
        Route::put('/cliente/activar', 'ClienteController@activar');
        Route::get('/cliente/selectCliente','ClienteController@selectCliente');

        Route::get('/servicio', 'ServicioController@index');
        Route::post('/servicio/registrar', 'ServicioController@store');
        Route::put('/servicio/desactivar', 'ServicioController@desactivar');
        Route::put('/servicio/activar', 'ServicioController@activar');
        Route::get('/servicio/obtenerCabecera', 'ServicioController@obtenerCabecera');
        Route::get('/servicio/obtenerDetalles', 'ServicioController@obtenerDetalles');

        Route::get('/vehiculo/selectVehicu','VehiculoController@selectVehicu');

        Route::get('/insumos/buscarInsumoServicio', 'InsumosController@buscarInsumoServicio');
        Route::get('/insumos/listarInsumo', 'InsumosController@listarInsumo');
    });

    Route::group(['middleware'=>['Vigilante']],function(){
        
    });

    Route::group(['middleware'=>['Mecanico']],function(){
        Route::get('/mantenimiento', 'MantenimientoController@index');
        Route::post('/mantenimiento/registrar', 'MantenimientoController@store');
        Route::put('/mantenimiento/desactivar', 'MantenimientoController@desactivar');
        Route::put('/mantenimiento/activar', 'MantenimientoController@activar');
        Route::get('/mantenimiento/obtenerCabecera', 'MantenimientoController@obtenerCabecera');
        Route::get('/mantenimiento/obtenerDetalles', 'MantenimientoController@obtenerDetalles');

        Route::get('/vehiculo/selectVehicu','VehiculoController@selectVehicu');

        Route::get('/insumos/buscarInsumoMantenimiento', 'InsumosController@buscarInsumoMantenimiento');
        Route::get('/insumos/listarInsumo', 'InsumosController@listarInsumo');
    });

  
 
    
    
    
});





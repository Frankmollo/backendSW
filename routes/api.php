<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\CheckPermission;
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isUserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * RUTAS PUBLICAS
 */

Route::post('/registro', [AuthController::class, 'register']);
Route::post('/registroA', [AuthController::class, 'registroAdmin']);
Route::post('/login', [AuthController::class, 'login']);

/***
 * RUTAS PRIVADAS
 */

 Route::middleware(['auth.user'])->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::post('/logout', 'logout');
        Route::get('/perfil', 'getUser');
    });


    Route::middleware(['permission:ver_roles|crear_roles|eliminar_roles|actualizar_roles'])->group(function () {
        Route::middleware(['permission:ver_roles'])->get('/rol', [RolController::class, 'getRoles']);
        Route::middleware(['permission:crear_roles'])->post('/rol', [RolController::class, 'crearRol']);
        Route::middleware(['permission:actualizar_roles'])->put('/rol/{id}', [RolController::class, 'actualizarRol']);
        Route::middleware(['permission:eliminar_roles'])->delete('/rol/{id}', [RolController::class, 'eliminarRol']);

        //Route::middleware(['permission:eliminar_roles'])->get('/permisos/{id}', [RolController::class, 'eliminarRol']);
    });

    Route::middleware(['permission:ver_permisos_rol|actualizar_permisos_rol'])->group(function () {
        //Route::middleware(['permission:ver_roles'])->get('/rol', [RolController::class, 'getRoles']);
        //Route::middleware(['permission:crear_roles'])->post('/rol', [RolController::class, 'crearRol']);
        //Route::middleware(['permission:actualizar_roles'])->put('/rol/{id}', [RolController::class, 'actualizarRol']);
        //Route::middleware(['permission:eliminar_roles'])->delete('/rol/{id}', [RolController::class, 'eliminarRol']); 

        Route::middleware(['permission:ver_permisos_rol'])->get('/roles/{rol_id}/permisos', [PermisoController::class, 'verPermisosRol']);
        Route::middleware(['permission:actualizar_permisos_rol'])->put('/roles/{rol_id}/permisos', [PermisoController::class, 'actualizarPermisosRol']);
    });

    Route::middleware(['permission:ver_usuarios|crear_usuarios|eliminar_usuarios|actualizar_usuarios'])->group(function () {
        Route::middleware(['permission:ver_usuarios'])->get('/usuario', [UsuarioController::class, 'verUsuarios']);
        Route::middleware(['permission:crear_usuarios'])->post('/usuario', [UsuarioController::class, 'crearUsuario']);
        Route::middleware(['permission:actualizar_usuarios'])->put('/usuario/{id}', [UsuarioController::class, 'actualizarUsuario']);
        Route::middleware(['permission:eliminar_usuarios'])->delete('/usuario/{id}', [UsuarioController::class, 'eliminarUsuario']);
    });

    
 });

 /*
 Route::middleware([isAdmin::class])->group(function(){
    Route::controller(AuthController::class)->group(function(){
        
        Route::get('/usuarios', 'getUsers');
    });
 });
 */


  // Rutas con permisos específicos


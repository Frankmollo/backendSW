<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\EjemploController;
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

    Route::middleware(['permission:ver_categorias|crear_categorias|eliminar_categorias|actualizar_categorias'])->group(function(){
        Route::middleware(['permission:ver_categorias'])->get('/categoria',[CategoriaController::class, 'verCategorias']);
        Route::middleware(['permission:crear_categorias'])->post('/categoria',[CategoriaController::class, 'crearCategoria']);
        Route::middleware(['permission:actualizar_categorias'])->put('/categoria/{id}',[CategoriaController::class, 'actualizarCategoria']);
        Route::middleware(['permission:eliminar_categorias'])->delete('/categoria/{id}',[CategoriaController::class, 'eliminarCategoria']);
    });

    Route::middleware(['permission:ver_cursos|crear_curso|eliminar_curso|actualizar_curso|ver_curso_categoria|ver_curso_docente'])->group(function(){
        Route::middleware(['permission:ver_cursos'])->get('/curso',[CursoController::class, 'verCursos']);
        Route::middleware(['permission:crear_curso'])->post('/curso',[CursoController::class, 'crearCurso']);
        Route::middleware(['permission:actualizar_curso'])->put('/curso/{id}',[CursoController::class, 'actualizarCurso']);
        Route::middleware(['permission:eliminar_curso'])->delete('/curso/{id}',[CursoController::class, 'eliminarCurso']);
        Route::middleware(['permission:ver_curso_categoria'])->get('/curso/categoria/{id}',[CursoController::class, 'verCursoCategoria']);
        Route::middleware(['permission:ver_curso_docente'])->get('/curso/docente/{id}',[CursoController::class, 'verCursoDocente']);
    });

    Route::middleware(['permission:ver_temas|crear_tema|eliminar_tema|actualizar_tema|ver_tema_curso'])->group(function(){
        Route::middleware(['permission:ver_temas'])->get('/tema',[TemaController::class, 'verTemas']);
        Route::middleware(['permission:crear_tema'])->post('/tema',[TemaController::class, 'crearTema']);
        Route::middleware(['permission:actualizar_tema'])->put('/tema/{id}',[TemaController::class, 'actualizarTema']);
        Route::middleware(['permission:eliminar_tema'])->delete('/tema/{id}',[TemaController::class, 'eliminarTema']);
        Route::middleware(['permission:ver_tema_curso'])->get('/tema/curso/{id}',[TemaController::class, 'verTemaCurso']);
    });

    Route::middleware(['permission:ver_ejemplos|crear_ejemplo|eliminar_ejemplo|actualizar_ejemplo|ver_ejemplo_tema'])->group(function(){
        Route::middleware(['permission:ver_ejemplos'])->get('/ejemplo',[EjemploController::class, 'verEjemplos']);
        Route::middleware(['permission:crear_ejemplo'])->post('/ejemplo',[EjemploController::class, 'crearEjemplo']);
        Route::middleware(['permission:actualizar_ejemplo'])->put('/ejemplo/{id}',[EjemploController::class, 'actualizarEjemplo']);
        Route::middleware(['permission:eliminar_ejemplo'])->delete('/ejemplo/{id}',[EjemploController::class, 'eliminarEjemplo']);
        Route::middleware(['permission:ver_ejemplo_tema'])->get('/ejemplo/tema/{id}',[EjemploController::class, 'verEjemploTema']);
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


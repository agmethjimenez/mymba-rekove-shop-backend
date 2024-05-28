<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

#RUTAS DE USUARIO
//Insertar
Route::post('/usuario',[UsuarioController::class,'InsertUser']);
//Actualizar
Route::put('/usuarios/update',[UsuarioController::class,'UpdateDatos']);
//Buscar por id
Route::get('/usuarios/{id}',[UsuarioController::class, 'usuarioPorid']);
//Buscar todos
Route::get('/usuarios',[UsuarioController::class,'usuariosTodos']);
//Desactivar
Route::delete('/usuarios/{id}',[UsuarioController::class, 'desactivarUsuario']);


#LOGIN
Route::post('/login',[UsuarioController::class, 'login']);


#RECUPERACION CONTRASEÑA
Route::post('/clave/restaurar',[UsuarioController::class, 'enviarCorreoDeRecuperacion']);
Route::post('/clave/validar',[UsuarioController::class,'validarExistenciaytoken']);
Route::post('/clave/corregir');


#RUTAS DE PROVEEDOR
Route::get('/proveedores',[ProveedorController::class, 'allProveedors']);
Route::get('/proveedores/{id}',[ProveedorController::class,'OneProveedors']);
Route::post('/proveedores',[ProveedorController::class,'CreateProveedor']);


#RUTAS ADMINISTRADOR
Route::post('/admin/create',[adminController::class,'registro']);
Route::put('/admin/update', [adminController::class, 'update']);
Route::post('/admin/restaurar',[adminController::class, 'changePassword']);




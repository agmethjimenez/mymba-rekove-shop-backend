<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\UsuarioController;
use App\Models\Marca;
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
Route::delete('/usuarios/{id}/{token}',[UsuarioController::class, 'desactivarUsuario']);


#LOGIN
Route::post('/login',[UsuarioController::class, 'login']);


#CAMBIO DE CLAVE
Route::post('/credencial/cambioclave',[UsuarioController::class, 'CambioClave']);


#RECUPERACION CONTRASEÑA
Route::post('/clave/restaurar',[UsuarioController::class, 'enviarCorreoDeRecuperacion']);
Route::post('/clave/validar',[UsuarioController::class,'validarExistenciaytoken']);
Route::post('/clave/corregir',[UsuarioController::class, 'correccionClave']);


#RUTAS DE PROVEEDOR
Route::get('/proveedores',[ProveedorController::class, 'allProveedors']);
Route::get('/proveedores/{id}',[ProveedorController::class,'OneProveedors']);
Route::post('/proveedores',[ProveedorController::class,'CreateProveedor']);
Route::put("/proveedores",[ProveedorController::class,'updateProveedor']);
Route::delete('/proveedores/delete/{id}/{token}',[ProveedorController::class,'desactivarProveedor']);

#RUTAS ADMINISTRADOR
Route::get('/admin/all',[adminController::class,'getAdmins']);
Route::get('/admin/read',[adminController::class,'searchByToken']);

Route::post('/admin/create',[adminController::class,'registro']);
Route::put('/admin/update', [adminController::class, 'update']);
Route::post('/admin/restaurar',[adminController::class, 'changePassword']);

#RUTA DE PEDIDO
Route::get('/pedidos', [PedidoController::class, 'getPedidos']);
Route::post('/pedidos/create',[PedidoController::class,'createPedido']);
Route::get('/pedidos/{id}', [PedidoController::class, 'getPedidos']);
Route::get('/usuario/pedido/{id}',[PedidoController::class,'getPedidoUser']);
Route::put('/pedidos/update/{id}/{estado}/{token}',[PedidoController::class,'updatePedido']);

#RUTAS DE PRODUCTO
Route::post('/productos/update',[ProductoController::class,'updateProducto']);
Route::get('/productos/read',[ProductoController::class,'getProductos']);
Route::post('/producto/create',[ProductoController::class,'createProducto']);
Route::get('/productos/read/{id}',[ProductoController::class,'getOneProducto']);
Route::delete('/productos/delete/{id}/{token}',[ProductoController::class,'desactivarProducto']);


#RUTA CATEGORIA
Route::get('/categorias',[CategoriaController::class,'getCategorias']);

#RUTA MARCAS
Route::get('/marcas',[MarcaController::class,'getMarcas']);
#RUTA DE ESTADOS
Route::get('/estados',[EstadoController::class,'getEstados']);

<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function getProductos(Request $request,)
    {
        $id = $request->query('id',null);
        $categoria = $request->query('ct',null);
        $name = $request->query('nm',null);
        $productos = Producto::getProductos($id,$name,$categoria);

        return response()->json($productos,200);

    }
    public function getOneProducto($id){
        return response()->json(Producto::getOneProducto($id),200);
    }

    public function createProducto(Request $request){
        $producto = Producto::createProducto([
            'proveedor'=>$request->proveedor,
            'nombre'=>$request->nombre,
            'descripcion'=>$request->descripcion,
            'contenido'=>$request->contenido,
            'precio'=>$request->precio,
            'marca'=>$request->marca,
            'categoria'=>$request->categoria,
            'stock'=>$request->stock,
            'imagen'=> $request->imagen,
            'admin'=>$request->admin
        ]);

        if(!$producto['status']){
            return response()->json($producto,400);
        }
        return response()->json($producto,200);
    }
}

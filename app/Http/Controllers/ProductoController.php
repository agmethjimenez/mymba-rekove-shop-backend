<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
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

    public function updateProducto(Request $request)
    {
        $request->validate([
            'id'=> 'required',
            'proveedor' => 'required',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'contenido' => 'required|string',
            'precio' => 'required|numeric',
            'marca' => 'required',
            'categoria' => 'required',
            'stock' => 'required|integer',
            'imagen' => 'nullable|string', 
        ]);

        $data = $request->all();
  
        $result = Producto::updateProducto($request->id, $data);

        if($result['status']){
            return response()->json([
                'status' => true,
                'message' => $result['mensaje'],
                'producto' => $result['producto']
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => $result['mensaje']
            ], 400);
        }
    }

    public function desactivarProducto($id,$token){
        $admin = Administrador::where('token',$token)->first();
        if(!$admin){
            return response()->json([
                "status" => true,
                "mensaje" => "Acceso no autorizado"
            ],401);
        }

        $response = Producto::desactivarProducto($id);
        if(!$response['status']){
            return response()->json($response, 400);
        }

        return response()->json($response,200);

    }
}

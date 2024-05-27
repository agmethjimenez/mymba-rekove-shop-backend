<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProveedorController extends Controller
{
    public function allProveedors(){
        return response()->json(Proveedor::getAllProveedores());
    }

    public function OneProveedors($id){
        return response()->json(Proveedor::getProveedorById($id));
    }

    public function CreateProveedor(Request $request){
        $request->validate([
            "nombre"=>'required',
            "ciudad"=>'required',
            "correo"=>'required|email',
            "telefono" => 'required'
        ]);
        $proveedor = Proveedor::createProveedor([
            "nombre" => $request->nombre,
            "ciudad"=> $request->ciudad,
            "correo"=> $request->correo,
            "telefono"=> $request->telefono
        ]);

        if(!$proveedor){
            return response()->json([
                "status"=>false,
                "mensaje"=>"Error al insertar proveedor"
            ],400);
        }

        return response()->json([
            "status"=>true,
            "proveedor"=>$proveedor
        ]);
    }
}

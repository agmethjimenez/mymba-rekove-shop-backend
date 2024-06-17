<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProveedorController extends Controller
{
    public function allProveedors(Request $request)
    {
        $query = $request->query('pv');
        if ($query) {
            $proveedores = Proveedor::searchProveedoresByName($query);
            return response()->json(['status' => true, 'proveedores' => $proveedores]);
        }
        return response()->json(['status' => true, 'proveedores' => Proveedor::getAllProveedores()]);
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

    public function updateProveedor(Request $request){
        $request->validate([
            "id"=>'required',
            "nombre"=>'required',
            "ciudad"=>'required',
            "correo"=>'required|email',
            "telefono" => 'required',
            "estado"=>'required'
        ]);
        $proveedor = Proveedor::updateProveedor($request->id,[
            "nombre" => $request->nombre,
            "ciudad"=> $request->ciudad,
            "correo"=> $request->correo,
            "telefono"=> $request->telefono,
            "estado"=> $request->estado
        ]);

        if(!$proveedor['status']){
            return response()->json([
                "status"=>false,
                "mensaje"=>$proveedor['mensaje'],
            ],400);
        }

        return response()->json($proveedor);
    }
    public function desactivarProveedor($id,$token){
        $admin = Administrador::where('token',$token)->first();
        if(!$admin){
            return response()->json([
                "status" => true,
                "mensaje" => "Acceso no autorizado"
            ],401);
        }
        $response = Proveedor::deleteProveedor($id);
        if(!$response['status']){
            return response()->json($response, 400);
        }
        return response()->json($response,200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function getPedidos($id = null)
{
    if($id){
        $pedido = Pedido::where('idPedido', $id)->with([
            'usuario', 
            'estado', 
            'detallespedido.producto.marca', 
            'detallespedido.producto.categoria'
        ])->first();

        if($pedido){
            $pedidoArray = $pedido->toArray();
            $pedidoArray['detalles_pago'] = json_decode($pedido->detalles_pago, true);
            return response()->json($pedidoArray, 200);
        }else{
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }
    }else{
        $pedidos = Pedido::with([
            'usuario', 
            'estado', 
            'detallespedido.producto.marca', 
            'detallespedido.producto.categoria'
        ])->get();
        
        $pedidosTransformados = $pedidos->map(function($pedido) {
            $pedidoArray = $pedido->toArray();
            $pedidoArray['detalles_pago'] = json_decode($pedido->detalles_pago, true);
            return $pedidoArray;
        });

        return response()->json($pedidosTransformados, 200);
    }
}
public function createPedido(Request $request){
    /*HttpClient::setBody([
    'usuario' => $_SESSION['id_usuario'],
    'datospago' => $datospago,
    'ciudad' => $ciudad,
    'direccion' => $direccion,
    'detalles' => $_SESSION['carrito'],
    'totalp' => $sumaTotal
]);*/
$insert = Pedido::InsertPedido([
    'usuario' => $request->usuario,
    'datospago' => $request->datospago,
    'ciudad' => $request->ciudad,
    'direccion' => $request->direccion,
    'detalles' => $request->detalles,
    'totalp' => $request->totalp
]);

if(!$insert['status']){
    return response()->json($insert,400);
}

return response()->json($insert,201);

}

public function getPedidoUser($id){
    $pedidos = Pedido::where('usuario',$id)->with([
        'usuario', 
        'estado', 
        'detallespedido.producto.marca', 
        'detallespedido.producto.categoria'
    ])->get();
    
    $pedidosTransformados = $pedidos->map(function($pedido) {
        $pedidoArray = $pedido->toArray();
        $pedidoArray['detalles_pago'] = json_decode($pedido->detalles_pago, true);
        return $pedidoArray;
    });

    return response()->json($pedidosTransformados, 200);
}

public function updatePedido($id,$estado,$token){
    $admin = Administrador::where('token',$token)->first();
    if(!$admin){
        return response()->json([
            "status" => false,
            "mensaje" => "Acceso no autorizado"
        ],401);
    }

    $response = Pedido::updatePedido($id, $estado);
    if(!$response['status']){
        return response()->json($response,400);
    }else{
        return response()->json($response,200);
    }
}

}

<?php

namespace App\Http\Controllers;

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

}

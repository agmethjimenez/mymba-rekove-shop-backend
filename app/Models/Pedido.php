<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    protected $primaryKey = 'idPedido';
    protected $fillable = [
        'idPedido',
        'usuario',
        'ciudad',
        'direccion',
        'fecha',
        'total',
        'detalles_pago',
        'estado'
    ];
    public $incrementing = false; 
    public $timestamps = false;

    public function usuario(){
        return $this->belongsTo(Usuario::class,'usuario','id');
    }
    public function estado(){
        return $this->belongsTo(Estado::class, 'estado', 'codEst');
    }
    public function detallespedido(){
        return $this->hasMany(DetallePedido::class, 'idPedido', 'idPedido');
    }
    

    public static function InsertPedido($data)
{
    // Asegúrate de que $data['datospago'] sea una cadena JSON
    $detallesPago = is_array($data['datospago']) ? json_encode($data['datospago']) : (string) $data['datospago'];

    // Crear el pedido
    $pedido = self::create([
        "idPedido" => substr(uniqid(), 0, 10),
        "usuario" => $data['usuario'],
        "ciudad" => $data['ciudad'],
        "direccion" => $data['direccion'],
        "fecha" => now(),
        "total" => $data['totalp'],
        "detalles_pago" => substr($detallesPago, 0, 255),
        "estado" => 1
    ]);

    if (!$pedido) {
        return [
            "status" => false,
            "mensaje" => "Error al insertar pedido"
        ];
    }

    // Crear los detalles del pedido
    foreach ($data['detalles'] as $detalle) {
        DetallePedido::create([
            "idPedido" => $pedido->idPedido,
            "idProducto" => $detalle['id'],
            "cantidad" => $detalle['cantidad'],
            "total" => $detalle['total']
        ]);

        // Actualizar la cantidad disponible del producto
        $producto = Producto::find($detalle['id']);
        if ($producto) {
            $producto->cantidadDisponible -= $detalle['cantidad'];
            $producto->save();
        }
    }

    return [
        'status' => true,
        'mensaje' => 'Pedido exitoso'
    ];
}


    public static function updatePedido($id, $estado){
        $pedido = self::find($id);
        
        if(!$pedido){
            return[
                "status"=>false,
                "mensaje"=>"Pedido no encontrado"
            ];
        }

        if($pedido->estado == $estado){
            return[
                "status"=>false,
                "mensaje"=>"El pedido ya se encuentra en este estado, seleccione otro"
            ];
        }

        $pedido->estado = $estado;
        $pedido->save();

        return[
            "status"=>true,
            "mensaje"=>"Pedido actualizado correctamente"
        ];

    }

}

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
        'usuario',
        'ciudad',
        'direccion',
        'fecha',
        'total',
        'detalles_pago',
        'estado'
    ];
    public $timestamps = false;

    public function usuario(){
        return $this->belongsTo(Usuario::class,'usuario','id');
    }
    public function detallespedido(){
        return $this->hasMany(DetallePedido::class,'idPedido');
    }
}

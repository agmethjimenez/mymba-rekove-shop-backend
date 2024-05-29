<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;
    protected $table = 'detallepedido';
    protected $primaryKey = ['idPedido','idProducto'];
    protected $fillable = [
        'idPedido',
        'idProducto',
        'cantidad',
        'total'
    ];
    public $incrementing = false; 
    public $timestamps = false;

    public function pedido(){
        return $this->belongsTo(Pedido::class,'idPedido','idPedido');
    }
    
    public function producto(){
        return $this->belongsTo(Producto::class,'idProducto','idProducto');
    }
    
}

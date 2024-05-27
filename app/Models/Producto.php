<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $primaryKey = 'idProducto';
    protected $fillable = [
        'proveedor',
        'nombre',
        'descripcionP',
        'contenido',
        'precio',
        'marca',
        'categoria',
        'cantidadDisponible',
        'imagen',
        'activo'
    ];
    public $timestamps = false;

    public function proveedor(){
        return $this->belongsTo(Proveedor::class,'proveedor','idProveedor');

    }
    public function marca(){
        return $this->belongsTo(Marca::class,'marca','idMarca');
    }
    public function categoria(){
        return $this->belongsTo(Categoria::class,'categoria','categoria');
    }
    public function detallespedido(){
        return $this->hasMany(DetallePedido::class,'idProducto','idProducto');
    }
}

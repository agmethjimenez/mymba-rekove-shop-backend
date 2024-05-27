<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedores';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'idProveedor',
        'nombreP',
        'ciudad',
        'correo',
        'telefono',
        'estado'
    ];
    public $timestamps = false;

    public function productos(){
        return $this->hasMany(Producto::class, 'proveedor','idProveedor');
    }

    public static function createProveedor($data){
        return self::create([
            "idProveedor"=> rand(100000,999999),
            "nombreP"=>$data['nombre'],
            "ciudad"=>$data['ciudad'],
            "correo"=>$data['correo'],
            "telefono"=>$data['telefono']
        ]);

    }

    public static function getProveedorById($id)
    {
        return self::where('idProveedor',$id)->first();
    }

    public static function getAllProveedores()
    {
        return self::all();
    }

}

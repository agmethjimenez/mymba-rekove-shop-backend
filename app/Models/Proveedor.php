<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedores';
    protected $primaryKey= 'idProveedor';
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

    public static function searchProveedoresByName($name)
    {
        return self::where('nombreP', 'LIKE', "%$name%")->get();
    }

    public static function searchProveedores($query)
    {
        return self::where('nombreP', 'LIKE', "%$query%")
                    ->orWhere('telefono', 'LIKE', "%$query%")
                    ->orWhere('correo', 'LIKE', "%$query%")
                    ->get();
    }

    public static function getAllProveedores()
    {
        return self::all();
    }

    public static function updateProveedor($id, $data){
        $proveedor = self::find($id);

        if (!$proveedor) {
            return[
                "status"=>false,
                "mensaje"=>"Proveedor no encontrado"
            ];
        }
        if (!$proveedor->activo) {
            return[
                "status"=>false,
                "mensaje"=>"Proveedor desactivado"
            ];
        }

        $proveedor->nombreP = $data['nombre'];
        $proveedor->ciudad = $data['ciudad'];
        $proveedor->correo = $data['correo'];
        $proveedor->telefono = $data['telefono'];
        $proveedor->estado = $data['estado'];

        $proveedor->save();

        return[
            "status"=>true,
            "mensaje"=>"Proveedor actualizado"
        ];
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $table = 'marcas';
    protected $primaryKey = 'idMarca';
    protected $fillable = ['marca'];
    public $timestamp = false;

    public function productos(){
        return $this->hasMany(Producto::class,'marca','idMarca');
    }

    public static function allMarcas(){
        return self::all();
    }

    static public function oneMarca($id){
        return self::find($id);
    }

    public static function createMarca($name){
        return self::create([
            "marca"=>$name
        ]);
    }

    public static function updateMarca($id, $name)
    {
        $marca = self::find($id);
        if ($marca) {
            $marca->marca = $name;
            $marca->save();
            return $marca;
        }
        return null;
    }

    public static function deleteMarca($id)
    {
        $marca = self::find($id);
        if ($marca) {
            $marca->delete();
            return true;
        }
        return false;
    }
    
}

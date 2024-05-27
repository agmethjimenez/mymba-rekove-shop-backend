<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $primaryKey = 'categoria';
    protected $fillable = ['descripcion'];
    public $timestamp = false;

    public function productos(){
        return $this->hasMany(Producto::class, 'categoria');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoAgregado extends Model
{
    use HasFactory;
    protected $table = 'productosagregados';
    protected $fillable = [
        'administrador',
        'producto',
        'agregado_el'
    ];

    public $timestamps = false;
    public $incrementing = false;
}

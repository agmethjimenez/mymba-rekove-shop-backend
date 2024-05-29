<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;
    protected $table = 'estados';
    protected $priamryKey = 'codEst';
    protected $fillable =['estado'];
    public $timestamps = false;
    
    public function detalles(){
        return $this->hasMany(Pedido::class,'estado','codEst');

    }
}

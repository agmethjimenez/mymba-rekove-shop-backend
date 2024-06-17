<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder\Function_;

use function Pest\Laravel\get;

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

    public static function getEstados(){
        return self::all();
    }
}

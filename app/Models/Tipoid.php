<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipoid extends Model
{
    use HasFactory;
    protected $table = 'tiposid';
    protected $primaryKey = 'codId';
    protected $fillable = ['id'];
    public $timestamps = false;

    public function usuarios(){
        return $this->hasMany(Usuario::class,'tipoId','codId');
    }
}

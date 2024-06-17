<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function getEstados(){
        return response()->json(Estado::all(),200);
    }
}

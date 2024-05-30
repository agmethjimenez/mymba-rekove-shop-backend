<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function getMarcas(){
        return response()->json(Marca::all(),200);
    }
}

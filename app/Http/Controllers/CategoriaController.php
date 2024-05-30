<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function getCategorias(){
        return response()->json(Categoria::all(),200);
    }
}

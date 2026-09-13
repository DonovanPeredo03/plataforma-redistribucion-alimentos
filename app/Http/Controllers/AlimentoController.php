<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use Illuminate\Http\Request;

class AlimentoController extends Controller
{
    public function index()
    {
    
        $alimentos = Alimento::with(['usuario'])->paginate(10);

        return view('alimentos.index', compact('alimentos'));
    }
}

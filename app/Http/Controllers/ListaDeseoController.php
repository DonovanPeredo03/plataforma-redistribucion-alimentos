<?php

namespace App\Http\Controllers;

use App\Models\ListaDeseo;
use Illuminate\Http\Request;

class ListaDeseoController extends Controller
{
    
    public function index()
    {
    
       $listaDeseo = ListaDeseo::with(['usuario'])->paginate(10);

        return view('lista_deseos.index', compact('listaDeseo'));
    }
}
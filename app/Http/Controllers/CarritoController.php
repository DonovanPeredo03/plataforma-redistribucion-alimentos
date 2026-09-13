<?php

namespace App\Http\Controllers;

use App\Models\Carrito;

class CarritoController extends Controller
{
    public function index()
    {
        
        $carritos = Carrito::with(['usuario', 'detalles.alimento'])->paginate(10);

        
        return view('carritos.index', compact('carritos'));
    }
}
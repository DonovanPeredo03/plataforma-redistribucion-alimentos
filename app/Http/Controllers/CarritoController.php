<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Usuario;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index()
    {
        $carritos = Carrito::with(['usuario', 'detalles.alimento'])->paginate(10);

        return view('carritos.index', compact('carritos'));
    }

    public function create()
    {
        $usuarios = Usuario::all();

        return view('carritos.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'estado' => 'required|string|max:20',
        ]);

        $idCarrito = (Carrito::max('id_carrito') ?? 0) + 1;

        Carrito::create([
            'id_carrito' => $idCarrito,
            'id_usuario' => $request->id_usuario,
            'fecha_creacion' => now(),
            'estado' => $request->estado,
        ]);

        return redirect()->route('carritos.index')
            ->with('success', 'Carrito registrado correctamente.');
    }
}
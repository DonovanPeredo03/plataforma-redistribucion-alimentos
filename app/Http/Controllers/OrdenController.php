<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\Usuario;
use Illuminate\Http\Request;

class OrdenController extends Controller
{
    public function index()
    {
        $ordenes = Orden::with(['usuario'])->paginate(10);
        return view('ordenes.index', compact('ordenes'));
    }

    public function create()
    {
        $usuarios = Usuario::orderBy('nombre')->get();

        return view('ordenes.create', compact('usuarios'));
    }

    public function store(Request $request)
{
    $request->validate([
        'id_usuario' => 'required|exists:usuarios,id_usuario',
        'fecha_entrega' => 'required|date|after_or_equal:today',
        'estado' => 'required|in:Pendiente,Aprobada,En Camino,Entregada',
        'observaciones' => 'required|string|max:1000',
    ]);

    $idOrden = (Orden::max('id_orden') ?? 0) + 1;

    Orden::create([
        'id_orden' => $idOrden,
        'id_usuario' => $request->id_usuario,
        'fecha_orden' => now(),
        'estado' => $request->estado,
        'fecha_entrega' => $request->fecha_entrega,
        'observaciones' => $request->observaciones,
    ]);

    return redirect()->route('ordenes.index')
        ->with('success', 'Orden registrada correctamente.');
}

}
<?php

namespace App\Http\Controllers;

use App\Models\ListaDeseo;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ListaDeseoController extends Controller
{
    public function index()
    {
        $listaDeseo = ListaDeseo::with(['usuario'])->paginate(10);

        return view('lista_deseos.index', compact('listaDeseo'));
    }

    public function create()
    {
        $usuarios = Usuario::orderBy('nombre')->get();

        return view('lista_deseos.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
        ]);

        $idLista = (ListaDeseo::max('id_lista') ?? 0) + 1;

        ListaDeseo::create([
            'id_lista' => $idLista,
            'id_usuario' => $request->id_usuario,
            'fecha_creacion' => now(),
        ]);

        return redirect()->route('lista_deseos.index')
            ->with('success', 'Lista de deseos creada correctamente.');
    }
}
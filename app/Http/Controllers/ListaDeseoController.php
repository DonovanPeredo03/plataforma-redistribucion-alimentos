<?php

namespace App\Http\Controllers;

use App\Models\ListaDeseo;
use App\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ListaDeseoController extends Controller
{
    public function index()
    {
        $listaDeseo = ListaDeseo::with(['usuario'])->orderByDesc('id_lista')->paginate(10);

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

    public function show($id)
    {
        $lista = ListaDeseo::with(['usuario', 'detalles.alimento'])->find($id);

        if (!$lista) {
            return redirect()->route('lista_deseos.index')
                ->with('error', 'La lista de deseos que intentas consultar no existe.');
        }

        return view('lista_deseos.show', compact('lista'));
    }

    public function edit($id)
    {
        $lista = ListaDeseo::find($id);

        if (!$lista) {
            return redirect()->route('lista_deseos.index')
                ->with('error', 'No fue posible editar: la lista de deseos no existe.');
        }

        $usuarios = Usuario::orderBy('nombre')->get();

        return view('lista_deseos.edit', compact('lista', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $lista = ListaDeseo::find($id);

        if (!$lista) {
            return redirect()->route('lista_deseos.index')
                ->with('error', 'No fue posible actualizar: la lista de deseos no existe.');
        }

        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
        ]);

        $lista->id_usuario = $request->id_usuario;
        $lista->save();

        return redirect()->route('lista_deseos.index')
            ->with('success', 'Lista de deseos actualizada correctamente.');
    }

    public function destroy($id)
    {
        $lista = ListaDeseo::find($id);

        if (!$lista) {
            return redirect()->route('lista_deseos.index')
                ->with('error', 'No fue posible eliminar: la lista de deseos no existe.');
        }

        try {
            $lista->delete();
        } catch (QueryException $e) {
            return redirect()->route('lista_deseos.index')
                ->with('error', 'No se puede eliminar la lista de deseos porque tiene alimentos asociados.');
        }

        return redirect()->route('lista_deseos.index')
            ->with('success', 'Lista de deseos eliminada correctamente.');
    }
}

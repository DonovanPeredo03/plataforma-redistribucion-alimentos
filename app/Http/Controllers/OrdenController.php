<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdenController extends Controller
{
    public function index()
    {
        $ordenes = Orden::with(['usuario'])->orderByDesc('id_orden')->paginate(10);
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

    public function show($id)
    {
        $orden = Orden::with(['usuario', 'detalles.alimento'])->find($id);

        if (!$orden) {
            return redirect()->route('ordenes.index')
                ->with('error', 'La orden que intentas consultar no existe.');
        }

        return view('ordenes.show', compact('orden'));
    }

    public function edit($id)
    {
        $orden = Orden::find($id);

        if (!$orden) {
            return redirect()->route('ordenes.index')
                ->with('error', 'No fue posible editar: la orden no existe.');
        }

        $usuarios = Usuario::orderBy('nombre')->get();

        return view('ordenes.edit', compact('orden', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $orden = Orden::find($id);

        if (!$orden) {
            return redirect()->route('ordenes.index')
                ->with('error', 'No fue posible actualizar: la orden no existe.');
        }

        $fechaEntregaOriginal = \Carbon\Carbon::parse($orden->fecha_entrega)->format('Y-m-d');

        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'fecha_entrega' => 'required|date',
            'estado' => 'required|in:Pendiente,Aprobada,En Camino,Entregada',
            'observaciones' => 'required|string|max:1000',
        ]);

        // Solo exigimos que la nueva fecha de entrega sea futura si el usuario realmente la modificó.
        $validator->after(function ($validator) use ($request, $fechaEntregaOriginal) {
            $fechaNueva = substr($request->fecha_entrega, 0, 10);
            if ($fechaNueva !== $fechaEntregaOriginal && $fechaNueva < date('Y-m-d')) {
                $validator->errors()->add('fecha_entrega', 'La nueva fecha de entrega debe ser hoy o una fecha futura.');
            }
        });

        $validator->validate();

        $orden->id_usuario = $request->id_usuario;
        $orden->fecha_entrega = $request->fecha_entrega;
        $orden->estado = $request->estado;
        $orden->observaciones = $request->observaciones;
        $orden->save();

        return redirect()->route('ordenes.index')
            ->with('success', 'Orden actualizada correctamente.');
    }

    public function destroy($id)
    {
        $orden = Orden::find($id);

        if (!$orden) {
            return redirect()->route('ordenes.index')
                ->with('error', 'No fue posible eliminar: la orden no existe.');
        }

        try {
            $orden->delete();
        } catch (QueryException $e) {
            return redirect()->route('ordenes.index')
                ->with('error', 'No se puede eliminar la orden porque tiene alimentos asociados en su detalle.');
        }

        return redirect()->route('ordenes.index')
            ->with('success', 'Orden eliminada correctamente.');
    }
}

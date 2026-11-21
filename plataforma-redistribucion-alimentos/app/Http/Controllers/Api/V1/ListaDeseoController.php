<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ListaDeseo;
use App\Models\ListaDeseoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListaDeseoController extends Controller
{
    // Consultar la lista de deseos del cliente
    public function index(Request $request)
    {
        $lista = ListaDeseo::with('detalles.alimento')
            ->where('id_usuario', $request->user()->id_usuario)
            ->first();

        if (!$lista) {
            return response()->json([
                'mensaje' => 'El cliente todavía no tiene una lista de deseos.'
            ], 200);
        }

        return response()->json($lista, 200);
    }

    // Agregar un alimento a la lista
    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_alimento' => 'required|exists:alimentos,id_alimento',
        ]);

        $usuario = $request->user();

        $lista = ListaDeseo::firstOrCreate(
            ['id_usuario' => $usuario->id_usuario],
            [
                'id_lista' => (ListaDeseo::max('id_lista') ?? 0) + 1,
                'fecha_creacion' => now(),
            ]
        );

        $existe = $lista->detalles()
            ->where('id_alimento', $datos['id_alimento'])
            ->exists();

        if ($existe) {
            return response()->json([
                'mensaje' => 'Este alimento ya está en tu lista de deseos.'
            ], 409);
        }

        DB::transaction(function () use ($lista, $datos) {
            $idDetalle = (ListaDeseoDetalle::max('id_detalle_lista') ?? 0) + 1;

            ListaDeseoDetalle::create([
                'id_detalle_lista' => $idDetalle,
                'id_lista' => $lista->id_lista,
                'id_alimento' => $datos['id_alimento'],
                'fecha_agregado' => now(),
            ]);
        });

        return response()->json([
            'mensaje' => 'Alimento agregado a tu lista de deseos.',
            'lista' => $lista->load('detalles.alimento'),
        ], 201);
    }

    // Eliminar un alimento de la lista
    public function destroy(Request $request, $id)
    {
        $lista = ListaDeseo::where(
            'id_usuario',
            $request->user()->id_usuario
        )->first();

        if (!$lista) {
            return response()->json([
                'mensaje' => 'No tienes una lista de deseos.'
            ], 404);
        }

        $detalle = $lista->detalles()
            ->where('id_detalle_lista', $id)
            ->first();

        if (!$detalle) {
            return response()->json([
                'mensaje' => 'El alimento no existe en tu lista de deseos.'
            ], 404);
        }

        $detalle->delete();

        return response()->json([
            'mensaje' => 'Alimento eliminado de tu lista de deseos.'
        ], 200);
    }
}

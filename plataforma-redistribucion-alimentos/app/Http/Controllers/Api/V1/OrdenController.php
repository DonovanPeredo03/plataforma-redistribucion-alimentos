<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenController extends Controller
{
    // ==========================================
    // OPERACIONES DEL CLIENTE
    // ==========================================

    // Consultar las órdenes del cliente autenticado
    public function index(Request $request)
    {
        $ordenes = Orden::with('detalles.alimento')
            ->where('id_usuario', $request->user()->id_usuario)
            ->orderByDesc('id_orden')
            ->paginate(10);

        return response()->json($ordenes, 200);
    }

    // Consultar una orden específica del cliente
    public function show(Request $request, $id)
    {
        $orden = Orden::with('detalles.alimento')
            ->where('id_usuario', $request->user()->id_usuario)
            ->find($id);

        if (!$orden) {
            return response()->json([
                'mensaje' => 'La orden no existe o no tienes permiso para consultarla.'
            ], 404);
        }

        return response()->json($orden, 200);
    }

    // Registrar una nueva orden
    public function store(Request $request)
    {
        $datos = $request->validate([
            'fecha_entrega' => 'required|date|after_or_equal:today',
            'observaciones' => 'required|string|max:1000',
            'detalles' => 'required|array|min:1',
            'detalles.*.id_alimento' => 'required|exists:alimentos,id_alimento',
            'detalles.*.cantidad' => 'required|numeric|min:0.01',
        ]);

        $orden = DB::transaction(function () use ($request, $datos) {

            $idOrden = (Orden::max('id_orden') ?? 0) + 1;

            $orden = Orden::create([
                'id_orden' => $idOrden,
                'id_usuario' => $request->user()->id_usuario,
                'fecha_orden' => now(),
                'estado' => 'Pendiente',
                'fecha_entrega' => $datos['fecha_entrega'],
                'observaciones' => $datos['observaciones'],
            ]);

            foreach ($datos['detalles'] as $detalle) {

                $idDetalle = (OrdenDetalle::max('id_detalle_orden') ?? 0) + 1;

                OrdenDetalle::create([
                    'id_detalle_orden' => $idDetalle,
                    'id_orden' => $idOrden,
                    'id_alimento' => $detalle['id_alimento'],
                    'cantidad' => $detalle['cantidad'],
                ]);
            }

            return $orden;
        });

        return response()->json([
            'mensaje' => 'Orden registrada correctamente.',
            'orden' => $orden->load('detalles.alimento'),
        ], 201);
    }


    // ==========================================
    // OPERACIONES DEL ADMINISTRADOR
    // ==========================================

    // Consultar todas las órdenes
    public function adminIndex()
    {
        $ordenes = Orden::with([
            'usuario',
            'detalles.alimento'
        ])
            ->orderByDesc('id_orden')
            ->paginate(10);

        return response()->json($ordenes, 200);
    }

    // Consultar una orden específica
    public function adminShow($id)
    {
        $orden = Orden::with([
            'usuario',
            'detalles.alimento'
        ])->find($id);

        if (!$orden) {
            return response()->json([
                'mensaje' => 'La orden solicitada no existe.'
            ], 404);
        }

        return response()->json($orden, 200);
    }

    // Actualizar el estado de una orden
    public function updateEstado(Request $request, $id)
    {
        $orden = Orden::find($id);

        if (!$orden) {
            return response()->json([
                'mensaje' => 'La orden solicitada no existe.'
            ], 404);
        }

        $datos = $request->validate([
            'estado' => 'required|in:Pendiente,Aprobada,En Camino,Entregada',
        ]);

        $orden->update([
            'estado' => $datos['estado'],
        ]);

        return response()->json([
            'mensaje' => 'Estado de la orden actualizado correctamente.',
            'orden' => $orden->fresh()->load([
                'usuario',
                'detalles.alimento'
            ]),
        ], 200);
    }
}

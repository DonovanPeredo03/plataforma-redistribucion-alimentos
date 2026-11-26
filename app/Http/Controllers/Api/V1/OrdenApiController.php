<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class OrdenApiController extends Controller
{
    // ==========================================
    // LISTAR TODAS LAS ÓRDENES
    // ==========================================
    public function index()
    {
        try {
            $ordenes = Orden::with('detalles.alimento', 'usuario')
                ->orderByDesc('id_orden')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'message' => 'Órdenes obtenidas correctamente.',
                'data' => $ordenes,
                'errors' => null
            ], 200);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las órdenes.',
                'data' => null,
                'errors' => null
            ], 500);
        }
    }

    // ==========================================
    // MOSTRAR UNA ORDEN
    // ==========================================
    public function show($id)
    {
        try {
            $orden = Orden::with('detalles.alimento', 'usuario')->find($id);

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'message' => 'La orden no existe.',
                    'data' => null,
                    'errors' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Orden encontrada correctamente.',
                'data' => $orden,
                'errors' => null
            ], 200);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Error al consultar la orden.',
                'data' => null,
                'errors' => null
            ], 500);
        }
    }

    // ==========================================
    // REGISTRAR UNA ORDEN
    // ==========================================
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|integer|exists:usuarios,id_usuario',
            'fecha_entrega' => 'required|date',
            'observaciones' => 'required|string|max:1000',

            'detalles' => 'required|array|min:1',
            'detalles.*.id_alimento' => 'required|integer|exists:alimentos,id_alimento',
            'detalles.*.cantidad' => 'required|numeric|min:0.01'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación.',
                'data' => null,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Generar ID de la orden
            $idOrden = (Orden::max('id_orden') ?? 0) + 1;

            // Crear orden
            $orden = Orden::create([
                'id_orden' => $idOrden,
                'id_usuario' => $request->id_usuario,
                'fecha_orden' => now(),
                'estado' => 'Pendiente',
                'fecha_entrega' => $request->fecha_entrega,
                'observaciones' => $request->observaciones
            ]);

            // Registrar los detalles de la orden
            foreach ($request->detalles as $detalle) {

                $idDetalle = (OrdenDetalle::max('id_detalle_orden') ?? 0) + 1;

                OrdenDetalle::create([
                    'id_detalle_orden' => $idDetalle,
                    'id_orden' => $idOrden,
                    'id_alimento' => $detalle['id_alimento'],
                    'cantidad' => $detalle['cantidad']
                ]);
            }

            DB::commit();

            $orden->load('detalles.alimento', 'usuario');

            return response()->json([
                'success' => true,
                'message' => 'Orden registrada correctamente.',
                'data' => $orden,
                'errors' => null
            ], 201);

        } catch (Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la orden.',
                'data' => null,
                'errors' => null
            ], 500);
        }
    }

    // ==========================================
    // ACTUALIZAR UNA ORDEN
    // ==========================================
    public function update(Request $request, $id)
    {
        $orden = Orden::find($id);

        if (!$orden) {
            return response()->json([
                'success' => false,
                'message' => 'La orden no existe.',
                'data' => null,
                'errors' => null
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'id_usuario' => 'sometimes|required|integer|exists:usuarios,id_usuario',
            'fecha_entrega' => 'sometimes|required|date',
            'observaciones' => 'sometimes|required|string|max:1000',
            'estado' => 'sometimes|required|in:Pendiente,Aprobada,En Camino,Entregada',

            'detalles' => 'sometimes|required|array|min:1',
            'detalles.*.id_alimento' => 'required_with:detalles|integer|exists:alimentos,id_alimento',
            'detalles.*.cantidad' => 'required_with:detalles|numeric|min:0.01'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación.',
                'data' => null,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Actualizar los datos generales
            $orden->update($request->only([
                'id_usuario',
                'fecha_entrega',
                'observaciones',
                'estado'
            ]));

            // Si se enviaron detalles nuevos, reemplazar los anteriores
            if ($request->has('detalles')) {

                $orden->detalles()->delete();

                foreach ($request->detalles as $detalle) {

                    $idDetalle = (OrdenDetalle::max('id_detalle_orden') ?? 0) + 1;

                    OrdenDetalle::create([
                        'id_detalle_orden' => $idDetalle,
                        'id_orden' => $id,
                        'id_alimento' => $detalle['id_alimento'],
                        'cantidad' => $detalle['cantidad']
                    ]);
                }
            }

            DB::commit();

            $orden->load('detalles.alimento', 'usuario');

            return response()->json([
                'success' => true,
                'message' => 'Orden actualizada correctamente.',
                'data' => $orden,
                'errors' => null
            ], 200);

        } catch (Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la orden.',
                'data' => null,
                'errors' => null
            ], 500);
        }
    }

    // ==========================================
    // ELIMINAR UNA ORDEN
    // ==========================================
    public function destroy($id)
    {
        $orden = Orden::find($id);

        if (!$orden) {
            return response()->json([
                'success' => false,
                'message' => 'La orden no existe.',
                'data' => null,
                'errors' => null
            ], 404);
        }

        try {
            DB::beginTransaction();

            // Primero eliminar los detalles relacionados
            $orden->detalles()->delete();

            // Después eliminar la orden
            $orden->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Orden eliminada correctamente.',
                'data' => null,
                'errors' => null
            ], 200);

        } catch (Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la orden.',
                'data' => null,
                'errors' => null
            ], 500);
        }
    }
}

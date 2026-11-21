<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\GuardarRecursoRequest;
use App\Http\Requests\Api\V1\Admin\ActualizarRecursoRequest;
use App\Http\Resources\Api\V1\Admin\AlimentoResource;
use App\Models\Alimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecursoController extends Controller
{
    // GET /api/v1/admin/recursos
    public function index(Request $request)
    {
        $alimentos = Alimento::orderByDesc('id_alimento')->get();

        return response()->json([
            'success' => true,
            'message' => 'Recursos consultados correctamente.',
            'data' => AlimentoResource::collection(
                $alimentos
            )->resolve($request),
            'errors' => null,
        ], 200);
    }

    // GET /api/v1/admin/recursos/{id}
    public function show(Request $request, $id)
    {
        $alimento = Alimento::find($id);

        if (!$alimento) {
            return $this->noEncontrado();
        }

        return response()->json([
            'success' => true,
            'message' => 'Recurso encontrado.',
            'data' => (new AlimentoResource($alimento))
                ->resolve($request),
            'errors' => null,
        ], 200);
    }

    // POST /api/v1/admin/recursos
    public function store(GuardarRecursoRequest $request)
    {
        $datos = $request->validated();

        // La tabla utiliza un ID entero no autoincremental.
        $alimento = DB::transaction(function () use ($datos) {

            $nuevoId = (Alimento::max('id_alimento') ?? 0) + 1;

            return Alimento::create([
                'id_alimento' => $nuevoId,
                'id_usuario' => $datos['id_usuario'],
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'],
                'categoria' => $datos['categoria'],
                'cantidad' => $datos['cantidad'],
                'unidad' => $datos['unidad'],
                'fecha_publicacion' => now(),
                'fecha_caducidad' => $datos['fecha_caducidad'],
                'estado' => $datos['estado'] ?? 'Disponible',
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Recurso creado correctamente.',
            'data' => (new AlimentoResource($alimento))
                ->resolve($request),
            'errors' => null,
        ], 201);
    }

    // PUT/PATCH /api/v1/admin/recursos/{id}
    public function update(ActualizarRecursoRequest $request, $id)
    {
        $alimento = Alimento::find($id);

        if (!$alimento) {
            return $this->noEncontrado();
        }

        $datos = $request->validated();

        if (empty($datos)) {
            return response()->json([
                'success' => false,
                'message' => 'Debes enviar al menos un campo para actualizar.',
                'data' => null,
                'errors' => [
                    'campos' => [
                        'No se recibieron campos válidos.'
                    ],
                ],
            ], 422);
        }

        $alimento->update($datos);

        return response()->json([
            'success' => true,
            'message' => 'Recurso actualizado correctamente.',
            'data' => (new AlimentoResource($alimento->fresh()))
                ->resolve($request),
            'errors' => null,
        ], 200);
    }

    // DELETE /api/v1/admin/recursos/{id}
    public function destroy($id)
    {
        $alimento = Alimento::find($id);

        if (!$alimento) {
            return $this->noEncontrado();
        }

        // Eliminación lógica: no borra relaciones ni registros.
        $alimento->update([
            'estado' => 'Inactivo',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recurso desactivado correctamente.',
            'data' => [
                'id_alimento' => $alimento->id_alimento,
                'estado' => $alimento->estado,
            ],
            'errors' => null,
        ], 200);
    }

    private function noEncontrado()
    {
        return response()->json([
            'success' => false,
            'message' => 'El recurso solicitado no existe.',
            'data' => null,
            'errors' => null,
        ], 404);
    }
}

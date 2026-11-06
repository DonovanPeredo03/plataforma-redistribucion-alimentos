<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AlimentoApiController extends Controller
{
    // Consultar todos los alimentos
    public function index()
    {
        $alimentos = Alimento::orderByDesc('id_alimento')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Alimentos consultados correctamente.',
            'data' => $alimentos,
            'errors' => null
        ], 200);
    }

    // Consultar un alimento por ID
    public function show($id)
    {
        $alimento = Alimento::find($id);

        if (!$alimento) {
            return response()->json([
                'success' => false,
                'message' => 'El alimento solicitado no existe.',
                'data' => null,
                'errors' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Alimento consultado correctamente.',
            'data' => $alimento,
            'errors' => null
        ], 200);
    }

    // Registrar un nuevo alimento
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|integer|exists:usuarios,id_usuario',
            'nombre' => 'required|string|min:2|max:150',
            'descripcion' => 'required|string|min:5|max:1000',
            'categoria' => 'required|in:Frutas y Verduras,Abarrotes y Enlatados,Panadería y Cereales,Lácteos y Refrigerados',
            'cantidad' => 'required|numeric|min:0.01|max:99999999.99',
            'unidad' => 'required|in:Unidades,Kilogramos,Gramos,Litros',
            'fecha_caducidad' => 'required|date',
            'imagen' => 'sometimes|required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación.',
                'data' => null,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $idAlimento = (Alimento::max('id_alimento') ?? 0) + 1;

            $rutaImagen = null;

            if ($request->hasFile('imagen')) {
                $rutaImagen = $request->file('imagen')
                    ->store('alimentos', 'public');
            }

            $alimento = Alimento::create([
                'id_alimento' => $idAlimento,
                'id_usuario' => $request->id_usuario,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'categoria' => $request->categoria,
                'cantidad' => $request->cantidad,
                'unidad' => $request->unidad,
                'fecha_publicacion' => now(),
                'fecha_caducidad' => $request->fecha_caducidad,
                'estado' => 'Disponible',
                'ruta_imagen' => $rutaImagen
                    ? '/storage/' . $rutaImagen
                    : null
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Alimento registrado correctamente.',
                'data' => $alimento,
                'errors' => null
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'No fue posible registrar el alimento.',
                'data' => null,
                'errors' => null
            ], 500);
        }
    }

    // Actualizar un alimento
    public function update(Request $request, $id)
    {
        $alimento = Alimento::find($id);

        if (!$alimento) {
            return response()->json([
                'success' => false,
                'message' => 'El alimento solicitado no existe.',
                'data' => null,
                'errors' => null
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'id_usuario' => 'sometimes|required|integer|exists:usuarios,id_usuario',
            'nombre' => 'sometimes|required|string|min:2|max:150',
            'descripcion' => 'sometimes|required|string|min:5|max:1000',
            'categoria' => 'sometimes|required|in:Frutas y Verduras,Abarrotes y Enlatados,Panadería y Cereales,Lácteos y Refrigerados',
            'cantidad' => 'sometimes|required|numeric|min:0.01|max:99999999.99',
            'unidad' => 'sometimes|required|in:Unidades,Kilogramos,Gramos,Litros',
            'fecha_caducidad' => 'sometimes|required|date',
            'estado' => 'sometimes|required|string|max:20',
            'imagen' => 'sometimes|required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación.',
                'data' => null,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $datos = $validator->validated();

            unset($datos['imagen']);

            if ($request->hasFile('imagen')) {

                if ($alimento->ruta_imagen) {
                    $rutaAnterior = str_replace(
                        '/storage/',
                        '',
                        $alimento->ruta_imagen
                    );

                    Storage::disk('public')->delete($rutaAnterior);
                }

                $rutaNueva = $request->file('imagen')
                    ->store('alimentos', 'public');

                $datos['ruta_imagen'] = '/storage/' . $rutaNueva;
            }

            $alimento->update($datos);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Alimento actualizado correctamente.',
                'data' => $alimento->fresh(),
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'No fue posible actualizar el alimento.',
                'data' => null,
                'errors' => null
            ], 500);
        }
    }

    // Eliminar un alimento
    public function destroy($id)
    {
        $alimento = Alimento::find($id);

        if (!$alimento) {
            return response()->json([
                'success' => false,
                'message' => 'El alimento solicitado no existe.',
                'data' => null,
                'errors' => null
            ], 404);
        }

        $tieneOrdenes = DB::table('orden_detalle')
            ->where('id_alimento', $id)
            ->exists();

        $estaEnLista = DB::table('lista_deseos_detalles')
            ->where('id_alimento', $id)
            ->exists();

        if ($tieneOrdenes || $estaEnLista) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el alimento porque tiene relaciones con órdenes o listas de deseos.',
                'data' => null,
                'errors' => null
            ], 409);
        }

        DB::beginTransaction();

        try {
            if ($alimento->ruta_imagen) {
                $rutaImagen = str_replace(
                    '/storage/',
                    '',
                    $alimento->ruta_imagen
                );

                Storage::disk('public')->delete($rutaImagen);
            }

            $alimento->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Alimento eliminado correctamente.',
                'data' => null,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'No fue posible eliminar el alimento.',
                'data' => null,
                'errors' => null
            ], 500);
        }
    }
}

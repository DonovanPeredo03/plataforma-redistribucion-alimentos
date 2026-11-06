<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AlimentoController extends Controller
{
    // Consultar todos los alimentos
    public function index()
    {
        $alimentos = Alimento::select([
            'id_alimento',
            'id_usuario',
            'nombre',
            'descripcion',
            'categoria',
            'cantidad',
            'unidad',
            'fecha_publicacion',
            'fecha_caducidad',
            'estado',
            'ruta_imagen',
        ])
        ->orderByDesc('id_alimento')
        ->paginate(9);

        return response()->json($alimentos, 200);
    }


    // Consultar un alimento específico
    public function show($id)
    {
        $alimento = Alimento::select([
            'id_alimento',
            'id_usuario',
            'nombre',
            'descripcion',
            'categoria',
            'cantidad',
            'unidad',
            'fecha_publicacion',
            'fecha_caducidad',
            'estado',
            'ruta_imagen',
        ])->find($id);

        if (!$alimento) {
            return response()->json([
                'mensaje' => 'El alimento solicitado no existe.'
            ], 404);
        }

        return response()->json($alimento, 200);
    }


    // Registrar un nuevo alimento
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|min:2|max:150',
            'categoria' => 'required|in:Frutas y Verduras,Abarrotes y Enlatados,Panadería y Cereales,Lácteos y Refrigerados',
            'cantidad' => 'required|numeric|min:0.01|max:99999999.99',
            'unidad' => 'required|in:Unidades,Kilogramos,Gramos,Litros',
            'fecha_caducidad' => 'required|date|after_or_equal:today',
            'descripcion' => 'required|string|min:5|max:1000',
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Generar el siguiente identificador
        $idAlimento = (Alimento::max('id_alimento') ?? 0) + 1;

        // Guardar la imagen
        $extension = $request->file('imagen')->getClientOriginalExtension();
        $nombreImagen = 'Alimento_' . $idAlimento . '_1.' . $extension;

        $rutaImagen = $request->file('imagen')
            ->storeAs('alimentos', $nombreImagen, 'public');

        // Registrar el alimento asociado al cliente autenticado
        $alimento = Alimento::create([
            'id_alimento' => $idAlimento,
            'id_usuario' => $request->user()->id_usuario,
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'],
            'categoria' => $datos['categoria'],
            'cantidad' => $datos['cantidad'],
            'unidad' => $datos['unidad'],
            'fecha_publicacion' => now(),
            'fecha_caducidad' => $datos['fecha_caducidad'],
            'estado' => 'Disponible',
            'ruta_imagen' => '/storage/' . $rutaImagen,
        ]);

        return response()->json([
            'mensaje' => 'Alimento registrado correctamente.',
            'alimento' => $alimento,
        ], 201);
    }


    // Actualizar un alimento existente
    public function update(Request $request, $id)
    {
        $alimento = Alimento::find($id);

        if (!$alimento) {
            return response()->json([
                'mensaje' => 'El alimento solicitado no existe.'
            ], 404);
        }

        $datos = $request->validate([
            'nombre' => 'sometimes|required|string|min:2|max:150',
            'categoria' => 'sometimes|required|in:Frutas y Verduras,Abarrotes y Enlatados,Panadería y Cereales,Lácteos y Refrigerados',
            'cantidad' => 'sometimes|required|numeric|min:0.01|max:99999999.99',
            'unidad' => 'sometimes|required|in:Unidades,Kilogramos,Gramos,Litros',
            'fecha_caducidad' => 'sometimes|required|date',
            'descripcion' => 'sometimes|required|string|min:5|max:1000',
            'estado' => 'sometimes|required|string|max:50',
            'imagen' => 'sometimes|required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Actualizar la imagen si se proporcionó una nueva
        if ($request->hasFile('imagen')) {

            // Eliminar la imagen anterior
            if ($alimento->ruta_imagen) {
                $rutaAnterior = str_replace('/storage/', '', $alimento->ruta_imagen);
                Storage::disk('public')->delete($rutaAnterior);
            }

            // Guardar la nueva imagen
            $extension = $request->file('imagen')->getClientOriginalExtension();
            $nombreImagen = 'Alimento_' . $id . '_' . time() . '.' . $extension;

            $rutaImagen = $request->file('imagen')
                ->storeAs('alimentos', $nombreImagen, 'public');

            $datos['ruta_imagen'] = '/storage/' . $rutaImagen;
        }

        $alimento->update($datos);

        return response()->json([
            'mensaje' => 'Alimento actualizado correctamente.',
            'alimento' => $alimento->fresh(),
        ], 200);
    }


    // Eliminar un alimento
    public function destroy($id)
    {
        $alimento = Alimento::find($id);

        if (!$alimento) {
            return response()->json([
                'mensaje' => 'El alimento solicitado no existe.'
            ], 404);
        }

        // Verificar si está relacionado con alguna orden
        $tieneOrdenes = DB::table('orden_detalle')
            ->where('id_alimento', $id)
            ->exists();

        // Verificar si está en alguna lista de deseos
        $estaEnLista = DB::table('lista_deseos_detalles')
            ->where('id_alimento', $id)
            ->exists();

        if ($tieneOrdenes || $estaEnLista) {
            return response()->json([
                'mensaje' => 'No se puede eliminar el alimento porque está relacionado con órdenes o listas de deseos.'
            ], 409);
        }

        // Eliminar la imagen asociada
        if ($alimento->ruta_imagen) {
            $rutaImagen = str_replace('/storage/', '', $alimento->ruta_imagen);
            Storage::disk('public')->delete($rutaImagen);
        }

        $alimento->delete();

        return response()->json([
            'mensaje' => 'Alimento eliminado correctamente.'
        ], 200);
    }
}

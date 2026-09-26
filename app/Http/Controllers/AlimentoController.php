<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AlimentoController extends Controller
{
    public function index()
    {
        $alimentos = Alimento::with(['usuario'])->orderByDesc('id_alimento')->paginate(9);

        return view('alimentos.index', compact('alimentos'));
    }

    public function create()
    {
        return view('alimentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:2|max:150',
            'categoria' => 'required|in:Frutas y Verduras,Abarrotes y Enlatados,Panadería y Cereales,Lácteos y Refrigerados',
            'cantidad' => 'required|numeric|min:0.01|max:99999999.99',
            'unidad' => 'required|in:Unidades,Kilogramos,Gramos,Litros',
            'fecha_caducidad' => 'required|date|after_or_equal:today',
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'descripcion' => 'required|string|min:5|max:1000',
            'conservacion' => 'required|in:fresco,refrigerado',
        ]);

        $idAlimento = (Alimento::max('id_alimento') ?? 0) + 1;
        $extension = $request->file('imagen')->getClientOriginalExtension();
        $nombreImagen = 'Alimento_' . $idAlimento . '_1.' . $extension;
        $rutaImagen = $request->file('imagen')->storeAs('alimentos', $nombreImagen, 'public');

        Alimento::create([
            'id_alimento' => $idAlimento,
            'id_usuario' => session('id_usuario_activo', 1),
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
            'cantidad' => $request->cantidad,
            'unidad' => $request->unidad,
            'fecha_publicacion' => now(),
            'fecha_caducidad' => $request->fecha_caducidad,
            'estado' => 'Disponible',
            'ruta_imagen' => '/storage/' . $rutaImagen,
        ]);

        return redirect()->route('alimentos.index')
            ->with('success', 'Alimento registrado correctamente.');
    }

    public function show($id)
    {
        $alimento = Alimento::with(['usuario'])->find($id);

        if (!$alimento) {
            return redirect()->route('alimentos.index')
                ->with('error', 'El alimento que intentas consultar no existe.');
        }

        return view('alimentos.show', compact('alimento'));
    }

    public function edit($id)
    {
        $alimento = Alimento::find($id);

        if (!$alimento) {
            return redirect()->route('alimentos.index')
                ->with('error', 'No fue posible editar: el alimento no existe.');
        }

        return view('alimentos.edit', compact('alimento'));
    }

    public function update(Request $request, $id)
    {
        $alimento = Alimento::find($id);

        if (!$alimento) {
            return redirect()->route('alimentos.index')
                ->with('error', 'No fue posible actualizar: el alimento no existe.');
        }

        $fechaCaducidadOriginal = \Carbon\Carbon::parse($alimento->fecha_caducidad)->format('Y-m-d');

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|min:2|max:150',
            'categoria' => 'required|in:Frutas y Verduras,Abarrotes y Enlatados,Panadería y Cereales,Lácteos y Refrigerados',
            'cantidad' => 'required|numeric|min:0.01|max:99999999.99',
            'unidad' => 'required|in:Unidades,Kilogramos,Gramos,Litros',
            'fecha_caducidad' => ['required', 'date'],
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'descripcion' => 'required|string|min:5|max:1000',
            'conservacion' => 'required|in:fresco,refrigerado',
            'estado' => 'required|in:Disponible,Reservado,Agotado',
        ]);

        
        $validator->after(function ($validator) use ($request, $fechaCaducidadOriginal) {
            if ($request->fecha_caducidad !== $fechaCaducidadOriginal
                && $request->fecha_caducidad < date('Y-m-d')) {
                $validator->errors()->add('fecha_caducidad', 'La nueva fecha de caducidad debe ser hoy o una fecha futura.');
            }
        });

        $validator->validate();

        $alimento->nombre = $request->nombre;
        $alimento->categoria = $request->categoria;
        $alimento->cantidad = $request->cantidad;
        $alimento->unidad = $request->unidad;
        $alimento->fecha_caducidad = $request->fecha_caducidad;
        $alimento->descripcion = $request->descripcion;
        $alimento->estado = $request->estado;

        // Gestión de imagen: si no se sube una nueva, se conserva la existente.
        if ($request->hasFile('imagen')) {
            if ($alimento->ruta_imagen) {
                $rutaAnterior = str_replace('/storage/', '', $alimento->ruta_imagen);
                Storage::disk('public')->delete($rutaAnterior);
            }

            $extension = $request->file('imagen')->getClientOriginalExtension();
            $nombreImagen = 'Alimento_' . $alimento->id_alimento . '_1.' . $extension;
            $rutaImagen = $request->file('imagen')->storeAs('alimentos', $nombreImagen, 'public');
            $alimento->ruta_imagen = '/storage/' . $rutaImagen;
        }

        $alimento->save();

        return redirect()->route('alimentos.index')
            ->with('success', 'Alimento actualizado correctamente.');
    }

    public function destroy($id)
    {
        $alimento = Alimento::find($id);

        if (!$alimento) {
            return redirect()->route('alimentos.index')
                ->with('error', 'No fue posible eliminar: el alimento no existe.');
        }

        try {
            $alimento->delete();
        } catch (QueryException $e) {
            return redirect()->route('alimentos.index')
                ->with('error', 'No se puede eliminar el alimento porque está referenciado en carritos, órdenes o listas de deseos.');
        }

        if ($alimento->ruta_imagen) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $alimento->ruta_imagen));
        }

        return redirect()->route('alimentos.index')
            ->with('success', 'Alimento eliminado correctamente.');
    }
}

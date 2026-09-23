<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use Illuminate\Http\Request;

class AlimentoController extends Controller
{
    public function index()
    {
        $alimentos = Alimento::with(['usuario'])->paginate(10);

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
    'id_usuario' => 1,
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

}

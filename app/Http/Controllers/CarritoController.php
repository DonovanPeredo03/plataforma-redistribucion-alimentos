<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Usuario;
use App\Models\Alimento;
use App\Models\CarritoDetalle;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index()
    {
        $carritos = Carrito::with(['usuario', 'detalles.alimento'])->orderByDesc('id_carrito')->paginate(10);

        return view('carritos.index', compact('carritos'));
    }

    public function create()
    {
        $usuarios = Usuario::all();
        $alimentos = Alimento::all();

        return view('carritos.create', compact('usuarios', 'alimentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'estado' => 'required|string|max:20',
            'alimentos' => 'required|array',
        ]);

        $idCarrito = (Carrito::max('id_carrito') ?? 0) + 1;

        $carrito = Carrito::create([
            'id_carrito' => $idCarrito,
            'id_usuario' => $request->id_usuario,
            'fecha_creacion' => now(),
            'estado' => $request->estado,
        ]);

        $idDetalle = CarritoDetalle::max('id_detalle_carrito') ?? 0;

        foreach ($request->alimentos as $idAlimento => $data) {
            if (isset($data['seleccionado']) && $data['seleccionado'] == '1') {
                $idDetalle++;
                CarritoDetalle::create([
                    'id_detalle_carrito' => $idDetalle,
                    'id_carrito' => $idCarrito,
                    'id_alimento' => $idAlimento,
                    'cantidad' => $data['cantidad'] ?? 1,
                ]);
            }
        }

        return redirect()->route('carritos.index')
            ->with('success', 'Carrito registrado correctamente.');
    }

    public function show($id)
    {
        $carrito = Carrito::with(['usuario', 'detalles.alimento'])->find($id);

        if (!$carrito) {
            return redirect()->route('carritos.index')
                ->with('error', 'El carrito que intentas consultar no existe.');
        }

        return view('carritos.show', compact('carrito'));
    }

    public function edit($id)
    {
        $carrito = Carrito::find($id);

        if (!$carrito) {
            return redirect()->route('carritos.index')
                ->with('error', 'No fue posible editar: el carrito no existe.');
        }

        $usuarios = Usuario::all();

        return view('carritos.edit', compact('carrito', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $carrito = Carrito::find($id);

        if (!$carrito) {
            return redirect()->route('carritos.index')
                ->with('error', 'No fue posible actualizar: el carrito no existe.');
        }

        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'estado' => 'required|string|max:20',
        ]);

        $carrito->id_usuario = $request->id_usuario;
        $carrito->estado = $request->estado;
        $carrito->save();

        return redirect()->route('carritos.index')
            ->with('success', 'Carrito actualizado correctamente.');
    }

    public function destroy($id)
    {
        $carrito = Carrito::find($id);

        if (!$carrito) {
            return redirect()->route('carritos.index')
                ->with('error', 'No fue posible eliminar: el carrito no existe.');
        }

        try {
            $carrito->detalles()->delete();
            $carrito->delete();
        } catch (QueryException $e) {
            return redirect()->route('carritos.index')
                ->with('error', 'No se puede eliminar el carrito debido a un error en la base de datos.');
        }

        return redirect()->route('carritos.index')
            ->with('success', 'Carrito eliminado correctamente.');
    }
}

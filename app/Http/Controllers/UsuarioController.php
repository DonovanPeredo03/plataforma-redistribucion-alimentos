<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller {
    public function index() {
        $usuarios = Usuario::with(['rol'])->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
{
    return view('usuarios.create');
}

    public function store(Request $request)
    {
        $request->validate([
    'nombre' => 'required|string|min:2|max:100',
    'apellido' => 'required|string|min:2|max:50',
    'email' => 'required|email|max:150|unique:usuarios,email',
    'teléfono' => 'required|string|min:10|max:15',
    'direccion' => 'required|string|min:5|max:200',
    'tipo_login' => 'required|string|max:30',
    'password' => 'required|string|min:8',
    'id_rol' => 'required|exists:roles,id_rol',
]);

        $idUsuario = (Usuario::max('id_usuario') ?? 0) + 1;

        Usuario::create([
    'id_usuario' => $idUsuario,
    'id_rol' => $request->id_rol,
    'nombre' => $request->nombre,
    'apellido' => $request->apellido,
    'email' => $request->email,
    'teléfono' => $request->teléfono,
    'direccion' => $request->direccion,
    'tipo_login' => $request->tipo_login,
    'password' => Hash::make($request->password),
    'fecha_registro' => now(),
    'estado' => $request->estado ?? 'Inactivo',
]);

    return redirect()->route('usuarios.index')
    ->with('success', 'Usuario registrado correctamente.');

    }
}
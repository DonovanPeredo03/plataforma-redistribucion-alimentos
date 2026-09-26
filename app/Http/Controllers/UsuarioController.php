<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with(['rol'])->orderBy('id_usuario')->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::orderBy('nombre')->get();

        return view('usuarios.create', compact('roles'));
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
            'estado' => $request->boolean('estado') ? 1 : 0,
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    public function show($id)
    {
        $usuario = Usuario::with(['rol'])->find($id);

        if (!$usuario) {
            return redirect()->route('usuarios.index')
                ->with('error', 'El usuario que intentas consultar no existe.');
        }

        return view('usuarios.show', compact('usuario'));
    }

    public function edit($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No fue posible editar: el usuario no existe.');
        }

        $roles = Role::orderBy('nombre')->get();

        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No fue posible actualizar: el usuario no existe.');
        }

        $request->validate([
            'nombre' => 'required|string|min:2|max:100',
            'apellido' => 'required|string|min:2|max:50',
            'email' => ['required', 'email', 'max:150', Rule::unique('usuarios', 'email')->ignore($usuario->id_usuario, 'id_usuario')],
            'teléfono' => 'required|string|min:10|max:15',
            'direccion' => 'required|string|min:5|max:200',
            'tipo_login' => 'required|string|max:30',
            'password' => 'nullable|string|min:8',
            'id_rol' => 'required|exists:roles,id_rol',
        ]);

        $usuario->id_rol = $request->id_rol;
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->email = $request->email;
        $usuario->teléfono = $request->teléfono;
        $usuario->direccion = $request->direccion;
        $usuario->tipo_login = $request->tipo_login;
        $usuario->estado = $request->boolean('estado') ? 1 : 0;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No fue posible eliminar: el usuario no existe.');
        }

        try {
            $usuario->delete();
        } catch (QueryException $e) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No se puede eliminar al usuario porque tiene alimentos, órdenes, carritos u otros registros asociados.');
        }

        if (session('id_usuario_activo') == $id) {
            session()->forget('id_usuario_activo');
        }

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    
    public function activar(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
        ]);

        session(['id_usuario_activo' => $request->id_usuario]);

        return back()->with('success', 'Usuario activo cambiado correctamente.');
    }
}

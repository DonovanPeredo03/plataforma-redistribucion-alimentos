<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};

class AdminSesionController extends Controller
{
    public function mostrarFormulario()
    {
        return view('auth.iniciar-sesion');
    }

    public function iniciarSesion(Request $request)
    {
        $datos = $request->validate(
            [
                'correo'     => ['required', 'email'],
                'contrasena' => ['required'],
            ],
            [
                'required' => 'El campo :attribute es obligatorio.',
                'email'    => 'El :attribute debe tener un formato válido.',
            ],
            [
                'correo'     => 'correo electrónico',
                'contrasena' => 'contraseña',
            ]
        );

        if (Auth::guard('admin')->attempt(
            ['correo' => $datos['correo'], 'password' => $datos['contrasena'], 'estado' => true],
            $request->boolean('recordarme')
        )) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.panel'))
                ->with('exito', 'Inicio de sesión exitoso.');
        }

        $administrador = Administrador::where('correo', $datos['correo'])->first();
        if ($administrador
            && Hash::check($datos['contrasena'], $administrador->contrasena)
            && ! $administrador->estado) {
            return back()->onlyInput('correo')
                ->with('cuenta_deshabilitada', 'Tu cuenta está deshabilitada.');
        }

        return back()->onlyInput('correo')
            ->with('credenciales_incorrectas', 'Credenciales incorrectas.');
    }

    public function cerrarSesion(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.iniciar_sesion')
            ->with('exito', 'Cierre de sesión exitoso.');
    }
}
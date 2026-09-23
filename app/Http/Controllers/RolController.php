<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);

        return view('roles.index', compact('roles'));
    }

    public function create()
{
    return view('roles.create');
}

public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|min:3|max:50',
        'descripcion' => 'required|string|min:5|max:150',
    ]);

    $idRol = (Role::max('id_rol') ?? 0) + 1;

    Role::create([
        'id_rol' => $idRol,
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
    ]);

    return redirect()->route('roles.index')
        ->with('success', 'Rol registrado correctamente.');
}

}
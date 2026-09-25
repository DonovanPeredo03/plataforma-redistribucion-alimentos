<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RolController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id_rol')->paginate(10);

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:3|max:50|unique:roles,nombre',
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

    public function show($id)
    {
        $rol = Role::with('usuarios')->find($id);

        if (!$rol) {
            return redirect()->route('roles.index')
                ->with('error', 'El rol que intentas consultar no existe.');
        }

        return view('roles.show', compact('rol'));
    }

    public function edit($id)
    {
        $rol = Role::find($id);

        if (!$rol) {
            return redirect()->route('roles.index')
                ->with('error', 'No fue posible editar: el rol no existe.');
        }

        return view('roles.edit', compact('rol'));
    }

    public function update(Request $request, $id)
    {
        $rol = Role::find($id);

        if (!$rol) {
            return redirect()->route('roles.index')
                ->with('error', 'No fue posible actualizar: el rol no existe.');
        }

        $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'max:50', Rule::unique('roles', 'nombre')->ignore($rol->id_rol, 'id_rol')],
            'descripcion' => 'required|string|min:5|max:150',
        ]);

        $rol->nombre = $request->nombre;
        $rol->descripcion = $request->descripcion;
        $rol->save();

        return redirect()->route('roles.index')
            ->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy($id)
    {
        $rol = Role::find($id);

        if (!$rol) {
            return redirect()->route('roles.index')
                ->with('error', 'No fue posible eliminar: el rol no existe.');
        }

        try {
            $rol->delete();
        } catch (QueryException $e) {
            return redirect()->route('roles.index')
                ->with('error', 'No se puede eliminar el rol porque tiene usuarios asignados.');
        }

        return redirect()->route('roles.index')
            ->with('success', 'Rol eliminado correctamente.');
    }
}

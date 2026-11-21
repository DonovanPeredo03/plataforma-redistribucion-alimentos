@extends('Layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Editar Usuario</h1>
        <p class="text-sm text-gray-500">Actualiza los datos del usuario #{{ $usuario->id_usuario }}</p>
    </div>
    <a href="{{ route('usuarios.index') }}" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">← Regresar</a>
</div>

<form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @csrf
    @method('PUT')

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
        <input type="text" name="nombre" required minlength="2" maxlength="50"
        value="{{ old('nombre', $usuario->nombre) }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
        placeholder="Ej. Ana">
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Apellido</label>
        <input type="text" name="apellido" required minlength="2" maxlength="50"
        value="{{ old('apellido', $usuario->apellido) }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
        placeholder="Ej. Gómez">
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Correo Electrónico</label>
        <input type="email" name="email" required
       value="{{ old('email', $usuario->email) }}"
       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
       placeholder="correo@ejemplo.com">
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Teléfono</label>
        <input type="text" name="teléfono" required minlength="10" maxlength="15"
        value="{{ old('teléfono', $usuario->teléfono) }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
        placeholder="Ej. 3312345678">
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Dirección</label>
        <input type="text" name="direccion" required minlength="5" maxlength="200"
        value="{{ old('direccion', $usuario->direccion) }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
        placeholder="Ej. Av. Vallarta 123, Guadalajara">
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Tipo de Login</label>
        <select name="tipo_login" required
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            <option value="correo" {{ old('tipo_login', $usuario->tipo_login) == 'correo' ? 'selected' : '' }}>Correo electrónico</option>
            <option value="usuario" {{ old('tipo_login', $usuario->tipo_login) == 'usuario' ? 'selected' : '' }}>Usuario</option>
            <option value="local" {{ old('tipo_login', $usuario->tipo_login) == 'local' ? 'selected' : '' }}>Local</option>
        </select>
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Nueva Contraseña</label>
        <input type="password" name="password" minlength="8"
       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
       placeholder="Déjalo en blanco para conservar la actual">
        <p class="mt-1 text-xs text-gray-500">Si no deseas cambiar la contraseña, deja este campo vacío.</p>
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Rol del Sistema</label>
        <select name="id_rol" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            @foreach($roles as $rol)
                <option value="{{ $rol->id_rol }}" {{ old('id_rol', $usuario->id_rol) == $rol->id_rol ? 'selected' : '' }}>
                    {{ $rol->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2 flex items-center">
        <input type="checkbox" name="estado" value="1" class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500" {{ old('estado', $usuario->estado) ? 'checked' : '' }}>
        <label class="ms-2 text-sm font-medium text-gray-900">Usuario Activo con permisos inmediatos</label>
    </div>

    <div class="md:col-span-2 flex justify-end gap-3 mt-2">
        <a href="{{ route('usuarios.index') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancelar</a>
        <button type="submit" class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-5 py-2.5">Guardar Cambios</button>
    </div>
</form>
@endsection

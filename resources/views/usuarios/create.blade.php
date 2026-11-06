@extends('Layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Registrar Nuevo Usuario</h1>
        <p class="text-sm text-gray-500">Ingresa los datos del nuevo usuario para el sistema</p>
    </div>
    <a href="/usuarios" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">← Regresar</a>
</div>

<form action="{{ route('usuarios.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @csrf
    
    <div>
    <label class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
    <input type="text" name="nombre" required minlength="2" maxlength="50"
    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
    placeholder="Ej. Ana">
</div>

<div>
    <label class="block mb-2 text-sm font-medium text-gray-900">Apellido</label>
    <input type="text" name="apellido" required minlength="2" maxlength="50"
    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
    placeholder="Ej. Gómez">
</div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Correo Electrónico</label>
        <input type="email" name="email" required
       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
       placeholder="correo@ejemplo.com">
    </div>

    <div>
    <label class="block mb-2 text-sm font-medium text-gray-900">Teléfono</label>
    <input type="text" name="teléfono" required minlength="10" maxlength="15"
    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
    placeholder="Ej. 3312345678">
</div>

    <div>
    <label class="block mb-2 text-sm font-medium text-gray-900">Dirección</label>
    <input type="text" name="direccion" required minlength="5" maxlength="200"
    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
    placeholder="Ej. Av. Vallarta 123, Guadalajara">
</div>

    <div>
    <label class="block mb-2 text-sm font-medium text-gray-900">Tipo de Login</label>
    <select name="tipo_login" required
    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
        <option value="correo">Correo electrónico</option>
        <option value="usuario">Usuario</option>
    </select>
</div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Contraseña</label>
        <input type="password" name="password" required minlength="8"
       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
       placeholder="••••••••">
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Rol del Sistema</label>
        <select name="id_rol" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            <option value="" selected disabled>Selecciona un rol</option>
            @foreach($roles as $rol)
                <option value="{{ $rol->id_rol }}" {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>
                    {{ $rol->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2 flex items-center">
        <input type="checkbox" name="estado" value="1" class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500" checked>
        <label class="ms-2 text-sm font-medium text-gray-900">Usuario Activo con permisos inmediatos</label>
    </div>

    <div class="md:col-span-2 flex justify-end gap-3 mt-2">
        <a href="/usuarios" class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancelar</a>
        <button type="submit" class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-5 py-2.5">Guardar Usuario</button>
    </div>
</form>
@endsection
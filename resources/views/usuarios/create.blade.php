@extends('layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Registrar Nuevo Usuario</h1>
        <p class="text-sm text-gray-500">Ingresa los datos del nuevo usuario para el sistema</p>
    </div>
    <a href="/usuarios" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">← Regresar</a>
</div>

<form class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Nombre Completo</label>
        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Ej. Ana Gómez">
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Correo Electrónico</label>
        <input type="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="correo@ejemplo.com">
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Contraseña</label>
        <input type="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="••••••••">
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Rol del Sistema</label>
        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            <option>Administrador</option>
            <option>Cliente / Beneficiario</option>
            <option>Donante</option>
        </select>
    </div>

    <div class="md:col-span-2 flex items-center">
        <input type="checkbox" class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500" checked>
        <label class="ms-2 text-sm font-medium text-gray-900">Usuario Activo con permisos inmediatos</label>
    </div>

    <div class="md:col-span-2 flex justify-end gap-3 mt-2">
        <a href="/usuarios" class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancelar</a>
        <button type="button" class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-5 py-2.5">Guardar Usuario</button>
    </div>
</form>
@endsection
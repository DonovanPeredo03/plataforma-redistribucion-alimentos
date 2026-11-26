@extends('Layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Consultar Rol</h1>
        <p class="text-sm text-gray-500">Detalle del rol #{{ $rol->id_rol }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('roles.edit', $rol->id_rol) }}" class="text-white bg-amber-500 hover:bg-amber-600 font-medium rounded-lg text-sm px-4 py-2">Editar</a>
        <a href="{{ route('roles.index') }}" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">← Regresar</a>
    </div>
</div>

<div class="bg-gray-50 border border-gray-200 rounded-xl p-6 space-y-4">
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Nombre</span>
        <span class="block text-gray-900 font-medium text-lg">{{ $rol->nombre }}</span>
    </div>
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Descripción</span>
        <span class="block text-gray-900">{{ $rol->descripcion }}</span>
    </div>
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Usuarios con este rol</span>
        <span class="block text-gray-900 font-medium">{{ $rol->usuarios->count() }}</span>
    </div>
</div>
@endsection

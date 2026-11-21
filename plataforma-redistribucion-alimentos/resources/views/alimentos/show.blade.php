@extends('Layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Consultar Alimento</h1>
        <p class="text-sm text-gray-500">Detalle del alimento #{{ $alimento->id_alimento }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('alimentos.edit', $alimento->id_alimento) }}" class="text-white bg-amber-500 hover:bg-amber-600 font-medium rounded-lg text-sm px-4 py-2">Editar</a>
        <a href="{{ route('alimentos.index') }}" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">← Regresar</a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-1">
        <img src="{{ $alimento->ruta_imagen ?? 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?auto=format&fit=crop&w=500&q=80' }}"
             alt="{{ $alimento->nombre }}" class="w-full h-56 object-cover rounded-xl border border-gray-200">
    </div>
    <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 border border-gray-200 rounded-xl p-6">
        <div>
            <span class="block text-xs font-semibold text-gray-500 uppercase">Nombre</span>
            <span class="block text-gray-900 font-medium">{{ $alimento->nombre }}</span>
        </div>
        <div>
            <span class="block text-xs font-semibold text-gray-500 uppercase">Categoría</span>
            <span class="block text-gray-900 font-medium">{{ $alimento->categoria }}</span>
        </div>
        <div>
            <span class="block text-xs font-semibold text-gray-500 uppercase">Cantidad</span>
            <span class="block text-gray-900 font-medium">{{ $alimento->cantidad }} {{ $alimento->unidad }}</span>
        </div>
        <div>
            <span class="block text-xs font-semibold text-gray-500 uppercase">Estado</span>
            <span class="block text-gray-900 font-medium">{{ $alimento->estado }}</span>
        </div>
        <div>
            <span class="block text-xs font-semibold text-gray-500 uppercase">Fecha de Publicación</span>
            <span class="block text-gray-900 font-medium">{{ \Carbon\Carbon::parse($alimento->fecha_publicacion)->format('d/m/Y') }}</span>
        </div>
        <div>
            <span class="block text-xs font-semibold text-gray-500 uppercase">Fecha de Caducidad</span>
            <span class="block text-gray-900 font-medium">{{ \Carbon\Carbon::parse($alimento->fecha_caducidad)->format('d/m/Y') }}</span>
        </div>
        <div>
            <span class="block text-xs font-semibold text-gray-500 uppercase">Donante</span>
            <span class="block text-gray-900 font-medium">{{ $alimento->usuario->nombre ?? 'Sin asignar' }} {{ $alimento->usuario->apellido ?? '' }}</span>
        </div>
        <div class="sm:col-span-2">
            <span class="block text-xs font-semibold text-gray-500 uppercase">Descripción</span>
            <span class="block text-gray-900">{{ $alimento->descripcion }}</span>
        </div>
    </div>
</div>
@endsection

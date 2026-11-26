@extends('Layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Consultar Lista de Deseos</h1>
        <p class="text-sm text-gray-500">Detalle de la lista #{{ $lista->id_lista }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('lista_deseos.edit', $lista->id_lista) }}" class="text-white bg-amber-500 hover:bg-amber-600 font-medium rounded-lg text-sm px-4 py-2">Editar</a>
        <a href="{{ route('lista_deseos.index') }}" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">← Regresar</a>
    </div>
</div>

<div class="bg-gray-50 border border-gray-200 rounded-xl p-6 grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Solicitado por</span>
        <span class="block text-gray-900 font-medium">{{ $lista->usuario->nombre ?? 'Sin asignar' }} {{ $lista->usuario->apellido ?? '' }}</span>
    </div>
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Fecha de Creación</span>
        <span class="block text-gray-900 font-medium">{{ \Carbon\Carbon::parse($lista->fecha_creacion)->format('d/m/Y H:i') }}</span>
    </div>
</div>

<h2 class="font-bold text-gray-900 text-lg mb-3">Alimentos deseados</h2>
<div class="divide-y divide-gray-100 border border-gray-200 rounded-xl">
    @forelse($lista->detalles as $detalle)
        <div class="p-4 flex justify-between items-center">
            <span class="text-sm text-gray-900 font-medium">{{ $detalle->alimento->nombre ?? 'Alimento no disponible' }}</span>
        </div>
    @empty
        <div class="p-4 text-sm text-gray-500">Esta lista no tiene alimentos agregados.</div>
    @endforelse
</div>
@endsection

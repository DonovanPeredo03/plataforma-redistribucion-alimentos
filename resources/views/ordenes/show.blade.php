@extends('Layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Consultar Orden</h1>
        <p class="text-sm text-gray-500">Detalle de la orden ORD-2026-{{ str_pad($orden->id_orden, 3, '0', STR_PAD_LEFT) }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('ordenes.edit', $orden->id_orden) }}" class="text-white bg-amber-500 hover:bg-amber-600 font-medium rounded-lg text-sm px-4 py-2">Editar</a>
        <a href="{{ route('ordenes.index') }}" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">← Regresar</a>
    </div>
</div>

<div class="bg-gray-50 border border-gray-200 rounded-xl p-6 grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Cliente / Asociación</span>
        <span class="block text-gray-900 font-medium">{{ $orden->usuario->nombre ?? 'Sin asignar' }} {{ $orden->usuario->apellido ?? '' }}</span>
    </div>
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Estatus</span>
        <span class="block text-gray-900 font-medium">{{ $orden->estado }}</span>
    </div>
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Fecha de Solicitud</span>
        <span class="block text-gray-900 font-medium">{{ \Carbon\Carbon::parse($orden->fecha_orden)->format('d/m/Y') }}</span>
    </div>
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Fecha de Entrega Programada</span>
        <span class="block text-gray-900 font-medium">{{ \Carbon\Carbon::parse($orden->fecha_entrega)->format('d/m/Y') }}</span>
    </div>
    <div class="sm:col-span-2">
        <span class="block text-xs font-semibold text-gray-500 uppercase">Observaciones</span>
        <span class="block text-gray-900">{{ $orden->observaciones }}</span>
    </div>
</div>

<h2 class="font-bold text-gray-900 text-lg mb-3">Alimentos en la orden</h2>
<div class="divide-y divide-gray-100 border border-gray-200 rounded-xl">
    @forelse($orden->detalles as $detalle)
        <div class="p-4 flex justify-between items-center">
            <span class="text-sm text-gray-900 font-medium">{{ $detalle->alimento->nombre ?? 'Alimento no disponible' }}</span>
            <span class="text-sm text-gray-500">Cantidad: {{ $detalle->cantidad }}</span>
        </div>
    @empty
        <div class="p-4 text-sm text-gray-500">Esta orden no tiene alimentos agregados.</div>
    @endforelse
</div>
@endsection

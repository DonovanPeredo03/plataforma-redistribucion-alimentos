@extends('Layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Órdenes de Redistribución</h1>
        <p class="text-sm text-gray-500">Historial y estado de entregas solicitadas</p>
    </div>
    <a href="{{ route('ordenes.create') }}"
   class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-4 py-2.5">
    + Registrar Orden
</a>
</div>

<div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-emerald-50">
            <tr>
                <th scope="col" class="px-6 py-3">Folio</th>
                <th scope="col" class="px-6 py-3">Cliente / Asociación</th>
                <th scope="col" class="px-6 py-3">Fecha de Solicitud</th>
                <th scope="col" class="px-6 py-3">Estatus</th>
                <th scope="col" class="px-6 py-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ordenes as $orden)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        ORD-2026-{{ str_pad($orden->id_orden, 3, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $orden->usuario->nombre ?? 'Usuario' }} {{ $orden->usuario->apellido ?? '' }}
                    </td>
                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($orden->fecha_orden)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $orden->estado }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('ordenes.show', $orden->id_orden) }}" class="font-medium text-blue-600 hover:underline">Consultar</a>
                        <a href="{{ route('ordenes.edit', $orden->id_orden) }}" class="font-medium text-amber-600 hover:underline">Editar</a>
                        <form action="{{ route('ordenes.destroy', $orden->id_orden) }}" method="POST" class="inline"
                              onsubmit="return confirm('¿Seguro que deseas eliminar la orden #{{ $orden->id_orden }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        No se encontraron órdenes registradas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4 bg-white border-t border-gray-200">
        {{ $ordenes->links() }}
    </div>
</div>
@endsection
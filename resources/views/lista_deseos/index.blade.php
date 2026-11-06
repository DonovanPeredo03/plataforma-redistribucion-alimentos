@extends('Layout.app')

@section('contenido')

<div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-gray-100 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Lista de Deseos y Necesidades ⭐</h1>
        <p class="text-sm text-gray-500 mt-0.5">Alimentos prioritarios requeridos por comedores y organizaciones</p>
    </div>
    
    <a href="{{ route('lista_deseos.create') }}"
   class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2.5 rounded-lg text-sm shadow-sm transition-all duration-200">
    + Crear Lista de Deseos
</a>

</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse($listaDeseo as $item)
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-3">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full border bg-gray-100 text-gray-700 border-gray-200">
    Lista #{{ $item->id_lista }}
</span>

                </div>
                
                <h3 class="font-bold text-gray-900 text-lg">
    Lista de Deseos #{{ $item->id_lista }}
</h3>
                
                <span class="text-xs text-gray-400 block mt-2">
                   Solicitado por: {{ $item->usuario->nombre ?? ('Usuario ' . $item->id_usuario) }} {{ $item->usuario->apellido ?? '' }} 
                </span>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                <div>
    <span class="text-xs text-gray-400 block">Creada</span>
    <span class="text-sm font-extrabold text-gray-800">
        {{ \Carbon\Carbon::parse($item->fecha_creacion)->format('d/m/Y') }}
    </span>
</div>
                <a href="{{ route('alimentos.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-800 bg-emerald-50 px-3 py-2 rounded-lg transition">
                    Buscar Donante 🔍
                </a>
            </div>

            <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-end gap-3 text-xs font-semibold">
                <a href="{{ route('lista_deseos.show', $item->id_lista) }}" class="text-blue-600 hover:text-blue-800 transition">Consultar</a>
                <a href="{{ route('lista_deseos.edit', $item->id_lista) }}" class="text-amber-600 hover:text-amber-800 transition">Editar</a>
                <form action="{{ route('lista_deseos.destroy', $item->id_lista) }}" method="POST"
                      onsubmit="return confirm('¿Seguro que deseas eliminar la lista #{{ $item->id_lista }}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 transition">Eliminar</button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white rounded-xl border border-gray-200 p-8 text-center text-gray-500">
            No hay necesidades registradas en la lista de deseos actualmente.
        </div>
    @endforelse

</div>

<div class="mt-6">
    {{ $listaDeseo->links() }}
</div>

@endsection
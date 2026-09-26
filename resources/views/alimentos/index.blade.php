@extends('Layout.app')

@section('contenido')


<div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-gray-100 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Catálogo de Alimentos Excedentes</h1>
        <p class="text-sm text-gray-500 mt-0.5">Gestión y redistribución de insumos alimentarios (Hambre Cero)</p>
    </div>
    <a href="{{ route('alimentos.create') }}" class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2.5 rounded-lg text-sm shadow-sm transition-all duration-200">
        + Registrar Nuevo Alimento
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($alimentos as $alimento)
        @php
            $imagenCategoria = match(strtolower($alimento->categoria ?? '')) {
                'frutas y verduras' => 'https://images.unsplash.com/photo-1610832958506-aa56368176cf?auto=format&fit=crop&w=500&q=80',
                'panadería'         => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=500&q=80',
                'lácteos'           => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?auto=format&fit=crop&w=500&q=80',
                'granos'            => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?auto=format&fit=crop&w=500&q=80',
                'enlatados y secos' => 'https://img.magnific.com/foto-gratis/vista-superior-alimentos-envasados-latas_23-2151206988.jpg?semt=ais_hybrid&w=740&q=80',
                default             => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?auto=format&fit=crop&w=500&q=80',
            };
        @endphp

        <div class="group bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 flex flex-col h-full">
            <div class="h-48 w-full bg-gray-100 relative overflow-hidden shrink-0">
               
                <img src="{{ $alimento->ruta_imagen ?? $imagenCategoria }}" 
     alt="{{ $alimento->nombre }}" 
     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                     
                <span class="absolute top-3 right-3 bg-emerald-100 text-emerald-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-emerald-200 shadow-sm z-10">
                    {{ $alimento->estado ?? 'Disponible' }}
                </span>
            </div>
            <div class="p-5 flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">
                            {{ $alimento->categoria ?? 'Alimento' }}
                        </span>
                        
                        <span class="text-xs font-medium text-gray-400">
                            Donante: {{ $alimento->usuario->nombre ?? 'Sin asignar' }}
                        </span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mt-1">{{ $alimento->nombre }}</h3>
                    <p class="text-xs text-gray-500 mt-1">
    Presentación: {{ $alimento->presentacion ?? 'N/A' }} • Expira: {{ $alimento->fecha_caducidad ?? 'N/A' }}
</p>
                </div>
                
                <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                    <span class="text-sm font-extrabold text-gray-800">
                       {{ $alimento->cantidad ?? 0 }} {{ $alimento->unidad ?? 'Unidades' }}
                    </span>
                    <div class="flex items-center space-x-3 text-xs font-semibold">
                        <a href="{{ route('alimentos.show', $alimento->id_alimento) }}" class="text-emerald-600 hover:text-emerald-800 transition">Consultar</a>
                        <a href="{{ route('alimentos.edit', $alimento->id_alimento) }}" class="text-amber-600 hover:text-amber-800 transition">Editar</a>
                        <form action="{{ route('alimentos.destroy', $alimento->id_alimento) }}" method="POST" class="inline"
                              onsubmit="return confirm('¿Seguro que deseas eliminar {{ $alimento->nombre }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 transition">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 bg-white rounded-xl border border-gray-200">
            <p class="text-gray-500 font-medium">No hay alimentos registrados en la base de datos.</p>
        </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $alimentos->links() }}
</div>

@endsection
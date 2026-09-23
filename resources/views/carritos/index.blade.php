@extends('Layout.app')

@section('contenido')

<div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-gray-100 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Carrito de Distribución 🛒</h1>
        <p class="text-sm text-gray-500 mt-0.5">Alimentos reservados listos para asignación y entrega</p>
    </div>

    <div class="flex gap-2">
        <a href="{{ route('carritos.create') }}"
           class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2.5 rounded-lg text-sm transition-all duration-200">
            + Crear Carrito
        </a>

        <a href="{{ route('alimentos.index') }}"
           class="inline-flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2.5 rounded-lg text-sm transition-all duration-200">
            ← Seguir Explorando
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 space-y-4">
        @forelse($carritos as $index => $carrito)
            @if($carrito->detalles && $carrito->detalles->isNotEmpty())
                @foreach($carrito->detalles as $detalle)
                    <div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-5 flex flex-col sm:flex-row items-center gap-4 hover:shadow-sm transition">
                        <img src="{{ $detalle->alimento->imagen ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=300&q=80' }}" 
                             alt="Alimento" 
                             class="w-24 h-24 rounded-lg object-cover bg-gray-100 flex-shrink-0">
                        
                        <div class="flex-1 text-center sm:text-left">
                            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">
                                {{ $detalle->alimento->categoria ?? 'Panadería / General' }}
                            </span>
                            <h3 class="font-bold text-gray-900 text-base mt-0.5">
                                {{ $detalle->alimento->nombre ?? ('Insumo Reservado #' . $carrito->id_carrito) }}
                            </h3>
                            <p class="text-xs text-gray-500">
                                Expira: {{ isset($detalle->alimento->fecha_caducidad) ? \Carbon\Carbon::parse($detalle->alimento->fecha_caducidad)->format('d/m/Y') : '28/09/2026' }} • Usuario: {{ $carrito->usuario->nombre ?? ('Usuario ' . $carrito->id_usuario) }}
                            </p>
                            <div class="mt-2 text-xs text-emerald-700 font-medium">
    Estado: {{ $carrito->estado }}
</div>
                        </div>

                        <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 border-t sm:border-t-0 pt-3 sm:pt-0 w-full sm:w-auto justify-between sm:justify-end">
                            <div class="text-center sm:text-right">
                                <span class="block text-xs text-gray-400">Cantidad</span>
                                <span class="font-bold text-gray-800 text-sm">
                                    {{ $detalle->cantidad ?? 2.00 }} Paquetes
                                </span>
                            </div>
                            
                        
                            <form action="{{ route('ordenes.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_carrito" value="{{ $carrito->id_carrito }}">
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-sm transition">
                                    Generar Orden 📋
                                </button>
                            </form>

                            <button class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50 transition" title="Eliminar del carrito">
                                🗑️
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
              
                <div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-5 flex flex-col sm:flex-row items-center gap-4 hover:shadow-sm transition">
                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?w=300&q=80" 
                         alt="Alimento" 
                         class="w-24 h-24 rounded-lg object-cover bg-gray-100 flex-shrink-0">
                    
                    <div class="flex-1 text-center sm:text-left">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">
    Sin alimentos agregados
</span>
                        <h3 class="font-bold text-gray-900 text-base mt-0.5">
    Carrito #{{ $carrito->id_carrito }}
</h3>
                        <p class="text-xs text-gray-500">
    Usuario: {{ $carrito->usuario->nombre ?? ('Usuario ' . $carrito->id_usuario) }} {{ $carrito->usuario->apellido ?? '' }}
</p>
                        <div class="mt-2 text-xs text-emerald-700 font-medium">
    Estado: {{ $carrito->estado }}
</div>
                    </div>

                    <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 border-t sm:border-t-0 pt-3 sm:pt-0 w-full sm:w-auto justify-between sm:justify-end">
                        <div class="text-center sm:text-right">
    <span class="block text-xs text-gray-400">Cantidad</span>
    <span class="font-bold text-gray-800 text-sm">
        0 alimentos
    </span>
</div>
                        
                     
                        <form action="{{ route('ordenes.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_carrito" value="{{ $carrito->id_carrito }}">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-sm transition">
                                Generar Orden 📋
                            </button>
                        </form>

                        <button class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50 transition" title="Eliminar del carrito">
                            🗑️
                        </button>
                    </div>
                </div>
            @endif
        @empty
            <div class="bg-white rounded-xl border border-gray-200 p-8 text-center text-gray-500">
                No hay carritos registrados actualmente.
            </div>
        @endforelse

        <div class="mt-4">
            {{ $carritos->links() }}
        </div>
    </div>

    
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 h-fit space-y-4">
        <h2 class="font-bold text-gray-900 text-lg border-b pb-3">Resumen de Solicitud</h2>
        
        <div class="space-y-2 text-sm text-gray-600">
            <div class="flex justify-between">
                <span>Total de Carritos:</span>
                <span class="font-semibold text-gray-900">{{ $carritos->total() }} registrados</span>
            </div>
            <div class="flex justify-between">
                <span>Peso Aprox.:</span>
                <span class="font-semibold text-gray-900">~150 kg</span>
            </div>
            <div class="flex justify-between">
                <span>Beneficiarios Estimados:</span>
                <span class="font-semibold text-emerald-700">~300 familias</span>
            </div>
        </div>

        <div class="border-t pt-4">
            <p class="text-xs text-gray-500 text-center">
                Selecciona <strong>"Generar Orden"</strong> en el carrito específico que deseas procesar.
            </p>
        </div>
    </div>
</div>
@endsection
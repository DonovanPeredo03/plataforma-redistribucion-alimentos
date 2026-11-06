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
        @forelse($carritos as $carrito)
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b pb-3 mb-3 gap-2">
                    <div>
                        <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Carrito #{{ $carrito->id_carrito }}</span>
                        <h3 class="font-bold text-gray-900 text-base">
                            Usuario: {{ $carrito->usuario->nombre ?? ('Usuario ' . $carrito->id_usuario) }} {{ $carrito->usuario->apellido ?? '' }}
                        </h3>
                    </div>
                    <div>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                            Estado: {{ $carrito->estado }}
                        </span>
                    </div>
                </div>

                <!-- Lista de alimentos dentro de este carrito -->
                <div class="space-y-2 mb-4">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Insumos seleccionados:</span>
                    @forelse($carrito->detalles as $detalle)
                        <div class="flex items-center justify-between bg-gray-50 p-2.5 rounded-lg border border-gray-100 text-sm">
                            <div class="flex items-center space-x-2">
                                <span class="font-medium text-gray-800">{{ $detalle->alimento->nombre ?? 'Alimento no disponible' }}</span>
                                <span class="text-xs text-gray-500">({{ $detalle->alimento->categoria ?? 'General' }})</span>
                            </div>
                            <span class="font-bold text-emerald-700 text-xs bg-emerald-50 px-2 py-1 rounded">
                                {{ $detalle->cantidad }} {{ $detalle->alimento->unidad ?? 'Unidades' }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-gray-500 italic">Este carrito no tiene alimentos asociados.</p>
                    @endforelse
                </div>

                <div class="flex flex-wrap items-center justify-between pt-3 border-t border-gray-100 gap-3">
                    <span class="text-xs text-gray-400">Creado: {{ \Carbon\Carbon::parse($carrito->fecha_creacion)->format('d/m/Y H:i') }}</span>
                    
                    <div class="flex items-center space-x-2">
                        <form action="{{ route('ordenes.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_carrito" value="{{ $carrito->id_carrito }}">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-sm transition">
                                Generar Orden 📋
                            </button>
                        </form>

                        <a href="{{ route('carritos.show', $carrito->id_carrito) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold px-2 py-1">Consultar</a>
                        <a href="{{ route('carritos.edit', $carrito->id_carrito) }}" class="text-amber-600 hover:text-amber-800 text-xs font-semibold px-2 py-1">Editar</a>
                        
                        <form action="{{ route('carritos.destroy', $carrito->id_carrito) }}" method="POST"
                              onsubmit="return confirm('¿Seguro que deseas eliminar el carrito #{{ $carrito->id_carrito }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50 transition" title="Eliminar carrito">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>
            </div>
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
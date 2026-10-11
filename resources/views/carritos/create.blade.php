@extends('Layout.app')

@section('contenido')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
    <div class="flex justify-between items-center pb-4 mb-6 border-b border-gray-100">
        <h1 class="text-2xl font-bold text-gray-900">Crear Carrito</h1>
        <a href="{{ route('carritos.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Regresar</a>
    </div>

    <form action="{{ route('carritos.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
   
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Usuario Asociado</label>
                <select name="id_usuario" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="">Selecciona un usuario</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id_usuario }}">{{ $usuario->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Estado del Carrito</label>
                <select name="estado" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="">Selecciona un estado</option>
                    <option value="Activo">Activo</option>
                    <option value="Completado">Completado</option>
                    <option value="Cancelado">Cancelado</option>
                </select>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Alimentos y Cantidades</label>
            <div class="space-y-3 max-h-72 overflow-y-auto p-4 border border-gray-200 rounded-lg bg-gray-50">
                @foreach($alimentos as $alimento)
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" name="alimentos[{{ $alimento->id_alimento }}][seleccionado]" value="1" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm text-gray-800 font-medium">{{ $alimento->nombre }} (Disponible: {{ $alimento->cantidad }} {{ $alimento->unidad }})</span>
                        </div>
                        <div>
                            <input type="number" step="0.01" min="0.01" max="{{ $alimento->cantidad }}" name="alimentos[{{ $alimento->id_alimento }}][cantidad]" placeholder="Cantidad" class="w-28 text-sm border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                    </div>
                @endforeach
            </div>
            @error('alimentos')
                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('carritos.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold">Guardar Carrito</button>
        </div>
    </form>
</div>
@endsection
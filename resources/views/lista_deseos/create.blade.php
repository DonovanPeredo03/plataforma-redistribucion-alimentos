@extends('layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Crear lista de deseos</h1>
    <a href="/lista de deseos" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">← Regresar</a>
</div>

<form class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Usuario Asociado</label>
        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            <option>Selecciona un usuario</option>
            <option>Salma Betzabeth Flores</option>
        </select>
    </div>
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Estado del Carrito</label>
        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            <option>Activo</option>
            <option>Procesado</option>
        </select>
    </div>
    <div class="md:col-span-2 flex justify-end gap-3 mt-2">
        <a href="/carritos" class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancelar</a>
        <button type="button" class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-5 py-2.5">Guardar Carrito</button>
    </div>
</form>
@endsection
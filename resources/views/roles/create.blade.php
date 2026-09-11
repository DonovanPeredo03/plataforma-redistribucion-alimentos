@extends('layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Crear Nuevo Rol</h1>
    <a href="/roles" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">← Regresar</a>
</div>

<form class="grid grid-cols-1 gap-6">
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Nombre del Rol</label>
        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Ej. Supervisor de Entregas">
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Descripción del Rol</label>
        <textarea rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300" placeholder="Detalla los accesos y funciones de este rol..."></textarea>
    </div>

    <div class="flex justify-end gap-3 mt-2">
        <a href="/roles" class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancelar</a>
        <button type="button" class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-5 py-2.5">Guardar Rol</button>
    </div>
</form>
@endsection
@extends('layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Registrar Órden</h1>
    <a href="/ordenes" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">← Regresar</a>
</div>

<form class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Cliente / Solicitante</label>
        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            <option>Selecciona un usuario</option>
            <option>Comedor Comunitario Tonala</option>
            <option>Comedor Comunitario Tlajomulco</option>
            <option>Comedor Comunitario Hospital</option>
        </select>
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Fecha Programada de Entrega</label>
        <input type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Estatus Inicial</label>
        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            <option>Pendiente</option>
            <option>Aprobada</option>
            <option>En Camino</option>
            <option>Entregada</option>
        </select>
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Alimentos a Incluir (Selección Múltiple)</label>
        <select multiple class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 h-24">
            <option>Manzanas (1 Cajas)</option>
            <option>Pan Blanco (2 Paquetes)</option>
            <option>Tomate (1 Caja)</option>
             <option>Arroz (2 Cajas)</option>
        </select>
    </div>

    <div class="md:col-span-2 flex justify-end gap-3 mt-2">
        <a href="/ordenes" class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancelar</a>
        <button type="button" class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-5 py-2.5">Guardar Órden</button>
    </div>
</form>
@endsection
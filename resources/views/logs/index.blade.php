@extends('layout.app')

@section('contenido')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Bitácora de Actividad del Sistema (Logs)</h1>
    <p class="text-sm text-gray-500">Registro automático de eventos y auditoría de acciones</p>
</div>

<div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-emerald-50">
            <tr>
                <th scope="col" class="px-6 py-3">ID Log</th>
                <th scope="col" class="px-6 py-3">Usuario</th>
                <th scope="col" class="px-6 py-3">Acción Realizada</th>
                <th scope="col" class="px-6 py-3">Fecha y Hora</th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-semibold text-gray-900">LOG-884</td>
                <td class="px-6 py-4 font-medium text-gray-900">Salma Betzabeth Flores</td>
                <td class="px-6 py-4">Registro de nuevo lote de manzanas en catálogo</td>
                <td class="px-6 py-4">06/09/2026 - 10:15 AM</td>
            </tr>
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-semibold text-gray-900">LOG-883</td>
                <td class="px-6 py-4 font-medium text-gray-900">Sistema</td>
                <td class="px-6 py-4">Generación de orden ORD-2026-001</td>
                <td class="px-6 py-4">06/09/2026 - 09:30 AM</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
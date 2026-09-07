@extends('layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Órdenes de Redistribución</h1>
        <p class="text-sm text-gray-500">Historial y estado de entregas solicitadas</p>
    </div>
    <a href="/ordenes/nuevo" class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-4 py-2.5">+ Registrar Órden</a>
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
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-semibold text-gray-900">ORD-2026-001</td>
                <td class="px-6 py-4 font-medium text-gray-900">Comedor Comunitario Tonallan</td>
                <td class="px-6 py-4">06/09/2026</td>
                <td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">En Camino</span></td>
                <td class="px-6 py-4 text-center space-x-2">
                    <a href="#" class="font-medium text-blue-600 hover:underline">Consultar</a>
                    <a href="#" class="font-medium text-amber-600 hover:underline">Editar</a>
                    <a href="#" class="font-medium text-red-600 hover:underline">Eliminar</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
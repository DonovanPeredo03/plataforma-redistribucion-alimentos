@extends('layout.app')

@section('contenido')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h1>
        <p class="text-sm text-gray-500">Administración de accesos y perfiles en la plataforma</p>
    </div>
    <a href="/usuarios/nuevo" class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-4 py-2.5 flex items-center gap-2 shadow-sm">
        + Registrar Usuario
    </a>
</div>

<div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-emerald-50">
            <tr>
                <th scope="col" class="px-6 py-3">ID</th>
                <th scope="col" class="px-6 py-3">Nombre</th>
                <th scope="col" class="px-6 py-3">Correo Electrónico</th>
                <th scope="col" class="px-6 py-3">Rol</th>
                <th scope="col" class="px-6 py-3">Estatus</th>
                <th scope="col" class="px-6 py-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-semibold text-gray-900">1</td>
                <td class="px-6 py-4 font-medium text-gray-900">Salma Betzabeth Flores</td>
                <td class="px-6 py-4">salma.flores@gmail.com</td>
                <td class="px-6 py-4"><span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Administrador</span></td>
                <td class="px-6 py-4"><span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Activo</span></td>
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
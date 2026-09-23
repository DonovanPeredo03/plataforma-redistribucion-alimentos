@extends('Layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Catálogo de Roles</h1>
        <p class="text-sm text-gray-500">Definición de roles de usuario y permisos</p>
    </div>
    <a href="{{ route('roles.create') }}"
   class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-4 py-2.5">
    + Nuevo Rol
</a>
</div>

<div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-emerald-50">
            <tr>
                <th scope="col" class="px-6 py-3">ID</th>
                <th scope="col" class="px-6 py-3">Nombre del Rol</th>
                <th scope="col" class="px-6 py-3">Descripción</th>
                <th scope="col" class="px-6 py-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $rol)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-semibold text-gray-900">
    {{ $rol->id_rol }}
</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $rol->nombre ?? $rol->name }}</td>
                    <td class="px-6 py-4">{{ $rol->descripcion ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="#" class="font-medium text-blue-600 hover:underline">Consultar</a>
                        <a href="#" class="font-medium text-amber-600 hover:underline">Editar</a>
                        <a href="#" class="font-medium text-red-600 hover:underline">Eliminar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 bg-white">
                        No hay roles registrados por el momento.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


@if($roles->hasPages())
    <div class="mt-4">
        {{ $roles->links() }}
    </div>
@endif
@endsection
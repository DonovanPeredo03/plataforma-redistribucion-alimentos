@extends('Layout.app')

@section('contenido')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h1>
        <p class="text-sm text-gray-500">Administración de accesos y perfiles en la plataforma</p>
    </div>
    <a href="{{ route('usuarios.create') }}" class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-4 py-2.5 flex items-center gap-2 shadow-sm">
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
            @forelse($usuarios as $usuario)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        {{ $usuario->id_usuario }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $usuario->nombre }} {{ $usuario->apellido }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $usuario->email }}
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $nombreRol = $usuario->rol->nombre ?? 'Usuario';
                            $badgeRol = match($nombreRol) {
                                'Administrador' => 'bg-purple-100 text-purple-800',
                                'Donante'       => 'bg-blue-100 text-blue-800',
                                'Comedor'       => 'bg-amber-100 text-amber-800',
                                default         => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <span class="{{ $badgeRol }} text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $nombreRol }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($usuario->estado)
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Activo</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Inactivo</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('usuarios.show', $usuario->id_usuario) }}" class="font-medium text-blue-600 hover:underline">Consultar</a>
                        <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" class="font-medium text-amber-600 hover:underline">Editar</a>
                        <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="POST" class="inline"
                              onsubmit="return confirm('¿Seguro que deseas eliminar al usuario {{ $usuario->nombre }} {{ $usuario->apellido }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No se encontraron usuarios registrados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4 bg-white border-t border-gray-200">
        {{ $usuarios->links() }}
    </div>
</div>
@endsection
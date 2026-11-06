@extends('Layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Consultar Usuario</h1>
        <p class="text-sm text-gray-500">Detalle del usuario #{{ $usuario->id_usuario }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" class="text-white bg-amber-500 hover:bg-amber-600 font-medium rounded-lg text-sm px-4 py-2">Editar</a>
        <a href="{{ route('usuarios.index') }}" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">← Regresar</a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 border border-gray-200 rounded-xl p-6">
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Nombre completo</span>
        <span class="block text-gray-900 font-medium">{{ $usuario->nombre }} {{ $usuario->apellido }}</span>
    </div>
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Correo Electrónico</span>
        <span class="block text-gray-900 font-medium">{{ $usuario->email }}</span>
    </div>
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Teléfono</span>
        <span class="block text-gray-900 font-medium">{{ $usuario->teléfono }}</span>
    </div>
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Dirección</span>
        <span class="block text-gray-900 font-medium">{{ $usuario->direccion }}</span>
    </div>
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Tipo de Login</span>
        <span class="block text-gray-900 font-medium">{{ $usuario->tipo_login }}</span>
    </div>
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Rol</span>
        <span class="block text-gray-900 font-medium">{{ $usuario->rol->nombre ?? 'Sin rol' }}</span>
    </div>
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Estatus</span>
        @if($usuario->estado)
            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Activo</span>
        @else
            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Inactivo</span>
        @endif
    </div>
    <div>
        <span class="block text-xs font-semibold text-gray-500 uppercase">Fecha de Registro</span>
        <span class="block text-gray-900 font-medium">{{ \Carbon\Carbon::parse($usuario->fecha_registro)->format('d/m/Y H:i') }}</span>
    </div>
</div>
@endsection

@extends('Layout.app')

@section('contenido')
@guest('admin')
<div class="max-w-md mx-auto bg-white border border-gray-200 rounded-xl shadow-sm p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-1">Acceso administrativo</h1>
    <p class="text-sm text-gray-500 mb-6">Ingresa con tu cuenta de administrador</p>

    <form method="POST" action="{{ route('admin.iniciar_sesion.enviar') }}" class="space-y-4">
        @csrf

        <div>
            <label for="correo" class="block mb-2 text-sm font-medium text-gray-900">Correo electrónico</label>
            <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required autofocus
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
        </div>

        <div>
            <label for="contrasena" class="block mb-2 text-sm font-medium text-gray-900">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" required
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
        </div>

        <div class="flex items-center">
            <input type="checkbox" id="recordarme" name="recordarme" class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded">
            <label for="recordarme" class="ms-2 text-sm font-medium text-gray-900">Recordarme</label>
        </div>

        <button type="submit" class="w-full text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-5 py-2.5">
            Entrar
        </button>
    </form>
</div>
@endguest
@endsection
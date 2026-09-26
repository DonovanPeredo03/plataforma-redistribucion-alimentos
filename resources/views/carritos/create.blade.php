@extends('Layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Crear Carrito</h1>

    <a href="{{ route('carritos.index') }}"
       class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">
        ← Regresar
    </a>
</div>

<form action="{{ route('carritos.store') }}" method="POST"
      class="grid grid-cols-1 md:grid-cols-2 gap-6">

    @csrf

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">
            Usuario Asociado
        </label>

        <select name="id_usuario" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">

            <option value="" selected disabled>
                Selecciona un usuario
            </option>

            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id_usuario }}">
                    {{ $usuario->nombre }} {{ $usuario->apellido }}
                </option>
            @endforeach

        </select>
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">
            Estado del Carrito
        </label>

        <select name="estado" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">

            <option value="" selected disabled>
                Selecciona un estado
            </option>

            <option value="Activo">Activo</option>
            <option value="Procesado">Procesado</option>

        </select>
    </div>

    <div class="md:col-span-2 flex justify-end gap-3 mt-2">

        <a href="{{ route('carritos.index') }}"
           class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">
            Cancelar
        </a>

        <button type="submit"
                class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-5 py-2.5">
            Guardar Carrito
        </button>

    </div>

</form>
@endsection
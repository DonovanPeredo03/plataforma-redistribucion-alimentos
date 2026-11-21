@extends('Layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Editar Carrito #{{ $carrito->id_carrito }}</h1>

    <a href="{{ route('carritos.index') }}"
       class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">
        ← Regresar
    </a>
</div>

<form action="{{ route('carritos.update', $carrito->id_carrito) }}" method="POST"
      class="grid grid-cols-1 md:grid-cols-2 gap-6">

    @csrf
    @method('PUT')

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">
            Usuario Asociado
        </label>

        <select name="id_usuario" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">

            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id_usuario }}" {{ old('id_usuario', $carrito->id_usuario) == $usuario->id_usuario ? 'selected' : '' }}>
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

            <option value="Activo" {{ old('estado', $carrito->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
            <option value="Procesado" {{ old('estado', $carrito->estado) == 'Procesado' ? 'selected' : '' }}>Procesado</option>

        </select>
    </div>

    <div class="md:col-span-2 flex justify-end gap-3 mt-2">

        <a href="{{ route('carritos.index') }}"
           class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">
            Cancelar
        </a>

        <button type="submit"
                class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-5 py-2.5">
            Guardar Cambios
        </button>

    </div>

</form>
@endsection

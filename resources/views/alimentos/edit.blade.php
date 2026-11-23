@extends('Layout.app')

@section('contenido')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Editar Alimento</h1>
        <p class="text-sm text-gray-500">Actualiza la información del alimento #{{ $alimento->id_alimento }}</p>
    </div>
    <a href="{{ route('alimentos.index') }}" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">
        ← Regresar a la lista
    </a>
</div>

<form action="{{ route('alimentos.update', $alimento->id_alimento) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @csrf
    @method('PUT')

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Nombre del Alimento</label>
        <input type="text" name="nombre" required minlength="2" maxlength="150"
        value="{{ old('nombre', $alimento->nombre) }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5"
        placeholder="Ej. Lote de Tomate Guajillo">
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Categoría</label>
        <select name="categoria" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
            @foreach(['Frutas y Verduras','Abarrotes y Enlatados','Panadería y Cereales','Lácteos y Refrigerados'] as $cat)
                <option value="{{ $cat }}" {{ old('categoria', $alimento->categoria) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Cantidad Disponible</label>
        <input type="number" name="cantidad" required min="0.01" max="99999999.99" step="0.01"
        value="{{ old('cantidad', $alimento->cantidad) }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" placeholder="10">
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Unidad</label>
        <select name="unidad" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
            @foreach(['Unidades','Kilogramos','Gramos','Litros'] as $u)
                <option value="{{ $u }}" {{ old('unidad', $alimento->unidad) == $u ? 'selected' : '' }}>{{ $u }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Fecha de Expiración / Consumo Preferente</label>
        <input type="date" name="fecha_caducidad" required
        value="{{ old('fecha_caducidad', \Carbon\Carbon::parse($alimento->fecha_caducidad)->format('Y-m-d')) }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
        <p class="mt-1 text-xs text-gray-500">Si no la modificas, se conserva la fecha actual aunque ya haya pasado.</p>
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Estado del Alimento</label>
        <select name="estado" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
            @foreach(['Disponible','Reservado','Agotado'] as $e)
                <option value="{{ $e }}" {{ old('estado', $alimento->estado) == $e ? 'selected' : '' }}>{{ $e }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Fotografía del Alimento</label>

        @if($alimento->ruta_imagen)
            <div class="mb-2">
                <img src="{{ $alimento->ruta_imagen }}" alt="{{ $alimento->nombre }}" class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                <p class="text-xs text-gray-500 mt-1">Imagen actual. Sube un archivo solo si deseas reemplazarla.</p>
            </div>
        @endif

        <input type="file" id="imagen" name="imagen" accept=".jpg,.jpeg,.png,.webp" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
        <p id="imagen-error" class="mt-1 text-sm text-red-600 hidden">
            La imagen no puede pesar más de 2 MB.
        </p>
    </div>

    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Tipo de Empaque / Conservación</label>
        <div class="flex items-center gap-4 mt-3">
            <div class="flex items-center">
                <input type="radio" name="conservacion" value="fresco" class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 focus:ring-emerald-500" {{ old('conservacion', $alimento->conservacion ?? 'fresco') == 'fresco' ? 'checked' : '' }}>
                <label class="ms-2 text-sm font-medium text-gray-900">Fresco / Temperatura Ambiente</label>
            </div>
            <div class="flex items-center">
                <input type="radio" name="conservacion" value="refrigerado" class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 focus:ring-emerald-500" {{ old('conservacion', $alimento->conservacion ?? 'fresco') == 'refrigerado' ? 'checked' : '' }}>
                <label class="ms-2 text-sm font-medium text-gray-900">Refrigerado / Congelado</label>
            </div>
        </div>
    </div>

    <div class="md:col-span-2">
        <label class="block mb-2 text-sm font-medium text-gray-900">Descripción / Estado de Conservación</label>
        <textarea name="descripcion" rows="3" required minlength="5" maxlength="1000" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Indica detalles relevantes sobre el empaque o condición de los alimentos...">{{ old('descripcion', $alimento->descripcion) }}</textarea>
    </div>

    <div class="md:col-span-2 flex justify-end gap-3 mt-2">
        <a href="{{ route('alimentos.index') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancelar</a>
        <button type="submit" class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-5 py-2.5">Guardar Cambios</button>
    </div>
</form>

<script>
    const inputImagen = document.getElementById('imagen');
    const errorImagen = document.getElementById('imagen-error');

    inputImagen.addEventListener('change', function () {
        const archivo = this.files[0];

        if (archivo && archivo.size > 2 * 1024 * 1024) {
            errorImagen.classList.remove('hidden');
            this.value = '';
        } else {
            errorImagen.classList.add('hidden');
        }
    });
</script>

@endsection

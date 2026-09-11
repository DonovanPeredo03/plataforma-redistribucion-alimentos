@extends('layout.app')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Registro de Alimento Excedente</h1>
        <p class="text-sm text-gray-500">Ingresa la información general del alimento a redistribuir</p>
    </div>
    <a href="/alimentos" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">
        ← Regresar a la lista
    </a>
</div>


<form class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Nombre del Alimento</label>
        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" placeholder="Ej. Lote de Tomate Guajillo">
    </div>

        <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Categoría</label>
        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
            <option selected>Selecciona una categoría</option>
            <option value="1">Frutas y Verduras</option>
            <option value="2">Abarrotes y Enlatados</option>
            <option value="3">Panadería y Cereales</option>
            <option value="4">Lácteos y Refrigerados</option>
        </select>
    </div>


    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Cantidad Disponible</label>
        <input type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" placeholder="10">
    </div>

  
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Fecha de Expiración / Consumo Preferente</label>
        <input type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
    </div>


    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Fotografía del Alimento</label>
        <input type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
    </div>

    
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">Tipo de Empaque / Conservación</label>
        <div class="flex items-center gap-4 mt-3">
            <div class="flex items-center">
                <input type="radio" name="conservacion" value="fresco" class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 focus:ring-emerald-500" checked>
                <label class="ms-2 text-sm font-medium text-gray-900">Fresco / Temperatura Ambiente</label>
            </div>
            <div class="flex items-center">
                <input type="radio" name="conservacion" value="refrigerado" class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 focus:ring-emerald-500">
                <label class="ms-2 text-sm font-medium text-gray-900">Refrigerado / Congelado</label>
            </div>
        </div>
    </div>

   
    <div class="md:col-span-2 flex items-center">
        <input type="checkbox" class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500" checked>
        <label class="ms-2 text-sm font-medium text-gray-900">Apto para entrega inmediata a asociaciones beneficiarias</label>
    </div>


    <div class="md:col-span-2">
        <label class="block mb-2 text-sm font-medium text-gray-900">Descripción / Estado de Conservación</label>
        <textarea rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Indica detalles relevantes sobre el empaque o condición de los alimentos..."></textarea>
    </div>

    
    <div class="md:col-span-2 flex justify-end gap-3 mt-2">
        <a href="/alimentos" class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancelar</a>
        <button type="button" class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-5 py-2.5">Guardar Alimento</button>
    </div>
</form>
@endsection
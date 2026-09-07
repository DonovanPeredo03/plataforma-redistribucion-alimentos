@extends('layout.app')

@section('contenido')

<div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-gray-100 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Lista de Deseos y Necesidades ⭐</h1>
        <p class="text-sm text-gray-500 mt-0.5">Alimentos prioritarios requeridos por comedores y organizaciones</p>
    </div>
    <button class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2.5 rounded-lg text-sm shadow-sm transition-all duration-200">
        + Agregar Nueva Necesidad
    </button>
</div>


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

  
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
        <div>
            <div class="flex justify-between items-start mb-3">
                <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-amber-200">
                    Prioridad Alta
                </span>
                <button class="text-gray-400 hover:text-red-500 transition" title="Quitar de la lista">
                    ❤️
                </button>
            </div>
            
            <h3 class="font-bold text-gray-900 text-lg">Arroz y Granos Básicos</h3>
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider block mt-1">Abarrotes</span>
            
            <p class="text-sm text-gray-600 mt-3">
                Se requieren costales de arroz o frijol para cubrir la preparación de comidas de esta semana.
            </p>
        </div>

        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
            <div>
                <span class="text-xs text-gray-400 block">Requerido</span>
                <span class="text-sm font-extrabold text-gray-800">100 kg</span>
            </div>
            <a href="{{ route('alimentos.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-800 bg-emerald-50 px-3 py-2 rounded-lg transition">
                Buscar Donante 🔍
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
        <div>
            <div class="flex justify-between items-start mb-3">
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-blue-200">
                    Prioridad Media
                </span>
                <button class="text-gray-400 hover:text-red-500 transition" title="Quitar de la lista">
                    ❤️
                </button>
            </div>
            
            <h3 class="font-bold text-gray-900 text-lg">Leche Entera / Lácteos</h3>
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider block mt-1">Lácteos</span>
            
            <p class="text-sm text-gray-600 mt-3">
                Para apoyo a desayunos infantiles en albergues locales.
            </p>
        </div>

        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
            <div>
                <span class="text-xs text-gray-400 block">Requerido</span>
                <span class="text-sm font-extrabold text-gray-800">50 Litros</span>
            </div>
            <a href="{{ route('alimentos.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-800 bg-emerald-50 px-3 py-2 rounded-lg transition">
                Buscar Donante 🔍
            </a>
        </div>
    </div>

</div>
@endsection
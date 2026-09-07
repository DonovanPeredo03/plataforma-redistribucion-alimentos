@extends('Layout.app')

@section('contenido')

<div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-gray-100 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Catálogo de Alimentos Excedentes</h1>
        <p class="text-sm text-gray-500 mt-0.5">Gestión y redistribución de insumos alimentarios (Hambre Cero)</p>
    </div>
    <a href="{{ route('alimentos.create') }}" class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2.5 rounded-lg text-sm shadow-sm transition-all duration-200">
        + Registrar Nuevo Alimento
    </a>
</div>


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
  
    <div class="group bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 flex flex-col">
        <div class="h-48 overflow-hidden bg-gray-100 relative">
            <img src="https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=500&q=80" 
                 alt="Manzanas" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <span class="absolute top-3 right-3 bg-emerald-100 text-emerald-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-emerald-200 shadow-sm">
                Disponible
            </span>
        </div>
        <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Frutas y Verduras</span>
                <h3 class="font-bold text-gray-900 text-lg mt-1">Manzanas</h3>
                <p class="text-xs text-gray-500 mt-1">Presentación: Caja 10kg • Expira: 15/09/2026</p>
            </div>
            
            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                <span class="text-sm font-extrabold text-gray-800">15 Cajas</span>
                <div class="flex items-center space-x-3 text-xs font-semibold">
                    <a href="#" class="text-emerald-600 hover:text-emerald-800 transition">Consultar</a>
                    <a href="#" class="text-amber-600 hover:text-amber-800 transition">Editar</a>
                    <a href="#" class="text-red-600 hover:text-red-800 transition">Eliminar</a>
                </div>
            </div>
        </div>
    </div>


    <div class="group bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 flex flex-col">
        <div class="h-48 overflow-hidden bg-gray-100 relative">
            <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?w=500&q=80" 
                 alt="Pan Artesanal" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <span class="absolute top-3 right-3 bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-amber-200 shadow-sm">
                Por Expirar
            </span>
        </div>
        <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Panadería</span>
                <h3 class="font-bold text-gray-900 text-lg mt-1">Pan Blanco Artesanal</h3>
                <p class="text-xs text-gray-500 mt-1">Presentación: Paquetes • Expira: 10/09/2026</p>
            </div>
            
            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                <span class="text-sm font-extrabold text-gray-800">30 Paquetes</span>
                <div class="flex items-center space-x-3 text-xs font-semibold">
                    <a href="#" class="text-emerald-600 hover:text-emerald-800 transition">Consultar</a>
                    <a href="#" class="text-amber-600 hover:text-amber-800 transition">Editar</a>
                    <a href="#" class="text-red-600 hover:text-red-800 transition">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
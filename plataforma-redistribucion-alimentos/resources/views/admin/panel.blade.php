@extends('Layout.app')

@section('contenido')
<div class="pb-6 mb-6 border-b border-gray-100">
    <h1 class="text-2xl font-bold text-gray-900">Panel administrativo</h1>
    <p class="text-sm text-gray-500 mt-0.5">Bienvenido, {{ auth('admin')->user()->nombre }}.</p>
</div>

<ul class="list-disc pl-6 text-sm text-gray-700 space-y-1">
    @can('modulo-alimentos')     <li>Puedes gestionar el catálogo de alimentos.</li> @endcan
    @can('modulo-ordenes')       <li>Puedes consultar órdenes, carritos y listas de deseos.</li> @endcan
    @can('modulo-logs')          <li>Puedes consultar los logs del sistema.</li> @endcan
    @can('administrar-usuarios') <li>Puedes administrar usuarios y roles.</li> @endcan
    @can('crear')                <li>Puedes crear registros.</li> @endcan
    @can('editar')               <li>Puedes editar registros.</li> @endcan
    @can('eliminar')             <li>Puedes eliminar registros.</li> @endcan
    @can('restaurar')            <li>Puedes restaurar o activar registros.</li> @endcan
</ul>
@endsection
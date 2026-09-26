@extends('Layout.app')

@section('contenido')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Bitácora de Logs y Auditoría 📜</h1>
        <p class="text-sm text-gray-500">Historial de acciones y eventos del sistema</p>
    </div>
</div>

<div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-emerald-50">
            <tr>
                <th scope="col" class="px-6 py-3">ID Log</th>
                <th scope="col" class="px-6 py-3">Usuario</th>
                <th scope="col" class="px-6 py-3">Acción / Evento</th>
                <th scope="col" class="px-6 py-3">Fecha y Hora</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        LOG-{{ str_pad($log->id_log, 4, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $log->nombre ? $log->nombre . ' ' . $log->apellido : 'Sistema / General' }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-1 rounded border border-gray-200">
                            {{ $log->accion }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500">
                        {{ \Carbon\Carbon::parse($log->fecha)->format('d/m/Y H:i:s') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        No hay registros de auditoría almacenados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4 bg-white border-t border-gray-200">
        {{ $logs->links() }}
    </div>
</div>
@endsection
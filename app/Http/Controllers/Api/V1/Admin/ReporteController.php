<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use App\Models\Usuario;
use App\Models\Alimento;
use App\Models\Orden;

class ReporteController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Reporte global generado correctamente.',
            'data' => [
                'total_clientes' => Usuario::count(),
                'total_administradores' => Administrador::count(),
                'administradores_activos' => Administrador::where(
                    'estado',
                    true
                )->count(),
                'total_alimentos' => Alimento::count(),
                'total_ordenes' => Orden::count(),
            ],
            'errors' => null,
        ], 200);
    }
}

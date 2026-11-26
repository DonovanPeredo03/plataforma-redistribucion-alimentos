<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Models\Alimento;

class CatalogoPublicoController extends Controller
{
    private function alimentosPublicos()
    {
        return Alimento::query()
            ->whereIn('estado', ['Disponible', 'Por Expirar'])
            ->whereDate('fecha_caducidad', '>=', today());
    }

    private function formatearAlimento($alimento)
    {
        return [
            'id_alimento' => $alimento->id_alimento,
            'nombre' => $alimento->nombre,
            'descripcion' => $alimento->descripcion,
            'categoria' => $alimento->categoria,
            'cantidad' => $alimento->cantidad,
            'unidad' => $alimento->unidad,
            'fecha_publicacion' => $alimento->fecha_publicacion,
            'fecha_caducidad' => $alimento->fecha_caducidad,
            'estado' => $alimento->estado,
            'ruta_imagen' => $alimento->ruta_imagen,
            'galeria' => $alimento->ruta_imagen
                ? [$alimento->ruta_imagen]
                : [],
        ];
    }

    public function index()
    {
        $alimentos = $this->alimentosPublicos()
            ->orderByDesc('id_alimento')
            ->get()
            ->map(fn ($alimento) => $this->formatearAlimento($alimento));

        return response()->json([
            'mensaje' => 'Catálogo público de alimentos.',
            'total' => $alimentos->count(),
            'data' => $alimentos,
        ], 200);
    }

    public function show($id)
    {
        $alimento = $this->alimentosPublicos()
            ->where('id_alimento', $id)
            ->first();

        if (!$alimento) {
            return response()->json([
                'mensaje' => 'Alimento no encontrado o no disponible.',
            ], 404);
        }

        return response()->json([
            'mensaje' => 'Detalle del alimento.',
            'data' => $this->formatearAlimento($alimento),
        ], 200);
    }

    public function informacion()
    {
        $alimentos = $this->alimentosPublicos()->get();

        $categorias = $alimentos
            ->groupBy('categoria')
            ->map(function ($grupo, $categoria) {
                return [
                    'nombre' => $categoria,
                    'total' => $grupo->count(),
                ];
            })
            ->values();

        return response()->json([
            'mensaje' => 'Información pública de la plataforma.',
            'data' => [
                'total_alimentos' => $alimentos->count(),
                'total_categorias' => $categorias->count(),
                'disponibles' => $alimentos
                    ->where('estado', 'Disponible')->count(),
                'por_expirar' => $alimentos
                    ->where('estado', 'Por Expirar')->count(),
                'categorias' => $categorias,
            ],
        ], 200);
    }
}

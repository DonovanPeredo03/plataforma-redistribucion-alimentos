<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class LogController extends Controller implements HasMiddleware
{
    public static function middleware(): array
{
    return [
        new Middleware('can:modulo-logs'),
        new Middleware('can:consultar', only: ['index', 'show']),
        new Middleware('can:crear',     only: ['create', 'store']),
        new Middleware('can:editar',    only: ['edit', 'update']),
        new Middleware('can:eliminar',  only: ['destroy']),
    ];
}


    public function index()
    {
        $logs = DB::table('logs')
            ->leftJoin('usuarios', 'logs.id_usuario', '=', 'usuarios.id_usuario')
            ->select('logs.*', 'usuarios.nombre', 'usuarios.apellido')
            ->orderBy('id_log', 'desc')
            ->paginate(10);

        return view('logs.index', compact('logs'));
    }
}
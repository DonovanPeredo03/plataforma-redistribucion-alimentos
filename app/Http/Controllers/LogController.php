<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
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
<?php
namespace App\Http\Controllers;
use App\Models\Orden;

class OrdenController extends Controller {
    public function index() {
        $ordenes = Orden::with(['usuario'])->paginate(10);
        return view('ordenes.index', compact('ordenes'));
    }
}
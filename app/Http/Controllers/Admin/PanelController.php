<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ResumenMensajes;
use Illuminate\View\View;

class PanelController extends Controller
{
    // Inyección de dependencias: Laravel ve el tipo ResumenMensajes y lo crea solo
    public function __construct(private ResumenMensajes $resumen)
    {
    }

    public function index(): View
    {
        return view('admin.panel', [
            'totalMensajes'  => $this->resumen->totalMensajes(),
            'totalNuevos'    => $this->resumen->totalNuevos(),
            'totalProductos' => $this->resumen->totalProductos(),
        ]);
    }
}

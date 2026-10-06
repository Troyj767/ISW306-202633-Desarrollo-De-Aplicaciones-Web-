<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ContactoController extends Controller
{
    public function create(): View
    {
        return view('contacto');
    }

    // Tarea 3 (Luisanna) reemplaza este método por el guardado real
    public function store(): JsonResponse
    {
        return response()->json(['ok' => false, 'error' => 'Guardado pendiente (Tarea 3).'], 501);
    }
}

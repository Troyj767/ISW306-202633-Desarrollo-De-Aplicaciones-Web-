<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarContactoRequest;
use App\Models\Mensaje;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ContactoController extends Controller
{
    public function create(): View
    {
        return view('contacto');
    }

    public function store(GuardarContactoRequest $request): JsonResponse
    {
        $mensaje = Mensaje::create($request->validated());

        return response()->json([
            'ok' => true,
            'mensaje' => 'Tu mensaje se ha guardado correctamente.',
            'id' => $mensaje->id,
        ]);
    }
}

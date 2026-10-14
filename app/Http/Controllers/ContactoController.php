<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarContactoRequest;
use App\Models\MensajeContacto;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

/** Formulario público de contacto (antes contacto.html + api/contacto_guardar.php). */
class ContactoController extends Controller
{
    public function create(): View
    {
        return view('contacto');
    }

    // Lo llama validacion.js con fetch(). Si los datos no pasan las reglas de
    // GuardarContactoRequest, este método ni siquiera se ejecuta.
    public function store(GuardarContactoRequest $request): JsonResponse
    {
        $datos = $request->validated();

        MensajeContacto::create([
            'nombre'      => $datos['nombre'],
            'email'       => $datos['email'],
            'telefono'    => $datos['telefono'],
            'producto_id' => Producto::where('slug', $datos['producto'])->value('id'), // "otro" -> null
            'mensaje'     => $datos['mensaje'],
            'estado'      => 'nuevo',
        ]);

        $primerNombre = explode(' ', $datos['nombre'])[0];

        return response()->json([
            'ok'      => true,
            'mensaje' => "¡Gracias, {$primerNombre}! Recibimos tu mensaje y te contactaremos pronto.",
        ]);
    }
}

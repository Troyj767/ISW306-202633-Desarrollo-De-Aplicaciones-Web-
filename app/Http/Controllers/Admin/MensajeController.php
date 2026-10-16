<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MensajeRequest;
use App\Models\MensajeContacto;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * CRUD de mensajes de contacto (antes admin/mensajes.php, mensaje_form.php
 * y mensaje_eliminar.php). Route::resource conecta cada URL con su método.
 */
class MensajeController extends Controller
{
    public function index(): View
    {
        $mensajes = MensajeContacto::with(['producto', 'atendidoPor'])
            ->latest()
            ->get();

        return view('admin.mensajes.index', compact('mensajes'));
    }

    public function create(): View
    {
        return view('admin.mensajes.form', [
            'mensaje'   => new MensajeContacto(['estado' => 'nuevo']),
            'productos' => Producto::orderBy('nombre')->get(),
        ]);
    }

    public function store(MensajeRequest $request): RedirectResponse
    {
        MensajeContacto::create($this->datos($request));

        return redirect()->route('admin.mensajes.index')->with('ok', 'Mensaje creado correctamente.');
    }

    // $mensaje llega ya buscado en la BD gracias al "route model binding"
    public function edit(MensajeContacto $mensaje): View
    {
        return view('admin.mensajes.form', [
            'mensaje'   => $mensaje,
            'productos' => Producto::orderBy('nombre')->get(),
        ]);
    }

    public function update(MensajeRequest $request, MensajeContacto $mensaje): RedirectResponse
    {
        $mensaje->update($this->datos($request));

        return redirect()->route('admin.mensajes.index')->with('ok', 'Mensaje actualizado correctamente.');
    }

    public function destroy(MensajeContacto $mensaje): RedirectResponse
    {
        $mensaje->delete();

        return redirect()->route('admin.mensajes.index')->with('ok', 'Mensaje eliminado correctamente.');
    }

    /** Datos ya validados + quién lo atendió (el usuario en sesión) */
    private function datos(MensajeRequest $request): array
    {
        $datos = $request->validated();
        $datos['atendido_por'] = $datos['estado'] === 'atendido' ? $request->user()->id : null;

        return $datos;
    }
}

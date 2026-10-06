<?php

namespace App\Services;

use App\Models\MensajeContacto;
use App\Models\Producto;

/**
 * Servicio con los números que muestra el panel.
 * No se crea con "new": el contenedor de Laravel lo construye y lo
 * inyecta en el constructor de PanelController (inyección de dependencias).
 */
class ResumenMensajes
{
    public function totalMensajes(): int
    {
        return MensajeContacto::count();
    }

    public function totalNuevos(): int
    {
        return MensajeContacto::where('estado', 'nuevo')->count();
    }

    public function totalProductos(): int
    {
        return Producto::count();
    }
}

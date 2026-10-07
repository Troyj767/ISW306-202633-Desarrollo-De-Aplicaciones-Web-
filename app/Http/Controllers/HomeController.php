<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $productos = Producto::orderBy('id')->get()->map(fn (Producto $producto) => [
            'id' => $producto->slug,
            'nombre' => $producto->nombre,
            'categoria' => $producto->categoria,
            'descripcion' => $producto->descripcion,
            'precio' => (float) $producto->precio,
            'oferta' => $producto->oferta,
            'imagen' => asset($producto->imagen),
        ]);

        return view('home', compact('productos'));
    }
}

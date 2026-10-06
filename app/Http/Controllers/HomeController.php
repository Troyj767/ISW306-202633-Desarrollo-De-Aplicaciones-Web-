<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    // Tarea 2 (Winston) completa este método con los productos de la BD
    public function index(): View
    {
        return view('home');
    }
}

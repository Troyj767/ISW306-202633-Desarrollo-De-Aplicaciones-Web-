<?php

use App\Http\Controllers\Admin\MensajeController;
use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| NovaShop — Fase 4: rutas (manejador de peticiones)
|--------------------------------------------------------------------------
| Cada URL se asocia a un método de un controlador. Antes (Fase 3) cada
| URL era un archivo .php suelto; ahora todo pasa por public/index.php y
| Laravel decide qué controlador atiende la petición.
*/

// Sitio público
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::get('/contacto', [ContactoController::class, 'create'])->name('contacto');
Route::post('/contacto', [ContactoController::class, 'store'])->name('contacto.store');

// Login: solo para invitados (si ya hay sesión, el middleware "guest" manda al panel)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1') // máximo 5 intentos por minuto
        ->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Panel de administración: el middleware "auth" reemplaza a requerirLogin() de la Fase 3
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [PanelController::class, 'index'])->name('panel');

    // CRUD de mensajes: index, create, store, edit, update, destroy
    Route::resource('mensajes', MensajeController::class)
        ->except(['show'])
        ->parameters(['mensajes' => 'mensaje']);
});

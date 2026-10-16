<?php

namespace Database\Seeders;

use App\Models\MensajeContacto;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Seeder;

/** Mensajes de ejemplo para que el CRUD no arranque vacío. */
class MensajeSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@novashop.com')->first();

        MensajeContacto::firstOrCreate(
            ['email' => 'cliente@ejemplo.com'],
            [
                'nombre'      => 'Cliente de prueba',
                'telefono'    => '(809) 555-1234',
                'producto_id' => Producto::where('slug', 'audifonos')->value('id'),
                'mensaje'     => 'Hola, quisiera saber si los audífonos tienen garantía.',
                'estado'      => 'nuevo',
            ]
        );

        MensajeContacto::firstOrCreate(
            ['email' => 'juan.porto@ejemplo.com'],
            [
                'nombre'       => 'Juan Porto',
                'telefono'     => '809-123-4567',
                'producto_id'  => null,
                'mensaje'      => 'Quiero un control de PS5.',
                'estado'       => 'atendido',
                'atendido_por' => $admin?->id,
            ]
        );
    }
}

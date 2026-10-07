<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

/** Los 4 productos del catálogo (los mismos de la Fase 3). */
class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            ['slug' => 'audifonos',  'nombre' => 'Audífonos inalámbricos',    'categoria' => 'tecnologia',    'descripcion' => 'Sonido envolvente y batería de larga duración.',   'precio' => 2450.00, 'oferta' => '-20% oferta', 'imagen' => 'img/audifono.png'],
            ['slug' => 'smartwatch', 'nombre' => 'Smartwatch deportivo',      'categoria' => 'tecnologia',    'descripcion' => 'Monitoreo de actividad física y notificaciones.',  'precio' => 4200.00, 'oferta' => null,          'imagen' => 'img/smartwatch.png'],
            ['slug' => 'mochila',    'nombre' => 'Mochila para laptop',       'categoria' => 'movilidad',     'descripcion' => 'Resistente al agua, con compartimento acolchado.', 'precio' => 1850.00, 'oferta' => null,          'imagen' => 'img/mochila.png'],
            ['slug' => 'lampara',    'nombre' => 'Lámpara LED de escritorio', 'categoria' => 'hogar-oficina', 'descripcion' => 'Tres niveles de brillo, carga USB.',               'precio' => 980.00,  'oferta' => null,          'imagen' => 'img/lampara-led.png'],
        ];

        foreach ($productos as $producto) {
            Producto::updateOrCreate(['slug' => $producto['slug']], $producto);
        }
    }
}

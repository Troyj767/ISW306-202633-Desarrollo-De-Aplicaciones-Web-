<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /** php artisan migrate --seed  (o  php artisan db:seed) */
    public function run(): void
    {
        $this->call([
            UsuarioDemoSeeder::class,
            ProductoSeeder::class,  // Tarea 6 (Carmen)
            MensajeSeeder::class,   // Tarea 6 (Carmen)
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsuarioDemoSeeder::class,
            // Tarea 6 (Carmen) agrega aquí ProductoSeeder y MensajeSeeder
        ]);
    }
}

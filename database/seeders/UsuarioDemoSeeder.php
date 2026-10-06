<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/** Usuario de demostración para el login del panel. */
class UsuarioDemoSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@novashop.com'],
            [
                'name'     => 'Administrador NovaShop',
                'password' => Hash::make('NovaShop2026'),
                'rol'      => 'admin',
            ]
        );
    }
}

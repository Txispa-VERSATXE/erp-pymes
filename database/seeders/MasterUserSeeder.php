<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterUserSeeder extends Seeder
{
    public function run(): void
    {
        // Solo crea el MasterUser si no existe
        if (!Usuario::where('email', 'master@erp-pymes.com')->exists()) {
            Usuario::create([
                'nombre'   => 'MasterUser',
                'email'    => 'master@erp-pymes.com',
                'password' => Hash::make('M@st3r2026!'),
                'rol'      => 'masteradmin',
            ]);
        }
    }
}
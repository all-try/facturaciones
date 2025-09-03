<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador por defecto
        User::firstOrCreate(
            ['email' => 'admin@facturaciones.com'],
            [
                'name' => 'Administrador',
                'email' => 'admin@facturaciones.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Crear usuario vendedor de ejemplo
        User::firstOrCreate(
            ['email' => 'vendedor@facturaciones.com'],
            [
                'name' => 'Vendedor Ejemplo',
                'email' => 'vendedor@facturaciones.com',
                'password' => Hash::make('vendedor123'),
                'role' => 'vendedor',
                'email_verified_at' => now(),
            ]
        );
    }
}

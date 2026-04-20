<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'jefe@policia.gob'], // correo del jefe
            [
                'name'      => 'Jefe de Comando',
                'password'  => Hash::make('password_segura_123'), // cámbiala luego
                'role'      => 'superadmin',
                'is_active' => true,
            ]
        );
    }
}


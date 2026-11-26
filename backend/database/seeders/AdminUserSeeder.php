<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    /** Create the first SuperAdmin from configuration without resetting existing accounts. */
    public function run(): void
    {
        $name = trim((string) config('admin.superadmin.name'));
        $email = trim((string) config('admin.superadmin.email'));
        $password = (string) config('admin.superadmin.password');

        if ($name === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 12) {
            throw new RuntimeException(
                'Configure SUPERADMIN_NAME, a valid SUPERADMIN_EMAIL and SUPERADMIN_PASSWORD (at least 12 characters) before running db:seed.'
            );
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => 'superadmin',
                'is_active' => true,
            ]
        );

        if ($user->role !== 'superadmin') {
            throw new RuntimeException(
                'The configured SUPERADMIN_EMAIL already belongs to a non-SuperAdmin account. Use a different email or review that account manually.'
            );
        }
    }
}

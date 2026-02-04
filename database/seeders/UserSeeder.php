<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['super_admin', 'pengguna_asn', 'kabid', 'operator'];

        foreach ($roles as $role) {
            User::create([
                'uuid' => Str::uuid(),
                'nama' => 'User ' . ucfirst($role),
                'username' => str_replace('_', '', $role),
                'email' => $role . '@mail.com',
                'password' => Hash::make('password'),
                'role' => $role,
            ]);
        }
    }
}

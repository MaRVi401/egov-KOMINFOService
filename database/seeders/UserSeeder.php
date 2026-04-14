<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SuperAdmin;
use App\Models\PenggunaAsn;
use App\Models\Kabid;
use App\Models\Operator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        SuperAdmin::truncate();
        PenggunaAsn::truncate();
        Kabid::truncate();
        Operator::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Buat KHUSUS 1 Super Admin
        $adminUuid = (string) Str::uuid();
        User::create([
            'uuid'     => $adminUuid,
            'nama'     => "Ahmad Yassin",
            'username' => 'superadmin',
            'password' => Hash::make('12345678'),
            'role'     => 'super_admin',
            'email'    => 'ahmad.yassin@mail.com',
            'no_wa'    => '081234567890',
            'alamat'   => 'Kantor Pusat Super Admin',
        ]);

        SuperAdmin::create([
            'uuid'     => (string) Str::uuid(),
            'users_id' => $adminUuid,
            'nip'      => '199001012024011001',
        ]);


        // 2. Role lainnya: pengguna_asn, kabid, operator
        $otherRoles = [
            'pengguna_asn' => PenggunaAsn::class,
            'kabid'        => Kabid::class,
            'operator'     => Operator::class,
        ];

        for ($i = 1; $i <= 19; $i++) {
            // Pilih role secara bergantian
            $roleKey = array_keys($otherRoles)[$i % count($otherRoles)];
            $modelClass = $otherRoles[$roleKey];

            $userUuid = (string) Str::uuid();
            User::create([
                'uuid'     => $userUuid,
                'nama'     => "User " . Str::headline($roleKey) . " $i",
                'username' => $roleKey . $i,
                'password' => Hash::make('password'),
                'role'     => $roleKey,
                'email'    => $roleKey . $i . "@mail.com",
                'no_wa'    => "081234567" . rand(100, 999) . $i,
                'alamat'   => "Alamat " . Str::headline($roleKey) . " nomor $i",
            ]);

            $modelClass::create([
                'uuid'     => (string) Str::uuid(),
                'users_id' => $userUuid,
                'nip'      => "199" . rand(10, 99) . "0101" . rand(1000, 9999) . $i,
            ]);
        }

        $this->command->info('Berhasil: UserSeeder telah dijalankan.');
    }
}
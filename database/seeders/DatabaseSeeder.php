<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Role dengan firstOrCreate agar aman dari duplikasi
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'manajer']);
        Role::firstOrCreate(['name' => 'karyawan']);

        // 2. Membuat Akun Admin Pertama (Cek berdasarkan email)
        $admin = User::firstOrCreate(
            ['email' => 'admin@btm.com'], // Kunci pencar   ian
            [
                'name' => 'Admin Operasional',
                'password' => bcrypt('password123'), // Hanya diisi jika user baru dibuat
            ]
        );

        // 3. Menugaskan Role 'Admin' ke akun tersebut
        // Menggunakan syncRoles agar tidak terjadi duplikasi penugasan
        $admin->syncRoles(['admin']);
    }
}

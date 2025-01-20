<?php

namespace Database\Seeders;

use App\Models\akun;
use App\Models\pengguna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class penggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        akun::insert([
            [
                'username' => 'admin',
                'password' => 'admin',
                'role' => 'Admin'
            ],
            [
                'username' => 'pengajar',
                'password' => 'pengajar',
                'role' => 'Pengajar'
            ],
            [
                'username' => 'siswa',
                'password' => 'siswa',
                'role' => 'Siswa'
            ]
        ]);

        pengguna::insert([
            [
                'nama' => 'Budiono',
                'email' => 'budiono@gmail.com',
                'alamat' => 'Jl. Raya Cibinong',
                'no_telp' => '081234567890',
                'mekanik' => '0',
                'elektronik' => '0',
                'pemrograman' => '0',
            ]
        ]);
    }
}

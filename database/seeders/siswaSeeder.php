<?php

namespace Database\Seeders;

use App\Models\akun;
use App\Models\pengguna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Profiler\Profile;

class siswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $akun = akun::create([
            'username' => 'siswa',
            'password' => Hash::make('siswa'),
            'role' => 'siswa',
        ]);

        pengguna::create([
            'id' => $akun->id,
            'nama' => 'Siska Wahyuni',
            'email' => 'siska@gmail.com',
            'alamat' => 'Jl. Siswa No. 123',
            'no_telp' => '081234567890',
            'mekanik' => 0,
            'elektronik' => 0,
            'pemrograman' => 0,
        ]);
    }
}

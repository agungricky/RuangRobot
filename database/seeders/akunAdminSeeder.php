<?php

namespace Database\Seeders;

use App\Models\akun;
use App\Models\pengguna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class akunAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $akun = akun::create([
            'username' => 'Julian',
            'password' => Hash::make('ruangrobot'),
            'role' => 'admin',
        ]);

        pengguna::create([
                'id' => $akun->id,
                'nama' => 'Julian',
                'email' => 'ruangrobotkdr@gmail.com',
                'alamat' => 'Perum Mojoroto Indah',
                'no_telp' => '+6285655770506',
                'mekanik' => 0,
                'elektronik' => 0,
                'pemrograman' => 0,
                'sekolah_id' => null,
                'status_verifikasi' => 'yes'
        ]);
    }
}

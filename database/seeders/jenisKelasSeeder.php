<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class jenisKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::insert([
            ['jenis_kelas' => 'Meker'],
            ['jenis_kelas' => 'Programing'],
            ['jenis_kelas' => 'Game Programing'],
            ['jenis_kelas' => 'Project'],
        ]);
    }
}

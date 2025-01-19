<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Tipekelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class tipeKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tipekelas::insert([
            ['tipe_kelas' => 'Meker'],
            ['tipe_kelas' => 'Programing'],
            ['tipe_kelas' => 'Game Programing'],
            ['tipe_kelas' => 'Project'],
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Tipekelas;
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
            ['jenis_kelas' => 'Kelas Reguler'],
            ['jenis_kelas' => 'Kelas Ekskul'],
            ['jenis_kelas' => 'Kelas Lomba'],
            ['jenis_kelas' => 'Kelas Project'],
            ['jenis_kelas' => 'Kelas Trial'],
        ]);
    }
}

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
            ['kategori_kelas' => 'Kelas Reguler'],
            ['kategori_kelas' => 'Kelas Ekskul'],
            ['kategori_kelas' => 'Kelas Lomba'],
            ['kategori_kelas' => 'Kelas Project'],
            ['kategori_kelas' => 'Kelas Trial'],
        ]);
    }
}

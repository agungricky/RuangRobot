<?php

namespace Database\Seeders;

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
            ['nama_kategori' => 'Kelas Reguler'],
            ['nama_kategori' => 'Kelas Ekskul'],
            ['nama_kategori' => 'Kelas Lomba'],
            ['nama_kategori' => 'Kelas Project'],
            ['nama_kategori' => 'Kelas Trial'],
        ]);
    }
}

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
            ['nama_kategori' => 'Meker'],
            ['nama_kategori' => 'Programing'],
            ['nama_kategori' => 'Game Programing'],
            ['nama_kategori' => 'Project'],
        ]);
    }
}

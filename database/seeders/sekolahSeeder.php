<?php

namespace Database\Seeders;

use App\Models\sekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class sekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        sekolah::insert([
            [
                'nama_sekolah' => 'Sd Rahmat Kota Kediri',
                'guru' => 'Bu Rini',
                'no_hp' => '+6281234567890',
            ],
            [
                'nama_sekolah' => 'Sd Al-huda2 Kota Kediri',
                'guru' => 'Bu Ajeng',
                'no_hp' => '+6281234902922',
            ],
            [
                'nama_sekolah' => 'Sd Lab Kota Kediri',
                'guru' => 'Pak Jayus',
                'no_hp' => '+62812345929',
            ],
            [
                'nama_sekolah' => 'Smp IT Bina Insani Kota Kediri',
                'guru' => 'Bu Aida',
                'no_hp' => '+6281234567820',
            ]
        ]);
    }
}

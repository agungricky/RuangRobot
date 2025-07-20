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
        sekolah::create([
            'nama_sekolah' => 'Mts Negeri 2 Kediri',
            'guru' => 'Ulum',
            'no_hp' => '+62351-123456',
        ]);

    }
}

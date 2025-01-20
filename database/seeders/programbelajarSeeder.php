<?php

namespace Database\Seeders;

use App\Models\programbelajar;
use App\Models\Tipekelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class programbelajarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = Tipekelas::select('id', 'tipe_kelas')->get();
        $level = ['mudah', 'sedang', 'sulit'];

        programbelajar::insert([
            [
                'nama_program' => 'Robotik Beginner Level 1 - #1 Robot Beroda',
                'deskripsi' => 'Belajar Aduino Beginer',
                'level' => $level[array_rand($level)],
                'tipe_kelas_id' => $data->random()->id,
                'mekanik' => 1,
                'elektronik' => 1,
                'pemrograman' => 1,
            ], 
            [
                'nama_program' => 'Robotik Beginner Level 1 - #2 Robot Amphibi',
                'deskripsi' => 'program belajar robotik beginner level 1 membuat robot amphibi (bisa berjalan di darat dan di air) sederhana',
                'level' => $level[array_rand($level)],
                'tipe_kelas_id' => $data->random()->id,
                'mekanik' => 1,
                'elektronik' => 1,
                'pemrograman' => 1,
            ], 
            [
                'nama_program' => 'Robotik Beginner Level 1 - #3 Robot Remote Lite',
                'deskripsi' => 'program belajar robotik beginner level 1 membuat robot remote kabel dua tombol sederhana',
                'level' => $level[array_rand($level)],
                'tipe_kelas_id' => $data->random()->id,
                'mekanik' => 1,
                'elektronik' => 1,
                'pemrograman' => 1,
            ], 
            [
                'nama_program' => 'Robotik Beginner Level 1 - #4 Robot Line Follower',
                'deskripsi' => 'program belajar robotik beginner level 1 membuat robot pengikut garis sederhana',
                'level' => $level[array_rand($level)],
                'tipe_kelas_id' => $data->random()->id,
                'mekanik' => 1,
                'elektronik' => 1,
                'pemrograman' => 1,
            ], 
            [
                'nama_program' => 'Robotik Beginner Level 2 - #1 Robot Remote',
                'deskripsi' => 'program belajar robotik beginner level 2 membuat robot remote kabel dengan 4 kombinasi tombol',
                'level' => $level[array_rand($level)],
                'tipe_kelas_id' => $data->random()->id,
                'mekanik' => 1,
                'elektronik' => 1,
                'pemrograman' => 1,
            ], 
        ]);
    }
}

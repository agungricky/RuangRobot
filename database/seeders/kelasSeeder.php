<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\kelas;
use App\Models\pengguna;
use App\Models\programbelajar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class kelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $program_belajar = ProgramBelajar::all();
        $pengajar = Pengguna::all();
        $kategori_kelas = Kategori::all();
        $gaji = [15000, 20000, 25000, 30000];
        $harga_kls = [400000, 500000, 600000, 700000];

        // dd($pengajar);

        $kelas = ['Robotik', 'Programming', 'Desain Grafis', 'Multimedia'];
        $jenjang = ['SMPIT', 'SMAIT', 'SDIT'];
        $sekolah = 'BINA INSANI';
        $platform = ['Laravel', 'WordPress', 'Python', 'Java'];
        $semester = ['GANJIL', 'GENAP'];

        // Cek jika data yang dibutuhkan tersedia
        // if ($program_belajar->isEmpty() || $pengajar->isEmpty() || $kategori_kelas->isEmpty()) {
        //     $this->command->error('Data program belajar, pengguna, atau kategori kelas kosong. Pastikan sudah diisi!');
        //     return;
        // }

        for ($i = 0; $i < 10; $i++) {
            Kelas::insert([
                [
                    'nama_kelas' => $kelas[array_rand($kelas)] . ' ' .
                        $jenjang[array_rand($jenjang)] . ' ' .
                        $sekolah . ' ' .
                        $platform[array_rand($platform)] . ' ' .
                        $semester[array_rand($semester)] . ' ' .
                        rand(2023, 2026) . '/' . rand(2024, 2027),
                    'harga' => $harga_kls[array_rand($harga_kls)],
                    'durasi_belajar' => '11.00-13.00',
                    'program_belajar_id' => $program_belajar->random()->id,
                    'kategori_kelas_id' => $kategori_kelas->random()->id,
                    'penanggung_jawab' => $pengajar->random()->nama, // Menggunakan ID
                    'gaji_pengajar' => $gaji[array_rand($gaji)],
                    'gaji_transport' => $gaji[array_rand($gaji)],
                    'status_kelas' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
        }
    }
}

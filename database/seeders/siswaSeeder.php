<?php

namespace Database\Seeders;

use App\Models\akun;
use App\Models\pengguna;
use App\Models\sekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class siswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction(); // Mulai transaksi

        try {
            $faker = Faker::create('id_ID'); // Faker dengan lokal Indonesia

            for ($i = 1; $i <= 100; $i++) {
                // Ambil sekolah random dari database
                $sekolah = Sekolah::inRandomOrder()->first();

                // Buat data akun
                $akun = Akun::create([
                    'username' => 'siswa_' . $i,
                    'password' => bcrypt('siswa'),
                    'role' => 'siswa',
                ]);

                // Buat data pengguna
                Pengguna::create([
                    'id' => $akun->id,
                    'nama' => $faker->name, // Nama asli dari Faker
                    'email' => $faker->unique()->email, // Email random dari Faker
                    'alamat' => $faker->address, // Alamat random dari Faker
                    'no_telp' => '+62' . $faker->unique()->numerify('8##########'),
                    'mekanik' => rand(0, 100), // Nilai mekanik random (0-100)
                    'elektronik' => rand(0, 100), // Nilai elektronik random (0-100)
                    'pemrograman' => rand(0, 100), // Nilai pemrograman random (0-100)
                    'sekolah_id' => $sekolah->id, // Nama sekolah random
                ]);
            }

            DB::commit(); // Commit transaksi jika tidak ada error
            echo "100 data siswa berhasil dibuat!";
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika ada error
            echo "Terjadi kesalahan, data tidak berhasil dibuat.";
        }
    }
}

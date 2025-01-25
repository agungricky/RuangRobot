<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\muridKelas;
use App\Models\pembelajaran;
use App\Models\pengguna;
use App\Models\programbelajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pembelajaranController extends Controller
{
    public function kuy()
    {
        // Ambil data dari database
        $data = pembelajaran::where('kelas_id', 14)->get();

        // Inisialisasi array untuk menyimpan total presensi
        $totalPresensi = [];

        // Proses setiap pertemuan
        foreach ($data as $pertemuan) {
            $absensiList = json_decode($pertemuan->absensi, true) ?? [];

            // Hitung kehadiran "H"
            foreach ($absensiList as $absensi) {
                if (isset($absensi['presensi']) && $absensi['presensi'] === 'H') {
                    $id = $absensi['id'];
                    if (isset($totalPresensi[$id])) {
                        $totalPresensi[$id]++;
                    } else {
                        $totalPresensi[$id] = 1;
                    }
                }
            }
        }

        // Tambahkan total presensi ke data respons
        return response()->json([
            'data' => $data,
            'total_presensi' => $totalPresensi,
        ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $data = pembelajaran::join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->select('pembelajaran.*', 'kelas.durasi_belajar')
            ->where('kelas_id', $id)->get();
        return response()->json(['data' => $data]);
    }

    public function siswa()
    {
        $data = pengguna::join('akun', 'akun.id', 'profile.id')
            ->join('sekolah', 'sekolah.id', 'profile.sekolah_id')
            ->select('profile.*', 'akun.role', 'sekolah.nama_sekolah')
            ->where('akun.role', 'Siswa')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function datasiswa($id)
    {
        $data = muridKelas::where('kelas_id', $id)->first();
        return response()->json(['data' => $data]);
    }

    // public function kelas($id)
    // {
    //     $data = kelas::all();
    //     return response()->json(['data' => $data]);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->jumlah_pertemuan;
        $id_kelas = $request->id_kelas;
        $kelas = pembelajaran::join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->where('kelas.id', $id_kelas)
            ->count();

        $tambah_pertemuan = $kelas + $data;

        for ($i = $kelas; $i < $tambah_pertemuan; $i++) {
            pembelajaran::create([
                'pertemuan' => $i + 1,
                'pengajar' => '',
                'tanggal' => null,
                'materi' => '',
                'catatan_pengajar' => '',
                'absensi' => json_encode(new \stdClass()),
                'status_tersimpan' => 'sementara',
                'kelas_id' => $id_kelas,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function detailPertemuan(string $id)
    {
        $data = pembelajaran::where('id', $id)->first();
        return response()->json(['data' => $data]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'pertemuan' => 'required|integer|min:1', // Sesuaikan validasi sesuai kebutuhan
        ]);

        // Update data
        $pembelajaran = pembelajaran::findOrFail($id);
        $pembelajaran->update([
            'pertemuan' => $request->pertemuan,
        ]);

        return response()->json([
            'message' => 'Data berhasil diperbarui!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        pembelajaran::where('id', $id)->delete();
        return back()->with('success', 'Data berhasil diperbarui!');
    }

    // ======================================== //
    // ============= MURID KELAS ============== //
    // ======================================== //


    /**
     * Update the specified resource in storage.
     */
    public function addSiswa(Request $request, $id)
    {
        $validatedData = $request->validate([
            'siswa' => 'required|array', // Pastikan `siswa` adalah array
        ]);

        $kelas = MuridKelas::where('kelas_id', $id)->first();

        if (!$kelas) {
            return response()->json(['message' => 'Kelas tidak ditemukan!'], 404);
        }

        // Decode data siswa yang sudah ada
        $existingSiswa = json_decode($kelas->murid, true) ?? [];

        // Konversi harga dan tagihan menjadi integer
        $newSiswa = array_map(function ($siswa) {
            $siswa['id'] = isset($siswa['id']) ? (int) $siswa['id'] : 0;
            $siswa['tagihan'] = isset($siswa['tagihan']) ? (int) $siswa['tagihan'] : 0;
            $siswa['pembayaran'] = isset($siswa['pembayaran']) ? (int) $siswa['pembayaran'] : 0;
            return $siswa;
        }, $validatedData['siswa']);

        // Gabungkan data siswa baru dengan data siswa yang sudah ada
        $mergedSiswa = array_merge($existingSiswa, $newSiswa);

        // Simpan data yang diperbarui
        $kelas->murid = json_encode($mergedSiswa);
        $kelas->save();

        return response()->json(['message' => 'Data siswa berhasil ditambahkan!'], 201);
    }

    public function hapus(Request $request)
    {

        $id = $request->id; // ID murid yang ingin dihapus
        $id_kelas = $request->kelas_id; // ID kelas

        // Ambil data murid dari kolom murid di tabel murid_kelas
        $muridData = DB::table('murid_kelas')
            ->where('kelas_id', $id_kelas)
            ->value('murid');

        // Ubah JSON menjadi array
        $muridArray = json_decode($muridData, true);

        if (is_array($muridArray)) {
            // Hapus murid berdasarkan ID
            $muridArray = array_filter($muridArray, function ($siswa) use ($id) {
                return $siswa['id'] != $id;
            });

            // Simpan kembali ke database dalam bentuk JSON
            DB::table('murid_kelas')
                ->where('kelas_id', $id_kelas)
                ->update(['murid' => json_encode(array_values($muridArray))]);
        }
    }
}

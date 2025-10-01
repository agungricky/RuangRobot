<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\indexPendaftaran;
use App\Models\invoice;
use App\Models\Kategori;
use App\Models\kelas;
use App\Models\keuangan;
use App\Models\muridKelas;
use App\Models\pendaftaran;
use App\Models\pengguna;
use App\Models\riwayatPembayaran;
use App\Models\sekolah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class pendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = indexPendaftaran::with('kategori')->withCount('pendaftaran')->orderBy('id', 'desc')->get();
        // dd($data->toArray());
        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }
        return view('pages.administrasi.validasi');
    }

    public function search_siswa($id)
    {
        $data = akun::with('pengguna')->where('id', $id)->first();
        return response()->json([
            'data' => $data
        ]);
    }

    public function search_kelas()
    {
        $data = kelas::all();
        return response()->json([
            'data' => $data
        ]);
    }

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
        $validated = $request->validate([
            'code_id' => 'required|string|max:100',
            'nama' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'email' => 'required|email|max:100',
            'no_telp' => 'required|string|max:15',
            'sekolah_id' => 'nullable|string|max:100',
            'kelas' => 'nullable|string|max:20',
            'alamat' => 'required|string',
            'kategori' => 'required|string',
        ]);

        if (isset($validated['kelas']) && !empty($validated['kelas'])) {
            $validated['kelas'] = strtoupper($validated['kelas']);
        }

        pendaftaran::create($validated);
        return redirect()->route('login')->with('success', 'Registrasi berhasil, Anda akan dihubungi oleh Admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $indexPendaftaran = indexPendaftaran::with('kategori')->find($id);
        $data = pendaftaran::with('sekolah')->where('code_id', $indexPendaftaran->code)->get();
        $count = $data->count();
        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.administrasi.validasi.detail', compact('id', 'indexPendaftaran', 'count'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        pendaftaran::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Data Pendaftra berhasil di Hapus');
    }

    public function acc_pendaftaran(Request $request)
    {
        $validated = $request->validate([
            'username'      => 'required|string|max:100|unique:akun,username,' . $request->id,
            'password'      => 'required|string|min:6',
            'role'          => 'required|in:Siswa',
            'sekolah_id'    => 'required|exists:sekolah,id',
            'nama'          => 'required|string|max:150',
            'tgl_lahir'     => 'required|date',
            'kelas'         => 'required|string|max:50',
            'email'         => 'required|email|max:150',
            'alamat'        => 'required|string|max:255',
            'no_telp'       => 'required|string|max:20',
            'mekanik'       => 'required|in:0,1,2,3',
            'elektronik'    => 'required|in:0,1,2,3',
            'pemrograman'   => 'required|in:0,1,2,3',
            'kelas_id'      => 'required|exists:kelas,id',
        ]);

        DB::beginTransaction();

        try {
            $sekolah = sekolah::where('id', $request->sekolah_id)->first();
            $kelas = kelas::where('id', $validated['kelas_id'])->first();
            $pendaftaran_siswa = pendaftaran::where('id', $request->id)->first();

            // ================= Pembuatan Akun ================= //
            $akun = akun::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            $profile = pengguna::create([
                'id' => $akun->id,
                'nama' => $request->nama,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'akun_id' => $akun->id,
                'sekolah_id' => $request->sekolah_id,
                'kelas' => $request->kelas,
                'mekanik' => $request->mekanik,
                'elektronik' => $request->elektronik,
                'pemrograman' => $request->pemrograman,
            ]);

            $dataPendaftar = [
                [
                    "id" => $akun->id,
                    "nama" => $profile->nama,
                    "nilai" => null,
                    "sekolah" => $sekolah->nama_sekolah,
                    "kelas" => $profile->kelas,
                    "tagihan" => $kelas->harga,
                    "no_sertiv" => "Belum Terbit",
                    "created_at" => Carbon::now(),
                    "no_invoice" => 'INV-' . date('dmy') . '-' . rand(1000, 9999),
                    "pembayaran" => "0",
                    "updated_at" => Carbon::now(),
                    "jatuh_tempo" => $kelas->jatuh_tempo,
                    "status_sertiv" => "Belum Terbit",
                ],
            ];


            // ================= Masukkan siswa ke kelas ================= //
            $datamurid_kelas = muridKelas::where('kelas_id', $kelas->id)->first();

            if ($datamurid_kelas == null) {
                $datamurid_kelas = muridKelas::create([
                    'murid' => json_encode([]),
                    'kelas_id' => $kelas->id,
                ]);
            }

            $existing = $datamurid_kelas->murid ?? [];

            if (!is_array($existing)) {
                $existing = json_decode($existing, true);
            }

            $indexed = [];
            foreach ($existing as $item) {
                $indexed[$item['id']] = $item;
            }

            foreach ($dataPendaftar as $item) {
                $indexed[$item['id']] = $item;
            }

            $dataGabungArray = array_values($indexed);
            $dataGabungObject = json_decode(json_encode($dataGabungArray));

            $datamurid_kelas->update([
                'murid' => $dataGabungObject,
            ]);

            // ================= Pembuatan Invoice ================= //
            invoice::create([
                'profile_id' => $profile->id,
                'kelas_id' => $kelas->id,
            ]);

            if ($pendaftaran_siswa->kategori == 'Reguler') {
                // ================= Riwayat Pembayaran ================= //
                riwayatPembayaran::create([
                    'nama' => $profile->id,
                    'kelas_id' => $kelas->id,
                    'nominal' => 150000,
                    'tanggal' => now(),
                    'jenis_pembayaran' => 'Biaya Pendaftaran',
                    'metode_pembayaran' => 'Transfer',
                ]);

                $saldo_terakhir = keuangan::orderBy('id', 'desc')->first();
                $saldo = 150000 + $saldo_terakhir->saldo_akhir;
                // ================= Riwayat Keuangan ================= //
                keuangan::create([
                    'indexkeuangan_id' => null,
                    'tipe' => "Pemasukan",
                    'keterangan' => "Biaya Pendaftaran " . $profile->nama,
                    'tanggal' => now(),
                    'nominal' => 150000,
                    'saldo_akhir' => $saldo,
                    'metode_pembayaran' => "Transfer",
                ]);
            }

            // ================= Update Pendaftaran ================= //
            pendaftaran::where('id', $request->id)->update([
                'status' => 'verifikasi',
            ]);

            // ================= Menghapus Pendaftaran ================= //
            // pendaftaran::where('id', $request->id)->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function masuk_kelasAcc(Request $request, $id)
    {
        $data_siswa = akun::with('pengguna')->where('id', $request->id)->first();
        $sekolah = sekolah::where('id', $data_siswa->pengguna->sekolah_id)->first();
        $kelas = kelas::where('id', $id)->first();

        $dataPendaftar = [
            [
                "id" => $data_siswa->id,
                "nama" => $data_siswa->pengguna->nama,
                "nilai" => null,
                "sekolah" => $sekolah->nama_sekolah,
                "kelas" => $request->kelas_pendaftar,
                "tagihan" => $kelas->harga,
                "no_sertiv" => null,
                "created_at" => Carbon::now(),
                "no_invoice" => 'INV-' . date('mY') . '-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT),
                "pembayaran" => 0,
                "updated_at" => Carbon::now(),
                "jatuh_tempo" => $kelas->jatuh_tempo,
                "status_sertiv" => "Belum Terbit",
            ],
        ];

        // Perbarui data siswa
        pengguna::where('id', $data_siswa->pengguna->id)->update([
            'kelas' => $request->kelas_pendaftar,
        ]);

        // ================= Masukkan siswa ke kelas ================= //
        $datamurid_kelas = muridKelas::where('kelas_id', $id)->first();

        if ($datamurid_kelas == null) {
            $datamurid_kelas = muridKelas::create([
                'murid' => json_encode([]),
                'kelas_id' => $id,
            ]);
        }

        $existing = $datamurid_kelas->murid ?? [];

        if (!is_array($existing)) {
            $existing = json_decode($existing, true);
        }

        $indexed = [];
        foreach ($existing as $item) {
            $indexed[$item['id']] = $item;
        }

        foreach ($dataPendaftar as $item) {
            $indexed[$item['id']] = $item;
        }

        $dataGabungArray = array_values($indexed);
        $dataGabungObject = json_decode(json_encode($dataGabungArray));

        $datamurid_kelas->update([
            'murid' => $dataGabungObject,
        ]);

        // ================= Pembuatan Invoice ================= //
        invoice::create([
            'profile_id' => $data_siswa->id,
            'kelas_id' => $id,
        ]);

        // ================= Menghapus Pendaftaran ================= //
        pendaftaran::where('id', $request->idPendaftaran)->delete();

        return response()->json([
            'message' => "Berhasil Menambahkan siswa di kelas",
        ]);
    }
}

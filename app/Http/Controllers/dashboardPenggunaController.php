<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\Indexkeuangan;
use App\Models\kelas;
use App\Models\keuangan;
use App\Models\pembelajaran;
use App\Models\pengguna;
use App\Models\riwayatPembayaran;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class dashboardPenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_Admin()
    {
        $total_siswa = akun::where('role', 'siswa')->count();
        $total_pengajar = akun::where('role', 'pengajar')->count();
        $total_kelas = kelas::count();
        $pembayaran_terbaru = riwayatPembayaran::with('kelas', 'pengguna')->orderBy('tanggal', 'desc')->limit(10)->get();
        $indexKeuangan = Indexkeuangan::where('status', 'selesai')->orderBy('created_at', 'desc')->get();

        $indexKeuangan_count = Indexkeuangan::count();
        $total_saldo = keuangan::orderBy('id', 'desc')->first();

        // dd($indexKeuangan->toArray());
        $total = [
            'siswa' => $total_siswa,
            'pengajar' => $total_pengajar,
            'kelas' => $total_kelas
        ];

        $absenTerbaru = pembelajaran::whereNotNull('pembelajaran.tanggal')
            ->join('kelas', 'pembelajaran.kelas_id', 'kelas.id')
            ->join('profile', 'pembelajaran.pengajar', 'profile.id')
            ->select('pembelajaran.*', 'kelas.nama_kelas', 'profile.nama')
            ->orderBy('tanggal', 'desc')
            ->limit(25)
            ->get();


        return view('pages.dashboard.dashboard_admin', compact('total', 'absenTerbaru', 'pembayaran_terbaru', 'indexKeuangan', 'indexKeuangan_count', 'total_saldo'));
    }

    public function pembayaran_terbaru(Request $request)
    {
        $data = riwayatPembayaran::with('kelas', 'pengguna')->orderBy('tanggal', 'desc')->get();
        if ($request->ajax()) {
            return response()->json(['data' => $data]);
        }
        return view('pages.keuangan.pembayaran_terbaru');
    }

    public function sedang_berlangsung(Request $request)
    {
        $data = keuangan::where('indexkeuangan_id', null)->get();
        if ($request->ajax()) {
            return response()->json(['data' => $data]);
        }
        return view('pages.keuangan.periode_sedangberlangsung');
    }

    public function riwayat_periode(Request $request, $id)
    {
        $data = keuangan::where('indexkeuangan_id', $id)->get();
        $indexKeuangan = Indexkeuangan::findOrfail($id);
        // dd($data->toArray());
        if ($request->ajax()) {
            return response()->json(['data' => $data]);
        }
        return view('pages.keuangan.riwayat_periode', compact('id', 'indexKeuangan'));
    }

    public function tambah_pembayaran(Request $request)
    {
        $validated = $request->validate([
            'keterangan' => 'required',
            'metode_pembayaran' => 'required',
            'tanggal' => 'required',
            'nominal' => 'required',
            'tipe' => 'required',
        ]);

        $transaksi_terakhir = keuangan::latest('id')->first();
        if ($transaksi_terakhir) {
            $saldo = $transaksi_terakhir->saldo_akhir;
        } else {
            $saldo = 0;
        }

        if ($validated['tipe'] == 'Pemasukan') {
            $saldo += $validated['nominal'];
        } else {
            $saldo -= $validated['nominal'];
        }

        keuangan::create([
            'keterangan' => $validated['keterangan'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'tanggal' => $validated['tanggal'],
            'nominal' => $validated['nominal'],
            'tipe' => $validated['tipe'],
            'saldo_akhir' => $saldo,
        ]);

        // return response()->json(['data' => $saldo]);
        return redirect()->back()->with('success', 'Pembayaran berhasil ditambahkan!');
    }

    public function selesai_periode(Request $request)
    {
        // Cari periode yang sedang berlangsung
        $data = keuangan::where('indexkeuangan_id', null)->get();

        // Hitung jumlah pemasukan dan pengeluaran
        $pemasukan = keuangan::whereNull('indexkeuangan_id')->where('tipe', 'Pemasukan')->get();

        $jumlahPemasukan = 0;
        foreach ($pemasukan as $value) {
            $jumlahPemasukan += $value->nominal;
        }

        $pengeluaran = keuangan::whereNull('indexkeuangan_id')->where('tipe', 'Pengeluaran')->get();
        $jumlahPengeluaran = 0;
        foreach ($pengeluaran as $value) {
            $jumlahPengeluaran += $value->nominal;
        }

        // Cari periode yang sedang berlangsung
        $indexKeuangan_aktif = Indexkeuangan::where('status', 'aktif')->first();

        // Jika tidak ada periode yang sedang berlangsung, buat periode baru
        if (!$indexKeuangan_aktif) {
            $indexKeuangan_aktif = Indexkeuangan::create([
                'kesimpulan' => "Pemasukan",
                'status' => 'aktif',
            ]);
        }

        // Update data keuangan dengan indexkeuangan_id sesuai dengan periode yang sedang berlangsung
        foreach ($data as $item) {
            keuangan::where('id', $item->id)->update([
                'indexkeuangan_id' => $indexKeuangan_aktif->id,
            ]);
        }

        // Update status periode yang sedang berlangsung
        if ($jumlahPemasukan > $jumlahPengeluaran) {
            $kesimpulan = "Pemasukan";
        } elseif ($jumlahPemasukan < $jumlahPengeluaran) {
            $kesimpulan = "Pengeluaran";
        } else {
            $kesimpulan = "Pengeluaran";
        }

        // Update status periode yang sedang berlangsung
        Indexkeuangan::where('id', $indexKeuangan_aktif->id)->update([
            'status' => 'selesai',
            'kesimpulan' => $kesimpulan,
        ]);


        Indexkeuangan::create([
            'kesimpulan' => 'Pemasukan',
            'status' => 'aktif',
        ]);

        return redirect()->back()->with('success', 'Periode berhasil diselesaikan!');
    }

    public function index_Pengajar()
    {
        return view('pages.dashboard.dashboard_pengajar');
    }

    public function index_Siswa()
    {
        return view('pages.dashboard.dashboard_siswa');
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
        //
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
        $data = pengguna::where('profile.id', $id)
            ->join('akun', 'profile.id', 'akun.id')
            ->select('profile.*', 'akun.role')
            ->first();
        return view('pages.pengguna.edit_profile', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $message = [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 255 karakter.',

            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',

            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.min' => 'Nomor telepon minimal 14 karakter.',
            'no_telp.max' => 'Nomor telepon maksimal 15 karakter.',
            'no_telp.regex' => 'Nomor telepon harus diawali dengan +62',

            'password.min' => 'Password minimal 6 karakter.',
        ];

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|max:255',
            'no_telp' => 'required|min:14|max:15|regex:/^\+62[0-9]+$/',
            'password' => 'nullable|min:6',
        ], $message);

        try {
            $user = pengguna::where('id', $id)->first();
            $akun = akun::where('id', $id)->first();

            $user->nama = $request->nama;
            $user->alamat = $request->alamat;
            $user->no_telp = $request->no_telp;

            if ($request->filled('password')) {
                $akun->password = Hash::make($request->password);
            }

            $user->save();
            $akun->save();

            return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', 'Gagal Memperbarui data profile!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\gajiCustom;
use App\Models\gajiTransport;
use App\Models\gajiUtama;
use App\Models\historigaji;
use App\Models\history_gaji;
use App\Models\kategori_pekerjaan;
use Illuminate\Http\Request;

class gajiPengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $gaji = gajiUtama::with(['pengguna.akun', 'pembelajaran.kelas'])
            ->where('gajis.pengajar', $id)
            ->where(function ($q) {
                $q->where('gajis.status', 'pending')
                    ->orwhere('gajis.status', 'diverifikasi');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $transport = gajiTransport::with(['pengguna.akun', 'pembelajaran.kelas'])
            ->where('transport.pengajar', $id)
            ->where(function ($q) {
                $q->where('transport.status', 'pending')
                    ->orwhere('transport.status', 'diverifikasi');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $custom = gajiCustom::with('pengguna.akun')
            ->where('gaji_custom.pengajar', $id)
            ->where(function ($q) {
                $q->where('gaji_custom.status', 'pending')
                    ->orWhere('gaji_custom.status', 'diverifikasi');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $total_gaji = gajiUtama::where('pengajar', $id)
            ->where(function ($q) {
                $q->where('status', 'pending')
                    ->orWhere('status', 'diverifikasi');
            })
            ->sum('nominal');

        $total_gajitransport = gajiTransport::where('pengajar', $id)
            ->where(function ($q) {
                $q->where('status', 'pending')
                    ->orWhere('status', 'diverifikasi');
            })
            ->sum('nominal');

        $total_gajicustom = gajiCustom::where('pengajar', $id)
            ->where(function ($q) {
                $q->where('status', 'pending')
                    ->orWhere('status', 'diverifikasi');
            })
            ->sum('nominal');

        $gaji_pengajar = [
            'gaji_mengajar' => $total_gaji,
            'gaji_transport' => $total_gajitransport,
            'gaji_custom' => $total_gajicustom,
            'total' => $total_gaji + $total_gajitransport + $total_gajicustom
        ];

        return view('pages.gaji.pengajar.gaji', compact('gaji', 'transport', 'custom', 'gaji_pengajar'));
    }

    public function riwayat_gaji(string $id)
    {
        $data = historigaji::all();

        return view('pages.gaji.pengajar.riwayat_gaji', compact('data'));
    }

    public function detail_histori($id, $idtanggal)
    {
        $gaji = gajiUtama::where('gajis.pengajar', $id)
            ->where(function ($q) {
                $q->where('gajis.status', 'dibayar')
                    ->orWhere('gajis.status', 'ditolak');
            })
            ->where('gajis.history_gaji_id', $idtanggal)
            ->join('akun', 'akun.id', '=', 'gajis.pengajar')
            ->join('profile', 'profile.id', '=', 'akun.id')
            ->join('pembelajaran', 'pembelajaran.id', '=', 'gajis.pembelajaran_id')
            ->join('kelas', 'kelas.id', '=', 'pembelajaran.kelas_id')
            ->select('gajis.*', 'profile.nama', 'kelas.nama_kelas', 'pembelajaran.tanggal')
            ->get();

        $transport = gajiTransport::where('transport.pengajar', $id)
            ->where(function ($q) {
                $q->where('transport.status', 'dibayar')
                    ->orWhere('transport.status', 'ditolak');
            })
            ->where('transport.history_gaji_id', $idtanggal)
            ->join('akun', 'akun.id', '=', 'transport.pengajar')
            ->join('profile', 'profile.id', '=', 'akun.id')
            ->join('pembelajaran', 'pembelajaran.id', '=', 'transport.pembelajaran_id')
            ->join('kelas', 'kelas.id', '=', 'pembelajaran.kelas_id')
            ->select('transport.*', 'profile.nama', 'kelas.nama_kelas', 'pembelajaran.tanggal')
            ->get();

        $custom = gajiCustom::where('gaji_custom.pengajar', $id)
            ->where(function ($q) {
                $q->where('gaji_custom.status', 'dibayar')
                    ->orWhere('gaji_custom.status', 'ditolak');
            })
            ->where('gaji_custom.history_gaji_id', $idtanggal)
            ->join('akun', 'akun.id', '=', 'gaji_custom.pengajar')
            ->join('profile', 'profile.id', '=', 'akun.id')
            ->get();


        $total_gaji = gajiUtama::where('pengajar', $id)
            ->where('status', 'dibayar')
            ->where('gajis.history_gaji_id', $idtanggal)
            ->sum('nominal');

        $total_gajitransport = gajiTransport::where('pengajar', $id)
            ->where('status', 'dibayar')
            ->where('transport.history_gaji_id', $idtanggal)
            ->sum('nominal');

        $total_gajicustom = gajiCustom::where('pengajar', $id)
            ->where('status', 'dibayar')
            ->where('gaji_custom.history_gaji_id', $idtanggal)
            ->sum('nominal');

        $gaji_pengajar = [
            'gaji_mengajar' => $total_gaji,
            'gaji_transport' => $total_gajitransport,
            'gaji_custom' => $total_gajicustom,
            'total' => $total_gaji + $total_gajitransport + $total_gajicustom
        ];


        // ========================= Gaji Ditolak =========================//
        $gaji_ditolak = gajiUtama::where('gajis.pengajar', $id)
            ->where('gajis.status', 'ditolak')
            ->where('gajis.history_gaji_id', $idtanggal)
            ->join('akun', 'akun.id', 'gajis.pengajar')
            ->join('profile', 'profile.id', 'akun.id')
            ->join('pembelajaran', 'pembelajaran.id', 'gajis.pembelajaran_id')
            ->join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->select('gajis.*', 'profile.nama', 'kelas.nama_kelas', 'pembelajaran.tanggal')
            ->get();

        $transport_ditolak = gajiTransport::where('transport.pengajar', $id)
            ->where('transport.status', 'ditolak')
            ->where('transport.history_gaji_id', $idtanggal)
            ->join('akun', 'akun.id', 'transport.pengajar')
            ->join('profile', 'profile.id', 'akun.id')
            ->join('pembelajaran', 'pembelajaran.id', 'transport.pembelajaran_id')
            ->join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->select('transport.*', 'profile.nama', 'kelas.nama_kelas', 'pembelajaran.tanggal')
            ->get();

        $custom_ditolak = gajiCustom::where('gaji_custom.pengajar', $id)
            ->where('gaji_custom.status', 'ditolak')
            ->where('gaji_custom.history_gaji_id', $idtanggal)
            ->join('akun', 'akun.id', 'gaji_custom.pengajar')
            ->join('profile', 'profile.id', 'akun.id')
            ->get();

        $total_gaji_ditolak = gajiUtama::where('pengajar', $id)
            ->where('status', 'ditolak')
            ->where('gajis.history_gaji_id', $idtanggal)
            ->sum('nominal');

        $total_gajitransport_ditolak = gajiTransport::where('pengajar', $id)
            ->where('status', 'ditolak')
            ->where('transport.history_gaji_id', $idtanggal)
            ->sum('nominal');

        $total_gajicustom_ditolak = gajiCustom::where('pengajar', $id)
            ->where('status', 'ditolak')
            ->where('gaji_custom.history_gaji_id', $idtanggal)
            ->sum('nominal');

        $gaji_pengajar_ditolak = [
            'gaji_mengajar_ditolak' => $total_gaji_ditolak,
            'gaji_transport_ditolak' => $total_gajitransport_ditolak,
            'gaji_custom_ditolak' => $total_gajicustom_ditolak,
            'total_ditolak' => $total_gaji_ditolak + $total_gajitransport_ditolak + $total_gajicustom_ditolak
        ];

        return view('pages.gaji.pengajar.detail_histori', compact('gaji_pengajar', 'gaji_ditolak', 'gaji_pengajar_ditolak', 'transport_ditolak', 'custom_ditolak', 'gaji', 'transport', 'custom'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function gaji_custom()
    {
        $data = kategori_pekerjaan::all();
        return view('pages.gaji.pengajar.form_gajicustom', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = [
            'pekerjaan' => 'Pekerjaan Harus Di isi',
            'pengajar.required'   => 'Pengajar harus diisi.',
            'tanggal.required'    => 'Tanggal harus diisi.',
            'keterangan.required' => 'Keterangan wajib diisi.',
            'nominal.required'    => 'Nominal harus diisi.',
            'status.required'     => 'Status harus diisi.',
        ];

        $request->validate([
            'pekerjaan' => 'required',
            'idpengajar'   => 'required',
            'tanggal'    => 'required',
            'keterangan' => 'required',
            'status'     => 'required'
        ], $message);

        $pekerjaan = kategori_pekerjaan::findOrfail($request->pekerjaan);
        try {
            gajiCustom::create([
                'pengajar' => $request->idpengajar,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan . ' | ' . $pekerjaan->nama_pekerjaan,
                'nominal' => $pekerjaan->gaji,
                'status' => $request->status,
                'history_gaji_id' => null
            ]);

            return redirect()->route('gaji.pengajar', ['id' => $request->idpengajar])
                ->with('success', 'Gaji berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan. Gaji tidak dapat ditambahkan.');
        }
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
        //
    }
}

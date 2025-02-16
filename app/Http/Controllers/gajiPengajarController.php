<?php

namespace App\Http\Controllers;

use App\Models\gajiCustom;
use App\Models\gajiTransport;
use App\Models\gajiUtama;
use App\Models\historigaji;
use Illuminate\Http\Request;

class gajiPengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $gaji = gajiUtama::where('gajis.pengajar', $id)
            ->where('gajis.status', 'pending')
            ->orwhere('gajis.status', 'diverifikasi')
            ->join('akun', 'akun.id', 'gajis.pengajar')
            ->join('profile', 'profile.id', 'akun.id')
            ->join('pembelajaran', 'pembelajaran.id', 'gajis.pembelajaran_id')
            ->join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->select('gajis.*', 'profile.nama', 'pembelajaran.pertemuan', 'kelas.nama_kelas', 'pembelajaran.tanggal')
            ->get();

        $transport = gajiTransport::where('transport.pengajar', $id)
            ->where('transport.status', 'pending')
            ->orwhere('transport.status', 'diverifikasi')
            ->join('akun', 'akun.id', 'transport.pengajar')
            ->join('profile', 'profile.id', 'akun.id')
            ->join('pembelajaran', 'pembelajaran.id', 'transport.pembelajaran_id')
            ->join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->select('transport.*', 'profile.nama', 'pembelajaran.pertemuan', 'kelas.nama_kelas', 'pembelajaran.tanggal')
            ->get();

        $custom = gajiCustom::where('gaji_custom.pengajar', $id)
            ->where('gaji_custom.status', 'pending')
            ->orWhere('gaji_custom.status', 'diverifikasi')
            ->join('akun', 'akun.id', 'gaji_custom.pengajar')
            ->join('profile', 'profile.id', 'akun.id')
            ->get();

        $total_gaji = gajiUtama::where('pengajar', $id)
            ->where('status', 'pending')
            ->orWhere('status', 'diverifikasi')
            ->sum('nominal');

        $total_gajitransport = gajiTransport::where('pengajar', $id)
            ->where('status', 'pending')
            ->orwhere('status', 'diverifikasi')
            ->sum('nominal');

        $total_gajicustom = gajiCustom::where('pengajar', $id)
            ->where('status', 'pending')
            ->Orwhere('status', 'diverifikasi')
            ->sum('nominal');

        $gaji_pengajar = [
            'gaji_mengajar' => $total_gaji,
            'gaji_transport' => $total_gajitransport,
            'gaji_custom' => $total_gajicustom,
            'total' => $total_gaji + $total_gajitransport + $total_gajicustom
        ];
        // dd($gaji);
        return view('pages.gaji.pengajar.gaji', compact('gaji', 'transport', 'custom', 'gaji_pengajar'));
    }

    public function riwayat_gaji(string $id)
    {
        $data = gajiUtama::where('gajis.pengajar', $id)
            ->where('gajis.status', 'dibayar')
            ->join('history_gaji', 'history_gaji.id', 'gajis.history_gaji_id')
            ->select('history_gaji.id', 'history_gaji.tanggal_terbayar')
            ->distinct()
            ->get();

        // dd($data);
        return view('pages.gaji.pengajar.riwayat_gaji', compact('data'));
    }

    public function detail_histori($id, $idtanggal)
    {
        $gaji = gajiUtama::where('gajis.pengajar', $id)
            ->where('gajis.status', 'dibayar')
            ->where('gajis.history_gaji_id', $idtanggal)
            ->join('akun', 'akun.id', 'gajis.pengajar')
            ->join('profile', 'profile.id', 'akun.id')
            ->join('pembelajaran', 'pembelajaran.id', 'gajis.pembelajaran_id')
            ->join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->select('gajis.*', 'profile.nama', 'pembelajaran.pertemuan', 'kelas.nama_kelas', 'pembelajaran.tanggal')
            ->get();

        $transport = gajiTransport::where('transport.pengajar', $id)
            ->where('transport.status', 'dibayar')
            ->where('transport.history_gaji_id', $idtanggal)
            ->join('akun', 'akun.id', 'transport.pengajar')
            ->join('profile', 'profile.id', 'akun.id')
            ->join('pembelajaran', 'pembelajaran.id', 'transport.pembelajaran_id')
            ->join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->select('transport.*', 'profile.nama', 'pembelajaran.pertemuan', 'kelas.nama_kelas', 'pembelajaran.tanggal')
            ->get();

        $custom = gajiCustom::where('gaji_custom.pengajar', $id)
            ->where('gaji_custom.status', 'dibayar')
            ->where('gaji_custom.history_gaji_id', $idtanggal)
            ->join('akun', 'akun.id', 'gaji_custom.pengajar')
            ->join('profile', 'profile.id', 'akun.id')
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
            ->select('gajis.*', 'profile.nama', 'pembelajaran.pertemuan', 'kelas.nama_kelas', 'pembelajaran.tanggal')
            ->get();

        $transport_ditolak = gajiTransport::where('transport.pengajar', $id)
            ->where('transport.status', 'ditolak')
            ->where('transport.history_gaji_id', $idtanggal)
            ->join('akun', 'akun.id', 'transport.pengajar')
            ->join('profile', 'profile.id', 'akun.id')
            ->join('pembelajaran', 'pembelajaran.id', 'transport.pembelajaran_id')
            ->join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->select('transport.*', 'profile.nama', 'pembelajaran.pertemuan', 'kelas.nama_kelas', 'pembelajaran.tanggal')
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

        // dd($gaji_ditolak);
        return view('pages.gaji.pengajar.detail_histori', compact('gaji', 'transport', 'custom', 'gaji_pengajar', 'gaji_ditolak', 'transport_ditolak','custom_ditolak', 'gaji_pengajar_ditolak'));
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

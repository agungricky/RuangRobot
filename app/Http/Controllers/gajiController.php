<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\gajiCustom;
use App\Models\gajiTransport;
use App\Models\gajiUtama;
use App\Models\historigaji;
use App\Models\keuangan;
use App\Models\pengguna;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;

class gajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = akun::where('role', 'Pengajar')
            ->join('profile', 'profile.id', 'akun.id')
            ->get();

        foreach ($data as $value) {
            $gaji = gajiUtama::where('pengajar', $value->id)
                ->where('gajis.status', 'pending')
                ->sum('nominal');

            $gaji_transport = gajiTransport::where('pengajar', $value->id)
                ->where('transport.status', 'pending')
                ->sum('nominal');

            $gaji_custom = gajiCustom::where('pengajar', $value->id)
                ->where('gaji_custom.status', 'pending')
                ->sum('nominal');

            $gaji_pengajar[] = [
                'id' => $value->id,
                'nama' => $value->nama,
                'gaji_mengajar' => $gaji,
                'gaji_transport' => $gaji_transport,
                'gaji_custom' => $gaji_custom,
                'total' => $gaji + $gaji_transport + $gaji_custom
            ];
        }

        if ($request->ajax()) {
            return response()->json([
                'data' => $data,
                'total_gaji' => $gaji_pengajar,
            ]);
        }

        return view('pages.gaji.gaji', compact('data'));
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
        $data = pengguna::where('id', $id)->first();
        $gaji = gajiUtama::with('pengguna', 'pembelajaran.kelas')
            ->where('gajis.pengajar', $id)
            ->where('gajis.status', '!=', 'dibayar')
            ->where('history_gaji_id', null)
            ->get();

        $transport = gajiTransport::with('pengguna', 'pembelajaran.kelas')
            ->where('transport.pengajar', $id)
            ->where('transport.status', '!=', 'dibayar')
            ->where('history_gaji_id', null)
            ->get();

        $custom = gajiCustom::with('pengguna')
            ->where('gaji_custom.pengajar', $id)
            ->where('gaji_custom.status', '!=', 'dibayar')
            ->where('history_gaji_id', null)
            ->get();

        // dd($custom->toArray());

        // ================================================== //
        // ================== Gaji Diterima ================= //
        // ================================================== //
        $total_gaji = gajiUtama::where('pengajar', $data->id)
            ->where('gajis.status', 'diverifikasi')
            ->sum('nominal');

        $total_gajitransport = gajiTransport::where('pengajar', $data->id)
            ->where('transport.status', 'diverifikasi')
            ->sum('nominal');

        $total_gajicustom = gajiCustom::where('pengajar', $data->id)
            ->where('gaji_custom.status', 'diverifikasi')
            ->sum('nominal');

        $gaji_pengajar = [
            'gaji_mengajar' => $total_gaji,
            'gaji_transport' => $total_gajitransport,
            'gaji_custom' => $total_gajicustom,
            'total' => $total_gaji + $total_gajitransport + $total_gajicustom
        ];

        // ================================================== //
        // ================== Gaji Ditolak ================= //
        // ================================================== //
        $gaji_ditolak = gajiUtama::where('pengajar', $data->id)
            ->where('gajis.status', 'ditolak')
            ->where('history_gaji_id', null)
            ->sum('nominal');

        $transport_ditolak = gajiTransport::where('pengajar', $data->id)
            ->where('transport.status', 'ditolak')
            ->where('history_gaji_id', null)
            ->sum('nominal');

        $custom_ditolak = gajiCustom::where('pengajar', $data->id)
            ->where('gaji_custom.status', 'ditolak')
            ->where('history_gaji_id', null)
            ->sum('nominal');

        $gaji_ditolak = [
            'gaji_mengajar' => $gaji_ditolak,
            'gaji_transport' => $transport_ditolak,
            'gaji_custom' => $custom_ditolak,
            'total' => $gaji_ditolak + $transport_ditolak + $custom_ditolak
        ];
        return view('pages.gaji.detail_gaji', compact('data', 'gaji', 'transport', 'custom', 'gaji_pengajar', 'gaji_ditolak'));
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
    public function gaji_utama(Request $request, string $id)
    {
        gajiUtama::where('id', $id)->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Data berhasil diverifikasi');
    }

    public function gaji_transport(Request $request, string $id)
    {
        gajiTransport::where('id', $id)->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Data berhasil diverifikasi');
    }

    public function gaji_custom(Request $request, string $id)
    {
        gajiCustom::where('id', $id)->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Data berhasil diverifikasi');
    }

    public function gaji_terbayar(Request $request, string $id)
    {
        $gaji = gajiUtama::where('pengajar', $id)
            ->where('status', 'diverifikasi')
            ->get()->toArray();

        $transport = gajiTransport::where('pengajar', $id)
            ->where('status', 'diverifikasi')
            ->get()->toArray();

        $custom = gajiCustom::where('pengajar', $id)
            ->where('status', 'diverifikasi')
            ->get()->toArray();

        $gaji_total = 0;
        foreach ($gaji as $value) {
            $gaji_total += $value['nominal'];
        }

        $transport_total = 0;
        foreach ($transport as $value) {
            $transport_total += $value['nominal'];
        }

        $custom_total = 0;
        foreach ($custom as $value) {
            $custom_total += $value['nominal'];
        }

        $totalAll = $gaji_total + $transport_total + $custom_total;
        $pengajar = pengguna::findOrfail($id);
        $saldoAkhir = keuangan::orderBy('id', 'desc')->first();

        keuangan::create([
            'indexkeuangan_id' => null,
            'tipe' => 'Pengeluaran',
            'keterangan' => 'Pembayaran Gaji ' . $pengajar->nama,
            'tanggal' => now(),
            'nominal' => $totalAll,
            'saldo_akhir' => $saldoAkhir->saldo_akhir - $totalAll,
            'metode_pembayaran' => "Transfer"
        ]);

        // =============================== Tunggu Sampai Sini ===============================


        // Menampilkan Semua Data
        $gaji = gajiUtama::where('pengajar', $id)
            ->where('history_gaji_id', null)
            ->get()->toArray();

        $transport = gajiTransport::where('pengajar', $id)
            ->where('history_gaji_id', null)
            ->get()->toArray();

        $custom = gajiCustom::where('pengajar', $id)
            ->where('history_gaji_id', null)
            ->get()->toArray();

        $histori = historigaji::whereDate('tanggal_terbayar', now()->toDateString())->first();

        if (!$histori) {
            $histori = historigaji::create([
                'tanggal_terbayar' => now(),
            ]);
        }

        foreach ($gaji as $key => $value) {
            gajiUtama::where('id', $value['id'])->update([
                'status' => $value['status'] == 'diverifikasi' ? $request->status : $value['status'],
                'history_gaji_id' => $histori->id
            ]);
        }

        foreach ($transport as $key => $value) {
            gajiTransport::where('id', $value['id'])->update([
                'status' => $value['status'] == 'diverifikasi' ? $request->status : $value['status'],
                'history_gaji_id' => $histori->id
            ]);
        }

        foreach ($custom as $key => $value) {
            gajiCustom::where('id', $value['id'])->update([
                'status' => $value['status'] == 'diverifikasi' ? $request->status : $value['status'],
                'history_gaji_id' => $histori->id
            ]);
        }

        return back()->with('success', 'Data berhasil di perbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function verif_all($id)
    {
        $gaji = gajiUtama::where('status', 'pending')
            ->where('pengajar', $id)
            ->get();
        $transport = gajiTransport::where('status', 'pending')
            ->where('pengajar', $id)
            ->get();
        $custom = gajiCustom::where('status', 'pending')
            ->where('pengajar', $id)
            ->get();

        foreach ($gaji as $item) {
            $item->update(['status' => 'diverifikasi']);
        }

        foreach ($transport as $item) {
            $item->update(['status' => 'diverifikasi']);
        }

        foreach ($custom as $item) {
            $item->update(['status' => 'diverifikasi']);
        }

        return redirect()->back()->with('success', 'Semua data telah diverifikasi.');
    }


    public function historigaji(Request $request)
    {
        $data = historigaji::join('gajis', 'gajis.history_gaji_id', 'history_gaji.id')
            ->join('profile', 'profile.id', 'gajis.pengajar')
            ->select('profile.nama', 'history_gaji.tanggal_terbayar', 'gajis.pengajar', 'history_gaji.id')
            ->distinct()
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.gaji.histori_gaji');
    }

    public function detailhistori(String $pengajar_id, $tanggal_id)
    {
        $gaji = gajiUtama::with('history_gaji', 'pengguna', 'pembelajaran.kelas')
            ->where('pengajar', $pengajar_id)
            ->where('history_gaji_id', $tanggal_id)
            ->get();

        $transport = gajiTransport::with('history_gaji', 'pengguna', 'pembelajaran.kelas')
            ->where('pengajar', $pengajar_id)
            ->where('history_gaji_id', $tanggal_id)
            ->get();

        $custom = gajiCustom::with('history_gaji', 'pengguna')
            ->where('pengajar', $pengajar_id)
            ->get();

        // ================================================== //
        // ================== Gaji Diterima ================= //
        // ================================================== //
        $total_gaji = gajiUtama::with('history_gaji')
            ->where('pengajar', $pengajar_id)
            ->where('gajis.history_gaji_id', $tanggal_id)
            ->where('gajis.status', 'dibayar')
            ->sum('nominal');

        $total_gajitransport = gajiTransport::with('history_gaji')
            ->where('pengajar',  $pengajar_id)
            ->where('transport.history_gaji_id', $tanggal_id)
            ->where('transport.status', 'dibayar')
            ->sum('nominal');

        $total_gajicustom = gajiCustom::with('history_gaji')
            ->where('pengajar', $pengajar_id)
            ->where('gaji_custom.history_gaji_id', $tanggal_id)
            ->where('gaji_custom.status', 'dibayar')
            ->sum('nominal');

        $gaji_pengajar = [
            'gaji_mengajar' => $total_gaji,
            'gaji_transport' => $total_gajitransport,
            'gaji_custom' => $total_gajicustom,
            'total' => $total_gaji + $total_gajitransport + $total_gajicustom
        ];

        // ================================================== //
        // ================== Gaji Ditolak ================= //
        // ================================================== //
        $total_gaji_ditolak = gajiUtama::with('history_gaji')
            ->where('pengajar', $pengajar_id)
            ->where('gajis.history_gaji_id', $tanggal_id)
            ->where('gajis.status', 'ditolak')
            ->orWhere('gajis.status', 'pending')
            ->sum('nominal');

        $total_gajitransport_ditolak = gajiTransport::where('pengajar',  $pengajar_id)
            ->where('transport.history_gaji_id', $tanggal_id)
            ->where('transport.status', 'ditolak')
            ->orWhere('transport.status', 'pending')
            ->join('history_gaji', 'history_gaji.id', 'transport.history_gaji_id')
            ->sum('nominal');

        $total_gajicustom_ditolak = gajiCustom::where('pengajar', $pengajar_id)
            ->where('gaji_custom.history_gaji_id', $tanggal_id)
            ->where('gaji_custom.status', 'ditolak')
            ->orWhere('gaji_custom.status', 'pending')
            ->join('history_gaji', 'history_gaji.id', 'gaji_custom.history_gaji_id')
            ->sum('nominal');

        $gaji_ditolak = [
            'gaji_mengajar_ditolak' => $total_gaji_ditolak,
            'gaji_transport_ditolak' => $total_gajitransport_ditolak,
            'gaji_custom_ditolak' => $total_gajicustom_ditolak,
            'total' => $total_gaji_ditolak + $total_gajitransport_ditolak + $total_gajicustom_ditolak
        ];

        return view('pages.gaji.detail_histori', compact('gaji', 'transport', 'custom', 'gaji_pengajar', 'gaji_ditolak'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\riwayatPembayaran;
use Illuminate\Http\Request;

class RiwayatPembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id, $kelas_id)
    {
        $data = riwayatPembayaran::with('pengguna', 'kelas')->where('riwayat_pembayarans.kelas_id', $kelas_id)->where('riwayat_pembayarans.nama', $id)->get();
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(riwayatPembayaran $riwayatPembayaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(riwayatPembayaran $riwayatPembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, riwayatPembayaran $riwayatPembayaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(riwayatPembayaran $riwayatPembayaran)
    {
        //
    }
}

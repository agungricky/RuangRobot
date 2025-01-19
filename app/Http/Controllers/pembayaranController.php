<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kelas;

class pembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $data = kelas::join('murid_kelas', 'murid_kelas.kelas_id', '=', 'kelas.id')
    ->join('pembayaran_kelas', 'pembayaran_kelas.kelas_id', '=', 'kelas.id')
    ->select('kelas.nama_kelas', 'murid_kelas.nama_siswa', 'pembayaran_kelas.terbayar','pembayaran_kelas.status')
    ->get();

    // dd($data);
    if ($request->ajax()) {
        return response()->json([
            'data' => $data
        ]);
    }

        return view('pages.pembayaran.pembayaran',compact('data'));
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

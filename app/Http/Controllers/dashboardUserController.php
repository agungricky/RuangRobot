<?php

namespace App\Http\Controllers;

use App\Models\pengguna;
use Illuminate\Http\Request;

class dashboardUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = pengguna::all();
        // dd($kelas);
        $mekanik = $elektronik = $pemrograman = 0;
        foreach ($kelas as $poin) {
            $mekanik      += $poin->mekanik;
            $pemrograman  += $poin->pemrograman;
            $elektronik  += $poin->elektronik;
        }
        $max = max($mekanik, $elektronik, $pemrograman);

        return view('pages.dashboard.dashboard_pengajar', compact('mekanik', 'elektronik', 'pemrograman', 'max', 'kelas'));
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

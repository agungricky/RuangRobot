<?php

namespace App\Http\Controllers;

use App\Models\pendaftaran;
use Illuminate\Http\Request;

class pendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'nama' => 'required|string|max:100',
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

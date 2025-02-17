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
        $data = pengguna::where('id', $id)->first();
        return view('pages.pengguna.edit_profile', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1️⃣ Validasi data terlebih dahulu
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'password' => 'nullable|min:6' // Password opsional, minimal 6 karakter
        ]);

        // 2️⃣ Cari data pengguna berdasarkan ID
        $pengguna = pengguna::findOrFail($id);

        // 3️⃣ Update data (kecuali password jika kosong)
        $dataUpdate = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ];

        // Jika password diisi, update password juga
        if ($request->filled('password')) {
            $dataUpdate['password'] = bcrypt($request->password); // Enkripsi password
        }

        $pengguna->update($dataUpdate);

        // 4️⃣ Redirect dengan pesan sukses
        return redirect()->route('edit_profile', ['id' => $id])->with('success', 'Data profile berhasil diubah');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

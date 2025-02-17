<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class dashboardPenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_Admin(){
        return view('pages.dashboard.dashboard');
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
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'password' => 'nullable|min:6',
        ]);
    
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

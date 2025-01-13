<?php

namespace App\Http\Controllers;

use App\Models\pengguna;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;

class penggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pengguna($id, Request $request)
    {
        if ($id == 'admin') {
            $data = pengguna::join('akun', 'akun.id', 'profile.id')
                ->select('profile.id', 'profile.nama', 'profile.email', 'profile.alamat', 'profile.no_telp', 'akun.role')
                ->where('akun.role', 'Admin')
                ->get();
        }

        elseif ($id == 'pengajar') {
            $data = pengguna::join('akun', 'akun.id', 'profile.id')
            ->select('profile.id', 'profile.nama', 'profile.email', 'profile.alamat', 'profile.no_telp', 'akun.role')
            ->where('akun.role', 'Pengajar')
            ->get();
        }

        elseif ($id == 'siswa') {
            $data = pengguna::join('akun', 'akun.id', 'profile.id')
            ->join('siswa', 'siswa.profiles_id', 'profile.id')
            ->join('sekolah', 'sekolah.id', 'siswa.sekolahs_id')
            ->select('profile.id', 'profile.nama', 'profile.email', 'profile.alamat', 'profile.no_telp', 'akun.role', 'sekolah.nama_sekolah')
            ->where('akun.role', 'Siswa')
            ->get();
        }
        
        // return response()->json($data);

        if ($request->ajax()) {
            return response()->json([
                'data' => $data,
                'id' => $id
            ]);
        }

        return view('pages.pengguna.admin', compact('data', 'id'));
    }

    public function datapengajar(Request $request)
    {
        $data = pengguna::join('akun', 'akun.id', 'profile.id')
            ->select('profile.id', 'profile.nama', 'profile.email', 'profile.alamat', 'profile.no_telp', 'akun.role')
            ->where('akun.role', 'Pengajar')
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.pengguna.pengajar', compact('data'));
    }

    public function datasiswa(Request $request)
    {
        $data = pengguna::join('akun', 'akun.id', 'profile.id')
            ->join('siswa', 'siswa.profile_id', 'profile.id')
            ->join('sekolah', 'sekolahs.id', 'siswa.sekolah_id')
            ->select('profile.id', 'profile.nama', 'profile.email', 'profile.alamat', 'profile.no_telp', 'akun.role')
            ->where('akun.role', 'Siswa')
            ->get();

        dd($data);

        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.pengguna.siswa', compact('data'));
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

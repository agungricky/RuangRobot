<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\kelas;
use App\Models\pembelajaran;
use App\Models\pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class dashboardPenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_Admin()
    {
        $total_siswa = akun::where('role', 'siswa')->count();
        $total_pengajar = akun::where('role', 'pengajar')->count();
        $total_kelas = kelas::count();

        $total = [
            'siswa' => $total_siswa,
            'pengajar' => $total_pengajar,
            'kelas' => $total_kelas
        ];

        $absenTerbaru = pembelajaran::whereNotNull('pembelajaran.tanggal')
            ->join('kelas', 'pembelajaran.kelas_id', 'kelas.id')
            ->select('pembelajaran.*', 'kelas.nama_kelas')
            ->orderBy('tanggal', 'desc')
            ->limit(8)
            ->get();


        return view('pages.dashboard.dashboard_admin', compact('total', 'absenTerbaru'));
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
        $message = [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 255 karakter.',

            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',

            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.min' => 'Nomor telepon minimal 14 karakter.',
            'no_telp.max' => 'Nomor telepon maksimal 15 karakter.',
            'no_telp.regex' => 'Nomor telepon harus diawali dengan +62',

            'password.min' => 'Password minimal 6 karakter.',
        ];

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|max:255',
            'no_telp' => 'required|min:14|max:15|regex:/^\+62[0-9]+$/',
            'password' => 'nullable|min:6',
        ], $message);

        try {
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
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', 'Gagal Memperbarui data profile!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

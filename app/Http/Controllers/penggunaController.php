<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\pengguna;
use App\Models\sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class penggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pengguna($id, Request $request)
    {
        if ($id == 'Admin') {
            $data = pengguna::join('akun', 'akun.id', 'profile.id')
                ->select('profile.*', 'akun.role', 'akun.username')
                ->where('akun.role', 'Admin')
                ->get();
        } elseif ($id == 'Pengajar') {
            $data = pengguna::join('akun', 'akun.id', 'profile.id')
                ->select('profile.*', 'akun.role', 'akun.username')
                ->where('akun.role', 'Pengajar')
                ->get();
        } elseif ($id == 'Siswa') {
            $data = pengguna::join('akun', 'akun.id', 'profile.id')
                ->join('sekolah', 'sekolah.id', 'profile.sekolah_id')
                ->select('profile.*', 'akun.role', 'akun.username', 'sekolah.nama_sekolah')
                ->where('akun.role', 'Siswa')
                ->get();
        }

        // dd($data);

        if ($request->ajax()) {
            return response()->json([
                'data' => $data,
                'id' => $id
            ]);
        }

        return view('pages.pengguna.pengguna', compact('data', 'id'));
    }

    public function sekolah()
    {
        $data = sekolah::all();
        return response()->json($data);
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
        $message = [
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'alamat.required' => 'Alamat harus diisi',
            'no_telp.required' => 'No. Telp harus diisi',
            'no_telp.regex' => 'No. Telp harus diawali dengan +62',
            'sekolah_id.required' => 'Sekolah harus diisi',
        ];

        $request->validate([
            'username' => 'required|unique:akun',
            'password' => 'required',
            'role' => 'required',
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
            'no_telp' => 'required|regex:/^\+62[0-9]+$/',
            // 'sekolah_id' => 'nullable|exists:sekolah,id',
        ], $message);

        // Mulai transaksi
        DB::beginTransaction();

        try {
            $akun = akun::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            pengguna::create([
                'id' => $akun->id,
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'sekolah_id' => $request->sekolah_id,
                'elektronik' => $request->elektronik,
                'mekanik' => $request->mekanik,
                'pemrograman' => $request->pemrograman,
            ]);

            DB::commit();

            return redirect()->route('akun.index')->with('success', 'Akun dan profil berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.'])->withInput();
        }
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

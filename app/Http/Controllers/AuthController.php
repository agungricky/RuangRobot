<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\indexPendaftaran;
use App\Models\pengguna;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showlogin()
    {
        return view('auth.login');
    }

    public function Authenticate(Request $request)
    {
        $credential = $request->only('username', 'password');

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            if ($role == 'Admin') {
                return redirect()->intended(route('dashboard'));
            } elseif ($role == 'Pengajar') {
                return redirect()->intended(route('dashboard_pengajar'));
            } else {
                return redirect()->intended(route('dashboard_siswa'));
            }
        } else {
            return back()->with('gagal', 'Password atau username salah');
        }
    }

    public function Logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }


    public function register($kategori, $id)
    {
        $ktg = $kategori;
        $indexPendaftaran = indexPendaftaran::where('code', $id)->first();
        return view('auth.register', compact('ktg', 'indexPendaftaran'));
    }

    public function register_reguler($kategori)
    {
        $ktg = $kategori;
        $indexPendaftaran = collect([
            [
                "title" => "Pendaftaran Kelas Reguler",
                "kategori_id" => "Reguler",
                "code" => "00001",
            ]
        ]);

        $indexPendaftaran = (object) $indexPendaftaran->first();
        return view('auth.register', compact('ktg', 'indexPendaftaran'));
    }

    public function register_post(Request $request)
    {
        $message = [
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'no_telp.required' => 'No Telp harus diisi.',
            'sekolah_id.required' => 'Sekolah harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
        ];

        $validated = $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required',
            'sekolah_id' => 'required',
            'alamat' => 'required',
        ], $message);

        $validated['mekanik'] = 0;
        $validated['elektronik'] = 0;
        $validated['pemrograman'] = 0;

        $akun = akun::create([
            'username' => "null",
            'password' => Hash::make("ruangrobot"),
            'role' => 'Siswa',
        ]);

        $validated['id'] = $akun->id;

        if ($validated['sekolah_id'] == 'lainnya') {
            $validated['sekolah_id'] = null;
        }

        pengguna::create($validated);
        return redirect()->route('login')->with('success', 'Registrasi berhasil, Anda akan dihubungi oleh Admin.');
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

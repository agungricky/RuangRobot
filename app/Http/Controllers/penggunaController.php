<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\invoice;
use App\Models\muridKelas;
use App\Models\pendaftaran;
use App\Models\pengguna;
use App\Models\riwayatPembayaran;
use App\Models\sekolah;
use App\Models\siswa;
use Exception;
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
                ->orderBy('akun.created_at', 'desc')
                ->get();
        }

        if ($request->ajax()) {
            return response()->json([
                'data' => $data,
                'id' => $id
            ]);
        }

        return view('pages.pengguna.pengguna', compact('data', 'id'));
    }

    public function permintaan_mendaftar($id, Request $request)
    {
        $data = pendaftaran::where('kategori', 'Reguler')->get();
        return response()->json($data, 200);
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
            'tgl_lahir' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
            'no_telp' => 'required|regex:/^\+62[0-9]+$/',
            'sekolah_id' => 'nullable|exists:sekolah,id',
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
                'tgl_lahir' => $request->tgl_lahir,
                'kelas' => $request->kelas,
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
    public function reset_password(string $id)
    {
        try {
            akun::where('id', $id)->update([
                'password' => Hash::make('ruangrobot')
            ]);

            return back()->with('success', 'Password berhasil direset!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Password gagal direset!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, $role)
    {
        $data = pengguna::with('akun', 'sekolah')->where('id', $id)->first();
        $sekolah = sekolah::all();

        return view('pages.pengguna.edit_pengguna', compact('data', 'role', 'sekolah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, $role)
    {
        $request->validate([
            'username' => 'required|string|max:100|unique:akun,username,' . $request->id,
            'password' => 'nullable|string|min:8',
            'role'     => 'required|in:Admin,Pengajar,Siswa',
            'nama'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'alamat'      => 'required|string|max:255',
            'no_telp'     => 'required|string|max:20',
            'sekolah_id'  => 'nullable|exists:sekolah,id',
            'kelas'       => 'nullable|string|max:100',
            'tgl_lahir'   => 'required|date',
            'mekanik'     => 'nullable|integer|min:0',
            'elektronik'  => 'nullable|integer|min:0',
            'pemrograman' => 'nullable|integer|min:0',
        ]);

        $dataUpdate = [
            'username' => $request->username,
            'role' => $request->role
        ];

        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->password);
        }

        akun::where('id', $id)->update($dataUpdate);


        $updateProfile = [
            'tgl_lahir' => $request->tgl_lahir,
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            // 'sekolah' => $request->sekolah_id,
        ];

        if ($request->filled('sekolah_id')) {
            $updateProfile['sekolah_id'] = $request->sekolah_id;
        }

        if ($request->filled('kelas')) {
            $updateProfile['kelas'] = $request->kelas;
        }

        pengguna::where('id', $id)->update($updateProfile);

        $kelas_diikuti = invoice::where('profile_id', $id)->get();
        foreach ($kelas_diikuti as $key => $value) {
            $murid_kelas = muridKelas::where('kelas_id', $value->kelas_id)->first();
            if ($murid_kelas) {
                $murid_array = json_decode($murid_kelas->murid, true);
                foreach ($murid_array as &$value) {
                    dd($value);
                    if ($value['id'] == $id) {
                        $value['nama'] = $updateProfile['nama'];
                        // $value['sekolah'] = $updateProfile['sekolah'];
                        break;
                    }
                }

                unset($value);
                $murid_kelas->murid = json_encode($murid_array);
                $murid_kelas->save();
            }
        }

        return redirect()->route('pengguna', ['id' => $role])->with('success', 'Data pengguan berhasil diUpdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, $role)
    {
        try {
            DB::transaction(function () use ($id) {
                invoice::where('profile_id', $id)->delete();
                riwayatPembayaran::where('nama', $id)->delete();
                pengguna::find($id)->delete();
                akun::find($id)->delete();
            });
            return redirect()->route('pengguna', ['id' => $role])->with('success', 'Data pengguna berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('pengguna', ['id' => $role])->with('error', 'Data pengguna gagal dihapus' . ' ' . $e->getMessage());
        }
    }

    public function kelas_diikuti($id)
    {
        $data = invoice::with('kelas.program_belajar', 'pengguna')
            ->where('profile_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.pengguna.kelas_diikuti', compact('data'));
    }
}

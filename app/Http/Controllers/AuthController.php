<?php

namespace App\Http\Controllers;

use App\Models\akun;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            }
            elseif ($role == 'Pengajar') {
                return redirect()->intended(route('dashboard_pengajar'));
            }
            else{
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

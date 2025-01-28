<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\gajiUtama;
use Illuminate\Http\Request;

class gajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = akun::where('role', 'Pengajar')
        ->join('profile', 'profile.id', 'akun.id')
        ->get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        // dd($data);
        return view('pages.gaji.gaji', compact('data'));
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

<?php

namespace App\Http\Controllers;

use App\Models\programbelajar;
use Illuminate\Http\Request;

class programbelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = programbelajar::join('tipe_kelas','tipe_kelas.id', 'program_belajar.jenis_kelas_id')
        ->select('program_belajar.*','tipe_kelas.*')->get();

        dd($data);
        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.program_belajar.program_belajar', compact('data'));
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

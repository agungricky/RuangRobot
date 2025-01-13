<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Tipekelas;
use Illuminate\Http\Request;

class kategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_jeniskelas(Request $request)
    {
        $data = Kategori::all();

        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }
        return view('pages.kategory.kategori_kelas');

    }

    public function index_tipekelas(Request $request)
    {
        $data = Tipekelas::all();

        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }
        return view('pages.kategory.tipe_kelas');

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
        return view('pages.kategory.edit_kategori_kelas');
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

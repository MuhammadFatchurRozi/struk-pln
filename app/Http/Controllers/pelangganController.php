<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\pelanggan as Pelanggan;

class pelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggan = Pelanggan::latest()->paginate(10);
        return view('pelanggan.index', compact('pelanggan'));
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
        
        // Validasi data array
        $request->validate([
            'pelanggan.*.idpel' => 'required|unique:pelanggans,idpel',
            'pelanggan.*.nama' => 'required',
            'pelanggan.*.tarif_daya' => 'required',
            'pelanggan.*.stand_meter' => 'required'
        ]);

        $count = 0;
        foreach ($request->pelanggan as $data) {
            Pelanggan::create($data);
            $count++;
        }

        return redirect()->back()->with('success', "$count pelanggan berhasil ditambahkan!");
        
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

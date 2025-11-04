<?php

namespace App\Http\Controllers\AdminData;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $desas = Desa::with('kecamatan')->latest()->paginate(10);
        return view('admin-data.desa.index', compact('desas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kecamatans = Kecamatan::all();
        return view('admin-data.desa.create', compact('kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_desa' => 'required|string|max:100',
            'kecamatan_id' => 'required|exists:kecamatan,id_kecamatan', 
        ]);

        Desa::create($request->all());

        return redirect()->route('admin-data.desa.index')
                         ->with('success', 'Data desa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Desa $desa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Desa $desa)
    {
        $kecamatans = Kecamatan::all();
        return view('admin-data.desa.edit', compact('desa', 'kecamatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Desa $desa)
    {
        $request->validate([
            'nama_desa' => 'required|string|max:100',
            'kecamatan_id' => 'required|exists:kecamatan,id_kecamatan',
        ]);

        $desa->update($request->all());

        return redirect()->route('admin-data.desa.index')
                         ->with('success', 'Data desa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Desa $desa)
    {
        $desa->delete();

        return redirect()->route('admin-data.desa.index')
                         ->with('success', 'Data desa berhasil dihapus.');
    }
}

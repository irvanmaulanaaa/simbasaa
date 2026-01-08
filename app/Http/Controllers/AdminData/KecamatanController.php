<?php

namespace App\Http\Controllers\AdminData;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kecamatan::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_kecamatan', 'like', '%' . $request->search . '%');
        }

        $perPage = $request->input('per_page', 10);

        $kecamatans = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin-data.kecamatan.index', compact('kecamatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-data.kecamatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
        ]);

        Kecamatan::create([
            'nama_kecamatan' => $request->nama_kecamatan,
            'kab_kota' => 'Kabupaten Bandung',
        ]);

        return redirect()->route('admin-data.kecamatan.index')->with('success', 'Kecamatan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kecamatan $kecamatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kecamatan $kecamatan)
    {
        return view('admin-data.kecamatan.edit', compact('kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kecamatan $kecamatan)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:100',
        ]);

        $kecamatan->update([
            'nama_kecamatan' => $request->nama_kecamatan,
        ]);

        return redirect()->route('admin-data.kecamatan.index')
            ->with('success', 'Data kecamatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();

        return redirect()->route('admin-data.kecamatan.index')
            ->with('success', 'Data kecamatan berhasil dihapus.');
    }
}

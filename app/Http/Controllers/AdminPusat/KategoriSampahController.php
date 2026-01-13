<?php

namespace App\Http\Controllers\AdminPusat;

use App\Http\Controllers\Controller;
use App\Models\KategoriSampah;
use Illuminate\Http\Request;

class KategoriSampahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KategoriSampah::query();

        // Tambahan fitur search kategori
        if ($request->has('search')) {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%');
        }

        $kategoris = $query->latest()->paginate(10);
        
        return view('admin-pusat.kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-pusat.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_sampah,nama_kategori',
        ]);

        KategoriSampah::create($validated);

        return redirect()->route('admin-pusat.kategori-sampah.index')
            ->with('success', 'Kategori sampah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriSampah $kategoriSampah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriSampah $kategoriSampah)
    {
        return view('admin-pusat.kategori.edit', compact('kategoriSampah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriSampah $kategoriSampah)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_sampah,nama_kategori,' . $kategoriSampah->id_kategori . ',id_kategori',
        ]);

        $kategoriSampah->update($validated);

        return redirect()->route('admin-pusat.kategori-sampah.index')
            ->with('success', 'Kategori sampah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriSampah $kategoriSampah)
    {
        $kategoriSampah->delete();

        return redirect()->route('admin-pusat.kategori-sampah.index')
            ->with('success', 'Kategori sampah berhasil dihapus.');
    }
}

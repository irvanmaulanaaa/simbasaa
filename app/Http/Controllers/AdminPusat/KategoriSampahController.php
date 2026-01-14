<?php

namespace App\Http\Controllers\AdminPusat;

use App\Http\Controllers\Controller;
use App\Models\KategoriSampah;
use App\Models\Sampah;
use Illuminate\Http\Request;

class KategoriSampahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KategoriSampah::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%');
        }

        $perPage = $request->input('per_page', 10);

        $kategoris = $query->orderBy('nama_kategori', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin-pusat.kategori.index', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'nama_kategori.required' => 'Nama Kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama Kategori sudah ada, silakan gunakan nama lain.',
            'nama_kategori.max' => 'Nama Kategori maksimal 100 karakter.',
        ];

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_sampah,nama_kategori',
        ], $messages);

        KategoriSampah::create($validated);

        return redirect()->route('admin-pusat.kategori-sampah.index')
            ->with('success', 'Kategori sampah berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategoriSampah = KategoriSampah::findOrFail($id);

        $messages = [
            'nama_kategori.required' => 'Nama Kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama Kategori sudah ada.',
        ];

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_sampah,nama_kategori,' . $id . ',id_kategori',
        ], $messages);

        $kategoriSampah->update($validated);

        return redirect()->route('admin-pusat.kategori-sampah.index')
            ->with('success', 'Kategori sampah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $isUsed = Sampah::where('kategori_id', $id)->exists();

        if ($isUsed) {
            return redirect()->back()->with('error', 'Gagal! Kategori ini sedang digunakan oleh Data Sampah.');
        }

        $kategori = KategoriSampah::findOrFail($id);
        $kategori->delete();

        return redirect()->route('admin-pusat.kategori-sampah.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSampah;
use Illuminate\Http\Request;
use App\Models\KategoriSampah;

class JenisSampahController extends Controller
{
    public function index()
    {
        $jenisSampah = JenisSampah::with('kategoriSampah')->latest()->paginate(10);
        return view('admin.jenis_sampah.index', compact('jenisSampah'));
    }

    /**
     * Menampilkan form untuk menambah jenis sampah baru.
     */
    public function create()
    {
        $kategori = KategoriSampah::all();
        return view('admin.jenis_sampah.create', compact('kategori'));
    }

    /**
     * Menyimpan jenis sampah baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_sampah_id' => 'required|exists:kategori_sampah,id',
            'harga_per_kg' => 'required|integer|min:0',
        ]);

        JenisSampah::create([
            'nama' => $request->nama,
            'kategori_sampah_id' => $request->kategori_sampah_id,
            'harga_per_kg' => $request->harga_per_kg,
        ]);

        return redirect()->route('admin.jenis_sampah.index')->with('success', 'Jenis sampah berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data jenis sampah.
     */
    public function show(JenisSampah $jenisSampah)
    {
        // Mengirim data jenis sampah yang dipilih ke view 'show'
        return view('admin.jenis_sampah.show', compact('jenisSampah'));
    }

    /**
     * Menampilkan form untuk mengedit jenis sampah.
     */
    public function edit(JenisSampah $jenisSampah)
    {
        $kategori = KategoriSampah::all();
        return view('admin.jenis_sampah.edit', compact('jenisSampah', 'kategori'));
    }

    /**
     * Memperbarui data jenis sampah di database.
     */
    public function update(Request $request, JenisSampah $jenisSampah)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_sampah_id' => 'required|exists:kategori_sampah,id',
            'harga_per_kg' => 'required|integer|min:0',
        ]);

        $jenisSampah->update($request->all());

        return redirect()->route('admin.jenis_sampah.index')->with('success', 'Jenis sampah berhasil diperbarui.');
    }

    /**
     * Menghapus data jenis sampah dari database.
     */
    public function destroy(JenisSampah $jenisSampah)
    {
        $jenisSampah->delete();

        return redirect()->route('admin.jenis_sampah.index')->with('success', 'Jenis sampah berhasil dihapus.');
    }
}

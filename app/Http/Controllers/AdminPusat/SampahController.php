<?php

namespace App\Http\Controllers\AdminPusat;

use App\Http\Controllers\Controller;
use App\Models\Sampah;
use App\Models\KategoriSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SampahController extends Controller
{
    /**
     * Menampilkan daftar sampah.
     */
    public function index()
    {
        $sampahs = Sampah::with('kategori')->latest()->paginate(10);
        return view('admin-pusat.sampah.index', compact('sampahs'));
    }

    /**
     * Menampilkan form tambah sampah.
     */
    public function create()
    {
        $kategoris = KategoriSampah::all();
        return view('admin-pusat.sampah.create', compact('kategoris'));
    }

    /**
     * Menyimpan data sampah baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_sampah' => 'required|string|max:255',
            'kode_sampah' => 'required|string|max:20|unique:sampah,kode_sampah',
            'kategori_id' => 'required|exists:kategori_sampah,id_kategori',
            'harga_anggota' => 'required|numeric|min:0',
            'UOM' => 'required|in:kg,pcs',
            'status_sampah' => 'required|in:aktif,tidak_aktif',
        ]);

        $data = $request->all();
        $data['diinput_oleh'] = Auth::id();

        Sampah::create($data);

        return redirect()->route('admin-pusat.sampah.index')
            ->with('success', 'Data sampah berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit sampah.
     */
    public function edit(Sampah $sampah)
    {
        $kategoris = KategoriSampah::all();
        return view('admin-pusat.sampah.edit', compact('sampah', 'kategoris'));
    }

    /**
     * Mengupdate data sampah.
     */
    public function update(Request $request, Sampah $sampah)
    {
        $request->validate([
            'nama_sampah' => 'required|string|max:255',
            'kode_sampah' => ['required', 'string', 'max:20', Rule::unique('sampah')->ignore($sampah->id_sampah, 'id_sampah')],
            'kategori_id' => 'required|exists:kategori_sampah,id_kategori',
            'harga_anggota' => 'required|numeric|min:0',
            'UOM' => 'required|in:kg,pcs',
            'status_sampah' => 'required|in:aktif,tidak_aktif',
        ]);

        $data = $request->all();

        if ($request->harga_anggota != $sampah->harga_anggota) {
            $data['harga_diupdate_oleh'] = Auth::id();
        }

        $sampah->update($data);

        return redirect()->route('admin-pusat.sampah.index')
            ->with('success', 'Data sampah berhasil diperbarui.');
    }

    /**
     * Menghapus data sampah.
     */
    public function destroy(Sampah $sampah)
    {
        $sampah->delete();

        return redirect()->route('admin-pusat.sampah.index')
            ->with('success', 'Data sampah berhasil dihapus.');
    }
}
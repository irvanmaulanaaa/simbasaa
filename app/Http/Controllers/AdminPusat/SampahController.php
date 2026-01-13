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
    public function index(Request $request)
    {
        // 1. Ambil query dasar dengan relasi kategori
        $query = Sampah::with('kategori');

        // 2. Logika Search (Nama atau Kode)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_sampah', 'like', "%{$search}%")
                    ->orWhere('kode_sampah', 'like', "%{$search}%");
            });
        }

        // 3. Ambil input 'per_page' dari dropdown, default 10 jika tidak ada
        $perPage = $request->input('per_page', 10);

        // 4. Logika Filter Kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // 5. Logika Filter Status
        if ($request->filled('status')) {
            $query->where('status_sampah', $request->status);
        }

        $sampahs = $query->latest()->paginate($perPage)->withQueryString();

        // 7. Ambil data kategori untuk dropdown filter di View
        $kategoris = KategoriSampah::all();

        return view('admin-pusat.sampah.index', compact('sampahs', 'kategoris'));
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
    // File: App/Http/Controllers/AdminPusat/SampahController.php

    public function store(Request $request)
    {
        // 1. Definisikan Pesan Error Custom (Bahasa Indonesia)
        $messages = [
            // Pesan General
            'required' => ':attribute wajib diisi.',
            'numeric' => ':attribute harus berupa angka.',
            'unique' => ':attribute sudah terdaftar di sistem.',
            'min' => ':attribute tidak boleh kurang dari :min.',

            // Pesan Spesifik per Kolom (Agar teksnya rapi & konsisten)
            'nama_sampah.required' => 'Nama Sampah wajib diisi.',
            'kode_sampah.required' => 'Kode Sampah wajib diisi.',
            'kode_sampah.unique' => 'Kode Sampah ini sudah digunakan, silakan ganti.',
            'kode_bsb.required' => 'Kode BSB wajib diisi.',

            // Khusus Dropdown pakai kata "dipilih"
            'kategori_id.required' => 'Kategori sampah wajib dipilih.',
            'status_sampah.required' => 'Status sampah wajib dipilih.',
            'UOM.required' => 'Satuan (UOM) wajib dipilih.',

            // Khusus Harga
            'harga_anggota.required' => 'Harga Anggota wajib diisi.',
            'harga_bsb.required' => 'Harga BSB wajib diisi.',
        ];

        // 2. Validasi Input
        $request->validate([
            'nama_sampah' => 'required|string|max:255',
            'kode_sampah' => 'required|string|max:20|unique:sampah,kode_sampah',
            'kode_bsb' => 'required|string|max:20', // Wajib isi, tapi boleh duplikat (tidak ada rule 'unique')
            'kategori_id' => 'required|exists:kategori_sampah,id_kategori',
            'harga_anggota' => 'required|numeric|min:0',
            'harga_bsb' => 'required|numeric|min:0',
            'UOM' => 'required|in:kg,pcs',
            'status_sampah' => 'required|in:aktif,tidak_aktif',
        ], $messages); // <--- Masukkan variabel messages di sini

        // 3. Simpan Data
        $data = $request->all();
        $data['diinput_oleh'] = Auth::id(); // Mengambil ID user yang sedang login

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
    public function update(Request $request, string $id)
    {
        // 1. Definisikan Pesan Error (Bahasa Indonesia)
        // Ini yang akan muncul jika user mengosongkan kolom
        $messages = [
            'required' => ':attribute wajib diisi.',
            'numeric' => ':attribute harus berupa angka.',
            'unique' => ':attribute sudah terdaftar di sistem.',

            // Pesan Spesifik (Biar lebih rapi)
            'nama_sampah.required' => 'Nama Sampah wajib diisi.',
            'kode_sampah.required' => 'Kode Sampah wajib diisi.',
            'kode_bsb.required' => 'Kode BSB wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.', // Khusus dropdown pakai kata "dipilih"
            'status_sampah.required' => 'Status wajib dipilih.',
            'UOM.required' => 'Satuan wajib dipilih.',
        ];

        // 2. Validasi Input
        $request->validate([
            'nama_sampah' => 'required|string|max:255',
            // Note: unique validasi di bawah ini mengecualikan ID sampah yang sedang diedit ($id)
            'kode_sampah' => 'required|string|max:50|unique:sampah,kode_sampah,' . $id . ',id_sampah',
            'kode_bsb' => 'required|string|max:50',
            'kategori_id' => 'required|exists:kategori_sampah,id_kategori',
            'harga_anggota' => 'required|numeric|min:0',
            'harga_bsb' => 'required|numeric|min:0',
            'UOM' => 'required|in:kg,pcs',
            'status_sampah' => 'required|in:aktif,tidak_aktif',
        ], $messages); // <--- VALIDASI DIJALANKAN DISINI

        // 3. Jika Lolos Validasi, Baru Simpan
        $sampah = Sampah::findOrFail($id);
        $sampah->update($request->all());

        return redirect()->route('admin-pusat.sampah.index')
            ->with('success', 'Data sampah berhasil diperbarui.');
    }

    /**
     * Menghapus data sampah.
     */
    public function destroy(string $id)
    {
        $sampah = Sampah::findOrFail($id);

        // Alih-alih $sampah->delete(), kita ubah statusnya
        $sampah->update([
            'status_sampah' => 'tidak_aktif'
        ]);

        return redirect()->route('admin-pusat.sampah.index')
            ->with('success', 'Data sampah berhasil dinonaktifkan.');
    }

    public function checkCode(Request $request)
    {
        if ($request->has('code')) {
            $exists = Sampah::where('kode_sampah', $request->code)->exists();
            return response()->json(['exists' => $exists]);
        }
        return response()->json(['exists' => false]);
    }
}
<?php

namespace App\Http\Controllers\AdminPusat;

use App\Http\Controllers\Controller;
use App\Models\Sampah;
use App\Models\KategoriSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\SampahExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class SampahController extends Controller
{
    /**
     * Menampilkan daftar sampah.
     */
    public function index(Request $request)
    {
        $query = Sampah::with('kategori');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_sampah', 'like', "%{$search}%")
                    ->orWhere('kode_bsb', 'like', "%{$search}%")
                    ->orWhere('kode_sampah', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('status')) {
            $query->where('status_sampah', $request->status);
        }

        $sampahs = $query->latest()->paginate($perPage)->withQueryString();

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
    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi.',
            'numeric' => ':attribute harus berupa angka.',
            'unique' => ':attribute sudah terdaftar di sistem.',
            'min' => ':attribute tidak boleh kurang dari :min.',
            'image' => 'File yang diupload harus berupa gambar.',
            'mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'max' => 'Ukuran gambar maksimal 2MB.',

            'nama_sampah.required' => 'Nama Sampah wajib diisi.',
            'kode_sampah.required' => 'Kode Sampah wajib diisi.',
            'kode_sampah.unique' => 'Kode Sampah ini sudah digunakan, silakan ganti.',
            'kode_bsb.required' => 'Kode BSB wajib diisi.',

            'kategori_id.required' => 'Kategori sampah wajib dipilih.',
            'status_sampah.required' => 'Status sampah wajib dipilih.',
            'UOM.required' => 'Satuan (UOM) wajib dipilih.',

            'harga_anggota.required' => 'Harga Anggota wajib diisi.',
            'harga_bsb.required' => 'Harga BSB wajib diisi.',
        ];

        $request->validate([
            'nama_sampah' => 'required|string|max:255',
            'kode_sampah' => 'required|string|max:20|unique:sampah,kode_sampah',
            'kode_bsb' => 'required|string|max:20',
            'kategori_id' => 'required|exists:kategori_sampah,id_kategori',
            'harga_anggota' => 'required|numeric|min:0',
            'harga_bsb' => 'required|numeric|min:0',
            'UOM' => 'required|in:kg,pcs',
            'status_sampah' => 'required|in:aktif,tidak_aktif',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], $messages);

        $data = $request->except('gambar');
        $data['diinput_oleh'] = Auth::id();

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('sampah'), $imageName);
            $data['gambar'] = 'sampah/' . $imageName;
        }

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
        $messages = [
            'required' => ':attribute wajib diisi.',
            'numeric' => ':attribute harus berupa angka.',
            'unique' => ':attribute sudah terdaftar di sistem.',
            'image' => 'File yang diupload harus berupa gambar.',
            'mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'max' => 'Ukuran gambar maksimal 2MB.',

            'nama_sampah.required' => 'Nama Sampah wajib diisi.',
            'kode_sampah.required' => 'Kode Sampah wajib diisi.',
            'kode_bsb.required' => 'Kode BSB wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'status_sampah.required' => 'Status wajib dipilih.',
            'UOM.required' => 'Satuan wajib dipilih.',
        ];

        $request->validate([
            'nama_sampah' => 'required|string|max:255',
            'kode_sampah' => 'required|string|max:50|unique:sampah,kode_sampah,' . $id . ',id_sampah',
            'kode_bsb' => 'required|string|max:50',
            'kategori_id' => 'required|exists:kategori_sampah,id_kategori',
            'harga_anggota' => 'required|numeric|min:0',
            'harga_bsb' => 'required|numeric|min:0',
            'UOM' => 'required|in:kg,pcs',
            'status_sampah' => 'required|in:aktif,tidak_aktif',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], $messages);

        $sampah = Sampah::findOrFail($id);
        $data = $request->except(['gambar', 'hapus_gambar']);

        if ($request->has('hapus_gambar') && $request->hapus_gambar == '1') {
            if ($sampah->gambar && file_exists(public_path($sampah->gambar))) {
                unlink(public_path($sampah->gambar));
            }
            $data['gambar'] = null;
        }

        if ($request->hasFile('gambar')) {
            if ($sampah->gambar && file_exists(public_path($sampah->gambar))) {
                unlink(public_path($sampah->gambar));
            }

            $image = $request->file('gambar');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('sampah'), $imageName);

            $data['gambar'] = 'sampah/' . $imageName;
        }

        $sampah->update($data);

        return redirect()->route('admin-pusat.sampah.index')
            ->with('success', 'Data sampah berhasil diperbarui.');
    }

    /**
     * Menghapus data sampah.
     */
    public function destroy(string $id)
    {
        $sampah = Sampah::findOrFail($id);

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

    public function exportPdf(Request $request)
    {
        if (ob_get_length()) {
            ob_end_clean();
        }

        $query = Sampah::with('kategori');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_sampah', 'like', "%{$search}%")
                    ->orWhere('kode_bsb', 'like', "%{$search}%")
                    ->orWhere('kode_sampah', 'like', "%{$search}%");
            });
        }
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('status')) {
            $query->where('status_sampah', $request->status);
        }

        $sampahs = $query->latest()->get();
        $admin = Auth::user();

        $pdf = Pdf::loadView('admin-pusat.sampah.pdf', compact('sampahs', 'admin', 'request'));

        return $pdf->setPaper('A4', 'landscape')->stream('Master_Data_Sampah_SIMBASA.pdf');
    }

    public function exportExcel(Request $request)
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        return Excel::download(new SampahExport($request), 'Master_Data_Sampah.xlsx');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class WargaController extends Controller
{
    /**
     * Menampilkan daftar semua warga.
     */
    public function index()
    {
        $warga = User::where('role', 'warga')->latest()->paginate(10);
        return view('admin.warga.index', compact('warga'));
    }

    /**
     * Menampilkan form untuk menambah warga baru.
     */
    public function create()
    {
        return view('admin.warga.create');
    }

    /**
     * Menyimpan data warga baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|min:16|unique:users,nik',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'kab_kota' => 'nullable|string',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['role'] = 'warga';

        // 3. Buat user baru menggunakan data yang sudah bersih
        User::create($validatedData);

        // 4. Redirect
        return redirect()->route('admin.warga.index')->with('success', 'Akun warga berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data seorang warga.
     */
    public function show(User $warga)
    {
        return view('admin.warga.show', compact('warga'));
    }

    /**
     * Menampilkan form untuk mengedit data warga.
     */
    public function edit(User $warga)
    {
        return view('admin.warga.edit', compact('warga'));
    }

    /**
     * Memperbarui data warga di database.
     */
    public function update(Request $request, User $warga)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|min:16|unique:users,nik,' . $warga->id,
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'kab_kota' => 'nullable|string',
            'password' => 'nullable|string|min:8',
        ]);

        $updateData = $request->except('password');

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $warga->update($updateData);
        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil diperbarui.');
    }

    /**
     * Menghapus data warga dari database.
     */
    public function destroy(User $warga)
    {
        $warga->delete();
        return redirect()->route('admin.warga.index')->with('success', 'Akun warga berhasil dihapus.');
    }
}

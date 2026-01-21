<?php

namespace App\Http\Controllers\AdminData;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use App\Models\User;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kecamatans = Kecamatan::orderBy('nama_kecamatan', 'asc')->get();

        $query = Desa::with('kecamatan')->withCount('users');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_desa', 'like', '%' . $request->search . '%');
        }

        if ($request->has('kecamatan_id') && $request->kecamatan_id != '') {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }

        $perPage = $request->input('per_page', 10);
        $desas = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin-data.desa.index', compact('desas', 'kecamatans'));
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

        $jumlahUser = User::where('desa_id', $desa->id_desa)->count();

        if ($jumlahUser > 0) {
            return back()->with('error', 'Gagal menghapus! Desa ini sedang digunakan oleh ' . $jumlahUser . ' pengguna.');
        }

        $desa->delete();

        return redirect()->route('admin-data.desa.index')
            ->with('success', 'Data desa berhasil dihapus.');
    }
}

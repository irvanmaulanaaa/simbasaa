<?php

namespace App\Http\Controllers\AdminPusat;

use App\Http\Controllers\Controller;
use App\Models\JadwalPenimbangan;
use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPenimbanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwals = JadwalPenimbangan::with('desa')->latest('tgl_jadwal')->paginate(10);
        return view('admin-pusat.jadwal.index', compact('jadwals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desas = Desa::orderBy('nama_desa')->get();
        return view('admin-pusat.jadwal.create', compact('desas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'desa_id' => 'required|exists:desa,id_desa',
            'rw_penimbangan' => 'required|string|max:5',
            'tgl_jadwal' => 'required|date',
            'jam_penimbangan' => 'required',
        ]);

        JadwalPenimbangan::create([
            'user_id' => Auth::id(),
            'desa_id' => $request->desa_id,
            'rw_penimbangan' => $request->rw_penimbangan,
            'tgl_jadwal' => $request->tgl_jadwal,
            'jam_penimbangan' => $request->jam_penimbangan,
        ]);

        return redirect()->route('admin-pusat.jadwal.index')
            ->with('success', 'Jadwal penimbangan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JadwalPenimbangan $jadwalPenimbangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalPenimbangan $jadwal)
    {
        $desas = Desa::orderBy('nama_desa')->get();
        return view('admin-pusat.jadwal.edit', compact('jadwal', 'desas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JadwalPenimbangan $jadwal)
    {
        $request->validate([
            'desa_id' => 'required|exists:desa,id_desa',
            'rw_penimbangan' => 'required|string|max:5',
            'tgl_jadwal' => 'required|date',
            'jam_penimbangan' => 'required',
        ]);

        $jadwal->update([
            'desa_id' => $request->desa_id,
            'rw_penimbangan' => $request->rw_penimbangan,
            'tgl_jadwal' => $request->tgl_jadwal,
            'jam_penimbangan' => $request->jam_penimbangan,
            // user_id tidak diubah (tetap pembuat asli)
        ]);

        return redirect()->route('admin-pusat.jadwal.index')
            ->with('success', 'Jadwal penimbangan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalPenimbangan $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin-pusat.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}

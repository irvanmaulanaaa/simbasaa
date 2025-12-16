<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sampah;
use App\Models\Setoran;
use App\Models\DetailSetoran;
use App\Models\Saldo;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SetoranController extends Controller
{
    /**
     * Menampilkan form input setoran.
     */
    public function create()
    {
        $ketua = Auth::user();

        $wargas = User::whereHas('role', function ($q) {
            $q->where('nama_role', 'warga');
        })
            ->where('desa_id', $ketua->desa_id)
            ->where('rw', $ketua->rw)
            ->where('status', 'aktif')
            ->get();

        $sampahs = Sampah::where('status_sampah', 'aktif')->get();

        return view('ketua.setoran.create', compact('wargas', 'sampahs'));
    }

    /**
     * Menyimpan data setoran.
     */
    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:users,id_user',
            'sampah_id' => 'required|array',
            'sampah_id.*' => 'exists:sampah,id_sampah',
            'berat' => 'required|array',
            'berat.*' => 'numeric|min:0.1',
        ]);

        DB::transaction(function () use ($request) {
            $totalSetoran = 0;
            $details = [];

            foreach ($request->sampah_id as $index => $sampahId) {
                $berat = $request->berat[$index];
                $sampah = Sampah::find($sampahId);

                $subtotal = $berat * $sampah->harga_anggota;
                $totalSetoran += $subtotal;

                $details[] = [
                    'sampah_id' => $sampahId,
                    'berat' => $berat,
                    'subtotal' => $subtotal,
                ];
            }

            $setoran = Setoran::create([
                'warga_id' => $request->warga_id,
                'ketua_id' => Auth::id(),
                'total_harga' => $totalSetoran,
                'tgl_setor' => now(),
            ]);

            foreach ($details as $detail) {
                $setoran->detail()->create($detail);
            }

            $saldo = Saldo::firstOrCreate(
                ['user_id' => $request->warga_id],
                ['jumlah_saldo' => 0]
            );

            $saldo->increment('jumlah_saldo', $totalSetoran);
        });

        return redirect()->route('ketua.dashboard')
            ->with('success', 'Setoran berhasil dicatat dan saldo warga bertambah.');
    }

    public function show($id_setor)
    {
        $ketua = Auth::user();
        
        // Ambil data setoran, pastikan setoran tersebut milik wilayah Ketua
        $setoran = Setoran::with('warga', 'detail.sampah') // Eager load relasi
                        ->where('id_setor', $id_setor)
                        ->where('ketua_id', $ketua->id_user) // Opsional: Hanya setoran yang dicatat ketua sendiri
                        ->orWhereHas('warga', function($q) use ($ketua) {
                            $q->where('desa_id', $ketua->desa_id)
                              ->where('rw', $ketua->rw);
                        })
                        ->firstOrFail();

        return view('ketua.setoran.show', compact('setoran'));
    }
}
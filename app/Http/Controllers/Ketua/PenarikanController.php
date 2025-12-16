<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penarikan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PenarikanController extends Controller
{
    public function index()
    {
        $ketua = Auth::user();

        $penarikans = Penarikan::with('warga')
                        ->where('status', 'pending')
                        ->whereHas('warga', function($q) use ($ketua) {
                            $q->where('desa_id', $ketua->desa_id)
                              ->where('rw', $ketua->rw);
                        })
                        ->latest('tgl_request')
                        ->paginate(10);

        return view('ketua.penarikan.index', compact('penarikans'));
    }

    public function konfirmasi(Request $request, $id)
    {
        $penarikan = Penarikan::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:disetujui,ditolak'
        ]);

        $penarikan->update([
            'status' => $request->status,
            'ketua_id' => Auth::id(),
            'tgl_konfirmasi' => now(),
        ]);

        if ($request->status == 'disetujui') {
            $saldo = $penarikan->warga->saldo;
            if ($saldo) {
                $saldo->decrement('jumlah_saldo', $penarikan->jumlah);
            }
        }

        return redirect()->back()->with('success', 'Status penarikan berhasil diperbarui.');
    }
}
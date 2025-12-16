<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penarikan;
use App\Models\Saldo;

class PenarikanController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $saldo = $user->saldo ? $user->saldo->jumlah_saldo : 0;

        return view('warga.penarikan.create', compact('saldo'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $saldoSaatIni = $user->saldo ? $user->saldo->jumlah_saldo : 0;

        $request->validate([
            'jumlah' => 'required|numeric|min:10000|max:' . $saldoSaatIni,
            'keterangan' => 'nullable|string|max:255',
        ], [
            'jumlah.max' => 'Saldo Anda tidak mencukupi.',
            'jumlah.min' => 'Minimal penarikan Rp 10.000.',
        ]);

        $pending = Penarikan::where('warga_id', $user->id_user)
                    ->where('status', 'pending')->exists();
        
        if ($pending) {
            return back()->withErrors(['jumlah' => 'Anda masih memiliki penarikan yang sedang diproses.']);
        }

        Penarikan::create([
            'warga_id' => $user->id_user,
            'jumlah' => $request->jumlah,
            'status' => 'pending',
            'tgl_request' => now(),
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('warga.dashboard')
                         ->with('success', 'Permintaan penarikan berhasil diajukan!');
    }
}
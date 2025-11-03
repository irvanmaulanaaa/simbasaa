<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PenarikanController extends Controller
{
    /**
     * Menampilkan daftar semua permintaan penarikan yang masih pending.
     */
    public function index()
    {
        $permintaan = Transaksi::with('user')
            ->where('tipe', 'tarik')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);
            
        return view('admin.penarikan.index', compact('permintaan'));
    }

    /**
     * Menyetujui permintaan penarikan.
     */
    public function approve(Transaksi $transaksi)
    {
        $transaksi->update(['status' => 'approved']);
        return redirect()->route('admin.penarikan.index')->with('success', 'Permintaan penarikan berhasil disetujui.');
    }

    /**
     * Menolak permintaan penarikan.
     */
    public function reject(Transaksi $transaksi)
    {
        $transaksi->update(['status' => 'rejected']);
        return redirect()->route('admin.penarikan.index')->with('success', 'Permintaan penarikan berhasil ditolak.');
    }
}
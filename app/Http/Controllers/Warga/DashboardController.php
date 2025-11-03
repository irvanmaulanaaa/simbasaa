<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Logika perhitungan saldo INI TIDAK BERUBAH. Saldo tetap dihitung dari transaksi 'approved'.
        $totalSetor = $user->transaksi()->where('tipe', 'setor')->sum('jumlah');
        $totalTarik = $user->transaksi()->where('tipe', 'tarik')->where('status', 'approved')->sum('jumlah');
        $totalTabungan = $totalSetor - $totalTarik;

        // UBAH BAGIAN INI: Ambil SEMUA riwayat transaksi, bukan hanya yang 'approved'
        $riwayatTransaksi = $user->transaksi()->latest()->paginate(10);

        return view('warga.dashboard', compact('totalTabungan', 'riwayatTransaksi'));
    }

    /**
     * Menampilkan form untuk warga mengajukan penarikan.
     */
    public function createTarik()
    {
        $user = Auth::user();

        $totalSetor = $user->transaksi()->where('tipe', 'setor')->sum('jumlah');
        $totalTarik = $user->transaksi()->where('tipe', 'tarik')->where('status', 'approved')->sum('jumlah');
        $saldo = $totalSetor - $totalTarik;

        return view('warga.tarik_saldo', compact('saldo'));
    }

    /**
     * Menyimpan permintaan penarikan dari warga.
     */
    public function storeTarik(Request $request)
    {
        $user = Auth::user();

        $totalSetor = $user->transaksi()->where('tipe', 'setor')->sum('jumlah');
        $totalTarik = $user->transaksi()->where('tipe', 'tarik')->where('status', 'approved')->sum('jumlah');
        $saldo = $totalSetor - $totalTarik;

        $request->validate([
            'jumlah' => 'required|integer|min:10000|max:' . $saldo,
        ], [
            'jumlah.max' => 'Jumlah penarikan melebihi saldo Anda yang tersedia (Rp ' . number_format($saldo, 0, ',', '.') . ').'
        ]);

        $user->transaksi()->create([
            'tipe' => 'tarik',
            'jumlah' => $request->jumlah,
            'status' => 'pending',
            'tgl_transaksi' => now(),
        ]);

        return redirect()->route('warga.dashboard')->with('success', 'Permintaan penarikan saldo telah diajukan dan sedang menunggu persetujuan admin.');
    }
}
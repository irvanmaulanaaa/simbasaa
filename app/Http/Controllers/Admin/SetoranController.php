<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JenisSampah;
use Illuminate\Support\Facades\DB;

class SetoranController extends Controller
{
    public function index()
    {
        $setoran = Transaksi::with('user')->latest()->paginate(10);

        return view('admin.setoran.index', compact('setoran'));
    }

    /**
     * Menampilkan form untuk mencatat setoran baru.
     */
    public function create()
    {
        $warga = User::where('role', 'warga')->orderBy('nama')->get();
        $jenisSampah = JenisSampah::orderBy('nama')->get();

        return view('admin.setoran.create', compact('warga', 'jenisSampah'));
    }

    /**
     * Menyimpan data setoran baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_sampah_id' => 'required|exists:jenis_sampah,id',
            'berat' => 'required|numeric|min:0.1',
        ]);

        DB::transaction(function () use ($request) {
            $jenisSampah = JenisSampah::findOrFail($request->jenis_sampah_id);
            $subtotal = $jenisSampah->harga_per_kg * $request->berat;

            $transaksi = Transaksi::create([
                'user_id' => $request->user_id,
                'tipe' => 'setor',
                'jumlah' => $subtotal,
                'tgl_transaksi' => now(),
            ]);

            $transaksi->detailTransaksi()->create([
                'jenis_sampah_id' => $request->jenis_sampah_id,
                'berat' => $request->berat,
                'subtotal' => $subtotal,
            ]);
        });

        return redirect()->route('admin.setoran.index')->with('success', 'Setoran sampah berhasil dicatat.');
    }

    /**
     * Menampilkan detail sebuah transaksi.
     */
    public function show(Transaksi $setoran)
    {
        $setoran->load(['user', 'detailTransaksi.jenisSampah']);
        return view('admin.setoran.show', compact('setoran'));
    }

    /**
     * Menampilkan form untuk mengedit transaksi.
     */
    public function edit(Transaksi $setoran)
    {
        if ($setoran->tipe == 'setor') {
            return redirect()->route('admin.setoran.index')->with('error', 'Fitur edit untuk transaksi setor belum tersedia.');
        }

        return view('admin.setoran.edit', compact('setoran'));
    }

    /**
     * Memperbarui data transaksi di database.
     */
    public function update(Request $request, Transaksi $setoran)
    {
        $request->validate(['jumlah' => 'required|integer|min:1000']);

        $warga = $setoran->user;
        $totalSetor = $warga->transaksi()->where('tipe', 'setor')->sum('jumlah');
        $totalTarikLain = $warga->transaksi()->where('tipe', 'tarik')->where('id', '!=', $setoran->id)->where('status', 'approved')->sum('jumlah');
        $saldoTersedia = $totalSetor - $totalTarikLain;

        if ($request->jumlah > $saldoTersedia) {
            return back()->withErrors(['jumlah' => 'Saldo warga tidak mencukupi. Saldo tersedia: Rp ' . number_format($saldoTersedia, 0, ',', '.')])->withInput();
        }

        $setoran->update(['jumlah' => $request->jumlah]);

        return redirect()->route('admin.setoran.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Menghapus transaksi dari database.
     */
    public function destroy(Transaksi $setoran)
    {
        $setoran->delete();
        return redirect()->route('admin.setoran.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}

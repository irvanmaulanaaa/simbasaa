<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sampah;
use App\Models\Setoran;
use App\Models\DetailSetoran;
use App\Models\Saldo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SetoranController extends Controller
{
    /**
     * Halaman Utama (Index) dengan Filter & Pagination
     */
    public function index(Request $request)
    {
        $ketua = Auth::user();

        $dataRT = User::whereHas('role', function ($q) {
            $q->where('nama_role', 'warga');
        })
            ->where('desa_id', $ketua->desa_id)
            ->where('rw', $ketua->rw)
            ->whereHas('setoran', function ($q) {
            })
            ->select('rt')
            ->distinct()
            ->orderBy('rt', 'asc')
            ->pluck('rt');

        $query = Setoran::with(['warga', 'detail'])
            ->where(function ($q) use ($ketua) {
                $q->where('ketua_id', $ketua->id_user)
                    ->orWhereHas('warga', function ($subQ) use ($ketua) {
                        $subQ->where('desa_id', $ketua->desa_id)->where('rw', $ketua->rw);
                    });
            });

        if ($request->filled('search')) {
            $query->whereHas('warga', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('rt')) {
            $query->whereHas('warga', function ($q) use ($request) {
                $q->where('rt', $request->rt);
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tgl_setor', [$request->start_date, $request->end_date]);
        }

        $perPage = $request->input('per_page', 10);
        $setorans = $query->latest('tgl_setor')
            ->paginate($perPage)
            ->withQueryString(); 

        $wargas = User::whereHas('role', function ($q) {
            $q->where('nama_role', 'warga');
        })
            ->where('desa_id', $ketua->desa_id)
            ->where('rw', $ketua->rw)
            ->where('status', 'aktif')
            ->get();

        $sampahs = Sampah::where('status_sampah', 'aktif')->get();

        return view('ketua.setoran.index', compact('setorans', 'wargas', 'sampahs', 'dataRT'));
    }

    /**
     * Simpan Data Setoran Baru
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);

        DB::transaction(function () use ($request) {
            $totalSetoran = 0;
            $details = [];

            foreach ($request->sampah_id as $index => $sampahId) {
                $berat = $request->berat[$index];
                $sampah = Sampah::find($sampahId);
                $subtotal = $berat * $sampah->harga_anggota;
                $totalSetoran += $subtotal;

                $details[] = ['sampah_id' => $sampahId, 'berat' => $berat, 'subtotal' => $subtotal];
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

            $saldo = Saldo::firstOrCreate(['user_id' => $request->warga_id], ['jumlah_saldo' => 0]);
            $saldo->increment('jumlah_saldo', $totalSetoran);
        });

        return redirect()->back()->with('success', 'Setoran berhasil ditambahkan.');
    }

    /**
     * Get Data JSON (Untuk Edit/Detail via Modal AJAX)
     */
    public function show($id)
    {
        $setoran = Setoran::with(['warga', 'detail.sampah'])->findOrFail($id);
        return response()->json($setoran);
    }

    /**
     * Update (Simpan Perubahan)
     */
    public function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $setoran = Setoran::findOrFail($id);

        DB::transaction(function () use ($request, $setoran) {
            $saldo = Saldo::where('user_id', $setoran->warga_id)->first();
            if ($saldo)
                $saldo->decrement('jumlah_saldo', $setoran->total_harga);

            $setoran->detail()->delete();

            $totalSetoran = 0;
            foreach ($request->sampah_id as $index => $sampahId) {
                $berat = $request->berat[$index];
                $sampah = Sampah::find($sampahId);
                $subtotal = $berat * $sampah->harga_anggota;
                $totalSetoran += $subtotal;

                $setoran->detail()->create([
                    'sampah_id' => $sampahId,
                    'berat' => $berat,
                    'subtotal' => $subtotal
                ]);
            }

            $setoran->update([
                'warga_id' => $request->warga_id,
                'total_harga' => $totalSetoran,
            ]);

            $saldoBaru = Saldo::firstOrCreate(['user_id' => $request->warga_id], ['jumlah_saldo' => 0]);
            $saldoBaru->increment('jumlah_saldo', $totalSetoran);
        });

        return redirect()->back()->with('success', 'Setoran berhasil diperbarui.');
    }

    /**
     * Destroy (Hapus/Batalkan)
     */
    public function destroy($id)
    {
        $setoran = Setoran::findOrFail($id);

        DB::transaction(function () use ($setoran) {
            $saldo = Saldo::where('user_id', $setoran->warga_id)->first();
            if ($saldo)
                $saldo->decrement('jumlah_saldo', $setoran->total_harga);

            $setoran->detail()->delete();
            $setoran->delete();
        });

        return redirect()->back()->with('success', 'Data setoran dihapus dan saldo dikembalikan.');
    }

    private function validateRequest($request)
    {
        $request->validate([
            'warga_id' => 'required|exists:users,id_user',
            'sampah_id' => 'required|array',
            'sampah_id.*' => 'exists:sampah,id_sampah',
            'berat' => 'required|array',
            'berat.*' => 'numeric|min:0.1',
        ]);
    }
}

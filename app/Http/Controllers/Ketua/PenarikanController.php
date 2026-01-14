<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penarikan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PenarikanController extends Controller
{
    public function index(Request $request) 
    {
        $ketua = Auth::user();

        $pendingRequests = Penarikan::with('warga.saldo')
            ->where('status', 'pending')
            ->whereHas('warga', function ($q) use ($ketua) {
                $q->where('desa_id', $ketua->desa_id)
                    ->where('rw', $ketua->rw);
            })
            ->orderBy('tgl_request', 'asc')
            ->get();

        $query = Penarikan::with('warga', 'ketua')
            ->whereHas('warga', function ($q) use ($ketua) {
                $q->where('desa_id', $ketua->desa_id)
                    ->where('rw', $ketua->rw);
            });

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('warga', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tgl_request', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $query->latest('tgl_request');

        $perPage = $request->input('per_page', 10); 
        $historyRequests = $query->paginate($perPage)->withQueryString(); 

        return view('ketua.penarikan.index', compact('pendingRequests', 'historyRequests'));
    }

    public function konfirmasi(Request $request, $id)
    {
        $penarikan = Penarikan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan_ketua' => 'nullable|string',
        ]);

        $dataUpdate = [
            'status' => $request->status,
            'ketua_id' => Auth::id(),
            'tgl_konfirmasi' => now(),
        ];

        if ($request->status == 'ditolak') {
            $dataUpdate['catatan_ketua'] = $request->catatan_ketua;
        }

        $penarikan->update($dataUpdate);

        if ($request->status == 'disetujui') {
            $saldo = $penarikan->warga->saldo;
            if ($saldo) {
                $saldo->decrement('jumlah_saldo', $penarikan->jumlah);
            }
        }

        return redirect()->back()->with('success', 'Status penarikan berhasil diperbarui.');
    }
}

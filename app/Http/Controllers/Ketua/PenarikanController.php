<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penarikan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PenarikanExport;
use Maatwebsite\Excel\Facades\Excel;
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

        if ($request->filled('status')) {
            $query->where('status', $request->status);
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

    public function exportPdf(Request $request)
    {
        if (ob_get_length()) {
            ob_end_clean();
        }

        $ketua = Auth::user()->load('desa.kecamatan');

        $query = Penarikan::with('warga', 'ketua')
            ->whereHas('warga', function ($q) use ($ketua) {
                $q->where('desa_id', $ketua->desa_id)
                    ->where('rw', $ketua->rw);
            });

        if ($request->filled('search')) {
            $query->whereHas('warga', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tgl_request', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $penarikans = $query->latest('tgl_request')->get();
        $totalPenarikan = $penarikans->where('status', 'selesai')->sum('jumlah');

        $pdf = Pdf::loadView('ketua.penarikan.pdf', compact('penarikans', 'ketua', 'totalPenarikan', 'request'));

        return $pdf->setPaper('A4', 'landscape')->stream('Laporan_Penarikan_Saldo_RW_' . $ketua->rw . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        return Excel::download(new PenarikanExport($request), 'Laporan_Penarikan_Saldo.xlsx');
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
            $dataUpdate['tgl_selesai'] = now();
        }

        $penarikan->update($dataUpdate);

        return redirect()->back()->with('success', 'Status penarikan berhasil diperbarui.');
    }
}
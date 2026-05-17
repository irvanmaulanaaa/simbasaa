<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penarikan;
use Illuminate\Support\Facades\Validator;
use App\Models\Saldo;
use Barryvdh\DomPDF\Facade\Pdf;

class PenarikanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $saldo = $user->saldo ? $user->saldo->jumlah_saldo : 0;
        $query = Penarikan::where('warga_id', $user->id_user);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('tgl_request', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('tgl_request', '<=', $request->end_date);
        }

        $perPage = $request->input('per_page', 5);
        $riwayat = $query->latest('tgl_request')->paginate($perPage);

        return view('warga.penarikan.index', compact('saldo', 'riwayat'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $saldoSaatIni = $user->saldo ? $user->saldo->jumlah_saldo : 0;

        $validator = Validator::make($request->all(), [
            'jumlah' => 'required|numeric|min:10000|max:' . $saldoSaatIni,
        ], [
            'jumlah.max' => 'Saldo Anda tidak mencukupi.',
            'jumlah.min' => 'Minimal penarikan Rp 10.000.',
            'jumlah.required' => 'Jumlah penarikan wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $hasActiveRequest = Penarikan::where('warga_id', $user->id_user)
            ->whereIn('status', ['pending', 'disetujui'])->exists();

        if ($hasActiveRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Anda masih memiliki penarikan yang sedang diproses atau menunggu diambil.'
            ], 400);
        }

        Penarikan::create([
            'warga_id' => $user->id_user,
            'jumlah' => $request->jumlah,
            'status' => 'pending',
            'tgl_request' => now(),
            'is_read' => 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil dikirim! Menunggu konfirmasi Ketua RW.'
        ]);
    }

    public function konfirmasiSelesai($id)
    {
        $penarikan = Penarikan::where('id_tarik', $id)
            ->where('warga_id', Auth::user()->id_user)
            ->where('status', 'disetujui') // Pastikan hanya yg disetujui yg bisa diselesaikan
            ->firstOrFail();

        $penarikan->update([
            'status' => 'selesai',
            'tgl_selesai' => now()
        ]);

        // LOGIKA POTONG SALDO PINDAH KE SINI!
        $saldo = Auth::user()->saldo;
        if ($saldo) {
            $saldo->decrement('jumlah_saldo', $penarikan->jumlah);
        }

        return redirect()->back()->with('success', 'Transaksi Selesai! Saldo Anda telah dipotong.');
    }

    public function markAsRead($id)
    {
        $penarikan = Penarikan::where('id_tarik', $id)
            ->where('warga_id', Auth::user()->id_user)
            ->firstOrFail();

        $penarikan->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }

    public function exportPdf(Request $request)
    {
        if (ob_get_length()) { ob_end_clean(); }

        $user = Auth::user()->load('desa.kecamatan');
        $saldo = $user->saldo ? $user->saldo->jumlah_saldo : 0;
        
        $query = Penarikan::where('warga_id', $user->id_user);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('tgl_request', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('tgl_request', '<=', $request->end_date);
        }

        $riwayat = $query->latest('tgl_request')->get();

        $pdf = Pdf::loadView('warga.penarikan.pdf', compact('riwayat', 'user', 'saldo', 'request'));
        
        return $pdf->setPaper('A4', 'portrait')->stream('Buku_Tabungan_Penarikan_SIMBASA.pdf');
    }
}
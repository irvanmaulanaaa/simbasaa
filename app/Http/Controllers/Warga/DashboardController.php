<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setoran;
use App\Models\Konten;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $saldo = $user->saldo ? $user->saldo->jumlah_saldo : 0;
        $totalPendapatan = Setoran::where('warga_id', $user->id_user)->sum('total_harga');

        $details = DB::table('detail_setoran')
            ->join('setoran', 'detail_setoran.setor_id', '=', 'setoran.id_setor')
            ->join('sampah', 'detail_setoran.sampah_id', '=', 'sampah.id_sampah')
            ->where('setoran.warga_id', $user->id_user)
            ->select('detail_setoran.berat', 'sampah.UOM')
            ->get();

        $totalKg = 0;
        $totalPcs = 0;

        foreach ($details as $d) {
            $uom = strtolower($d->UOM);
            if ($uom == 'kg') {
                $totalKg += $d->berat;
            } elseif ($uom == 'pcs') {
                $totalPcs += $d->berat;
            }
        }
            
        $riwayatSetoran = Setoran::with('detail')
            ->where('warga_id', $user->id_user)
            ->latest('tgl_setor')
            ->limit(5)
            ->get();

        $kontenTerbaru = Konten::with('media')->latest()->limit(3)->get();

        return view('warga.dashboard', compact(
            'saldo', 'totalPendapatan', 'totalKg', 'totalPcs', 'riwayatSetoran', 'kontenTerbaru'
        ));
    }
}
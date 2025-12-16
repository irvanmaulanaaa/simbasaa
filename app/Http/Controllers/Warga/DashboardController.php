<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setoran;
use App\Models\Penarikan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $saldo = $user->saldo ? $user->saldo->jumlah_saldo : 0;

        $setorans = Setoran::where('warga_id', $user->id_user)
                    ->select('id_setor as id', 'total_harga as jumlah', 'tgl_setor as tanggal', \DB::raw("'setor' as tipe"), \DB::raw("'selesai' as status"))
                    ->get();

        $penarikans = Penarikan::where('warga_id', $user->id_user)
                    ->select('id_tarik as id', 'jumlah', 'tgl_request as tanggal', \DB::raw("'tarik' as tipe"), 'status')
                    ->get();

        $riwayat = $setorans->concat($penarikans)->sortByDesc('tanggal')->values();

        return view('warga.dashboard', compact('saldo', 'riwayat'));
    }
}
<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setoran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WargaSetoranController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Setoran::with(['detail.sampah'])
            ->where('warga_id', $user->id_user);

        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('tgl_setor', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('tgl_setor', '<=', $request->end_date);
        }

        $perPage = $request->input('per_page', 5);
        $setorans = $query->latest('tgl_setor')->paginate($perPage);
        $setoranQuery = DB::table('setoran')->where('warga_id', $user->id_user);

        if ($request->has('start_date') && $request->start_date != '') {
            $setoranQuery->whereDate('tgl_setor', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $setoranQuery->whereDate('tgl_setor', '<=', $request->end_date);
        }

        $listIdSetoran = $setoranQuery->pluck('id_setor'); 
        $totalPendapatan = $setoranQuery->sum('total_harga');

        $details = DB::table('detail_setoran')
            ->join('sampah', 'detail_setoran.sampah_id', '=', 'sampah.id_sampah')
            ->whereIn('detail_setoran.setor_id', $listIdSetoran)
            ->select('detail_setoran.berat', 'sampah.UOM')
            ->get();

        $totalKg = 0;
        $totalPcs = 0;

        foreach ($details as $d) {
            $satuan = strtolower($d->UOM); 

            if ($satuan == 'kg') {
                $totalKg += $d->berat;
            } elseif ($satuan == 'pcs') {
                $totalPcs += $d->berat;
            }
        }

        return view('warga.setoran.index', compact('setorans', 'totalPendapatan', 'totalKg', 'totalPcs'));
    }
}

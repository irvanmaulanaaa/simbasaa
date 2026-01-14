<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setoran;
use App\Models\Konten;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $riwayatSetoran = Setoran::with('warga')
            ->whereHas('warga', function ($q) use ($user) {
                $q->where('desa_id', $user->desa_id)
                    ->where('rw', $user->rw);
            })
            ->latest('tgl_setor')
            ->paginate(5);

        $kontenTerbaru = Konten::with('media')
            ->latest()
            ->take(3)
            ->get();

        return view('ketua.dashboard', compact('riwayatSetoran', 'kontenTerbaru'));
    }

}
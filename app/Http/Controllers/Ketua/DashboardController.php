<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setoran;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $riwayatSetoran = Setoran::with('warga')
                            ->where('ketua_id', $user->id_user)
                            ->latest('tgl_setor')
                            ->paginate(10);

        return view('ketua.dashboard', compact('riwayatSetoran'));
    }
}
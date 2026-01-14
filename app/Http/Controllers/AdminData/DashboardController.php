<?php

namespace App\Http\Controllers\AdminData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Konten;
use App\Models\User;
use Illuminate\Support\Facades\DB; 

class DashboardController extends Controller
{
    public function index()
    {
        $totalKecamatan = Kecamatan::count();
        $totalDesa = Desa::count();
        $totalKonten = Konten::count();
        $totalUsers = User::count();

        $kontenStatus = Konten::select('status_id', DB::raw('count(*) as total'))
            ->groupBy('status_id')
            ->with('status') 
            ->get();

        $chartLabels = $kontenStatus->map(fn($item) => $item->status->nama_status ?? 'Unknown')->toArray();
        $chartData = $kontenStatus->pluck('total')->toArray();

        $recentKonten = Konten::with(['user', 'status']) 
            ->latest()
            ->take(5) 
            ->get();

        return view('admin-data.dashboard', compact(
            'totalKecamatan',
            'totalDesa',
            'totalKonten',
            'totalUsers',
            'chartLabels',
            'chartData',    
            'recentKonten'  
        ));
    }
}
<?php

namespace App\Http\Controllers\AdminData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Konten;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKecamatan = Kecamatan::count();
        $totalDesa = Desa::count();
        $totalKonten = Konten::count();
        $totalUsers = User::count();
        
        return view('admin-data.dashboard', compact(
            'totalKecamatan', 
            'totalDesa', 
            'totalKonten',
            'totalUsers'
        ));
    }
}
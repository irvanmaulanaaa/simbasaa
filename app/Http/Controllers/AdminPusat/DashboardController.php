<?php

namespace App\Http\Controllers\AdminPusat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sampah;
use App\Models\KategoriSampah;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard Admin Pusat.
     */
    public function index()
    {
        $totalSampah = Sampah::count();
        $totalKategori = KategoriSampah::count();
        $sampahAktif = Sampah::where('status_sampah', 'aktif')->count();
        return view(
            'admin-pusat.dashboard',
            compact(
                'totalSampah',
                'totalKategori',
                'sampahAktif'
            )
        );
    }
}

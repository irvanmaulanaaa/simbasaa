<?php

namespace App\Http\Controllers\AdminPusat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sampah;
use App\Models\KategoriSampah;
use App\Models\JadwalPenimbangan;
use App\Models\Konten;
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
        $totalJadwal = JadwalPenimbangan::count();

        $jadwalTerbaru = JadwalPenimbangan::with('desa')
            ->latest('tgl_jadwal')
            ->take(5)
            ->get();

        $kontenTerbaru = Konten::with('media')
            ->latest('created_at')
            ->take(3)
            ->get();

        return view(
            'admin-pusat.dashboard',
            compact(
                'totalSampah',
                'totalKategori',
                'sampahAktif',
                'totalJadwal',
                'jadwalTerbaru',
                'kontenTerbaru'
            )
        );
    }
}

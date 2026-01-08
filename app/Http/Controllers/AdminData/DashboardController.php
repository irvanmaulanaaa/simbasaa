<?php

namespace App\Http\Controllers\AdminData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Konten;
use App\Models\User;
use Illuminate\Support\Facades\DB; // <--- PENTING: Tambahkan ini untuk fungsi hitung chart

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Total (Kode Lama Anda)
        $totalKecamatan = Kecamatan::count();
        $totalDesa = Desa::count();
        $totalKonten = Konten::count();
        $totalUsers = User::count();

        // 2. Data untuk Grafik Status Konten (BARU)
        // Menghitung jumlah konten dikelompokkan berdasarkan status_id
        $kontenStatus = Konten::select('status_id', DB::raw('count(*) as total'))
            ->groupBy('status_id')
            ->with('status') // Memuat relasi status agar bisa ambil nama statusnya
            ->get();

        // Memisahkan Nama Status (Labels) dan Jumlahnya (Data) untuk dikirim ke JS
        $chartLabels = $kontenStatus->map(fn($item) => $item->status->nama_status ?? 'Unknown')->toArray();
        $chartData = $kontenStatus->pluck('total')->toArray();

        // 3. Data Konten Terbaru (BARU)
        // Mengambil 5 konten terakhir yang diinput
        $recentKonten = Konten::with(['user', 'status']) // Eager load user & status biar ringan
            ->latest() // Urutkan dari yang terbaru
            ->take(5)  // Ambil cuma 5
            ->get();

        return view('admin-data.dashboard', compact(
            'totalKecamatan',
            'totalDesa',
            'totalKonten',
            'totalUsers',
            'chartLabels',  // Kirim data chart
            'chartData',    
            'recentKonten'  
        ));
    }
}
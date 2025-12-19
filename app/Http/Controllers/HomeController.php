<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konten;
use App\Models\Komentar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function index()
    {
        $kontens = Konten::with('media')
            ->whereHas('status', fn($q) => $q->where('nama_status', 'published'))
            ->latest()->take(3)->get();
        return view('welcome', compact('kontens'));
    }

    public function allContent(Request $request)
    {
        $query = Konten::with('media')
            ->whereHas('status', fn($q) => $q->where('nama_status', 'published'));

        if ($request->has('cari')) {
            $query->where('judul', 'like', '%' . $request->cari . '%');
        }

        $filter = $request->get('filter', 'terbaru'); 
        
        if ($filter == 'terlama') {
            $query->oldest();
        } elseif ($filter == 'populer') {
            $query->orderBy('jumlah_like', 'desc'); 
        } else {
            $query->latest();
        }

        $kontens = $query->paginate(9)->withQueryString();

        return view('public.konten.index', compact('kontens'));
    }

    public function show($id)
    {
        $konten = Konten::with(['media', 'komentars.user', 'user'])->findOrFail($id);
        
        $beritaLain = Konten::with('media')
            ->where('id_konten', '!=', $id)
            ->whereHas('status', fn($q) => $q->where('nama_status', 'published'))
            ->latest()->take(4)->get();

        return view('public.konten.show', compact('konten', 'beritaLain'));
    }

    public function like($id)
    {
        $sessionKey = 'liked_konten_' . $id;

        if (!Session::has($sessionKey)) {
            $konten = Konten::findOrFail($id);
            $konten->increment('jumlah_like');
            Session::put($sessionKey, true);
            
            return response()->json([
                'status' => 'success', 
                'likes' => $konten->jumlah_like,
                'message' => 'Terima kasih atas apresiasinya!'
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Anda sudah menyukai konten ini.']);
    }

    public function comment(Request $request, $id)
    {
        $request->validate([
            'isi_komentar' => 'required|string|max:500'
        ]);

        Komentar::create([
            'konten_id' => $id,
            'user_id' => Auth::id(),
            'isi_komentar' => $request->isi_komentar
        ]);

        return back()->with('success', 'Komentar berhasil dikirim.');
    }
}
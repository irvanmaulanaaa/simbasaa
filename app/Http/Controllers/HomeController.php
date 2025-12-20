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

        $sessionKey = 'liked_konten_' . $id;
        $isLiked = Session::has($sessionKey);

        $beritaLain = Konten::with('media')
            ->where('id_konten', '!=', $id)
            ->whereHas('status', fn($q) => $q->where('nama_status', 'published'))
            ->latest()->take(4)->get();

        return view('public.konten.show', compact('konten', 'beritaLain', 'isLiked'));
    }

    public function like($id)
    {
        $sessionKey = 'liked_konten_' . $id;
        $konten = Konten::findOrFail($id);

        if (Session::has($sessionKey)) {
            $konten->decrement('jumlah_like');
            Session::forget($sessionKey);
            $status = 'unliked';
            $message = 'Batal menyukai konten.';
        } else {
            $konten->increment('jumlah_like');
            Session::put($sessionKey, true);
            $status = 'liked';
            $message = 'Terima kasih atas apresiasinya!';
        }

        return response()->json([
            'status' => $status,
            'likes' => $konten->jumlah_like,
            'message' => $message
        ]);
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

    public function updateComment(Request $request, $id)
    {
        $request->validate(['isi_komentar' => 'required|string|max:500']);

        $komentar = Komentar::where('id_komentar', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $komentar->update(['isi_komentar' => $request->isi_komentar]);

        return back()->with('success', 'Komentar berhasil diperbarui.');
    }

    public function deleteComment($id)
    {
        $komentar = Komentar::where('id_komentar', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $komentar->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
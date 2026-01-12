<?php

namespace App\Http\Controllers;

use App\Models\KategoriKonten;
use Illuminate\Http\Request;
use App\Models\Konten;
use App\Models\Komentar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Like;
use App\Models\User;
use App\Models\Penarikan;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function index()
    {
        $totalUser = User::whereHas('role', fn($q) => $q->where('nama_role', 'warga'))->count();

        $totalSampah = 1250; 

        $totalKonten = Konten::whereHas('status', fn($q) => $q->where('nama_status', 'published'))->count();

        if (class_exists(Penarikan::class)) {
             $totalDanaCair = Penarikan::where('status', 'disetujui')->sum('jumlah');
        } else {
             $totalDanaCair = 2500000;
        }

        $kontens = Konten::with(['media', 'user', 'kategoriKonten'])
            ->whereHas('status', fn($q) => $q->where('nama_status', 'published'))
            ->latest()
            ->take(10)
            ->get();

        return view('welcome', compact('kontens', 'totalUser', 'totalSampah', 'totalKonten', 'totalDanaCair'));
    }

    public function allContent(Request $request)
    {
        $query = Konten::with('media', 'user', 'kategoriKonten')
            ->whereHas('status', fn($q) => $q->where('nama_status', 'published'));

        if ($request->has('cari')) {
            $query->where('judul', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
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

        $kategori_konten = KategoriKonten::all();

        return view('public.konten.index', compact('kontens', 'kategori_konten'));
    }

    public function show($id)
    {
        $konten = Konten::with(['media', 'komentars.user', 'user', 'kategoriKonten'])->findOrFail($id);

        if (Auth::check()) {
            $isLiked = Like::where('user_id', Auth::id())->where('id_konten', $id)->exists();
        } else {
            $isLiked = session()->has('liked_konten_' . $id);
        }

        $beritaLain = Konten::with('media', 'user', 'kategoriKonten')
            ->where('id_konten', '!=', $id)
            ->whereHas('status', fn($q) => $q->where('nama_status', 'published'))
            ->latest()->take(4)->get();

        return view('public.konten.show', compact('konten', 'beritaLain', 'isLiked'));
    }

    public function like($id)
    {
        $konten = Konten::findOrFail($id);
        $status = 'liked';
        $message = '';

        if (Auth::check()) {
            $existingLike = Like::where('user_id', Auth::id())->where('id_konten', $id)->first();

            if ($existingLike) {
                $existingLike->delete();
                $konten->decrement('jumlah_like');
                $status = 'unliked';
                $message = 'Batal menyukai konten.';
            } else {
                Like::create([
                    'user_id' => Auth::user()->id_user,
                    'id_konten' => $id
                ]);
                $konten->increment('jumlah_like');
                $message = 'Terima kasih atas apresiasinya!';
            }
        } else {
            $sessionKey = 'liked_konten_' . $id;
            if (session()->has($sessionKey)) {
                $konten->decrement('jumlah_like');
                session()->forget($sessionKey);
                $status = 'unliked';
                $message = 'Batal menyukai konten.';
            } else {
                $konten->increment('jumlah_like');
                session()->put($sessionKey, true);
                $message = 'Terima kasih atas apresiasinya!';
            }
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
<?php

namespace App\Http\Controllers\AdminData;

use App\Http\Controllers\Controller;
use App\Models\Konten;
use App\Models\StatusKonten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KontenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kontens = Konten::with(['user', 'status'])->latest()->paginate(10);
        return view('admin-data.konten.index', compact('kontens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = StatusKonten::all();
        return view('admin-data.konten.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status_id' => 'required|exists:status_konten,id_status',
            'media_type' => 'required|in:upload,url',
            'media_file' => 'nullable|required_if:media_type,upload|image|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
            'media_url' => 'nullable|required_if:media_type,url|url:https',
        ]);

        $konten = Konten::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status_id' => $request->status_id,
            'user_id' => Auth::id(),
        ]);

        if ($request->media_type == 'upload' && $request->hasFile('media_file')) {
            $path = $request->file('media_file')->store('konten', 'public');

            $konten->media()->create([
                'gambar' => $path
            ]);

        } elseif ($request->media_type == 'url' && $request->filled('media_url')) {
            $konten->media()->create([
                'gambar' => $request->media_url
            ]);
        }

        return redirect()->route('admin-data.konten.index')
            ->with('success', 'Konten berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Konten $konten)
    {
        $konten->load(['user', 'status', 'media']);
        return view('admin-data.konten.show', compact('konten'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Konten $konten)
    {
        $konten->load('media');
        $statuses = StatusKonten::all();

        $currentMedia = $konten->media->first();
        $mediaType = 'upload';
        $mediaValue = '';
        if ($currentMedia) {
            if (filter_var($currentMedia->gambar, FILTER_VALIDATE_URL)) {
                $mediaType = 'url';
                $mediaValue = $currentMedia->gambar;
            } else {
                $mediaType = 'upload';
                $mediaValue = $currentMedia->gambar;
            }
        }

        return view('admin-data.konten.edit', compact('konten', 'statuses', 'mediaType', 'mediaValue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Konten $konten)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status_id' => 'required|exists:status_konten,id_status',
            'media_type' => 'required|in:upload,url',
            'media_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
            'media_url' => 'nullable|url:https',
        ]);

        $konten->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status_id' => $request->status_id,
        ]);

        $currentMedia = $konten->media->first();

        if ($request->media_type == 'upload' && $request->hasFile('media_file')) {
            if ($currentMedia && !filter_var($currentMedia->gambar, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($currentMedia->gambar);
            }
            $path = $request->file('media_file')->store('konten', 'public');
            $konten->media()->updateOrCreate(
                ['konten_id' => $konten->id_konten],
                ['gambar' => $path]
            );

        } elseif ($request->media_type == 'url' && $request->filled('media_url')) {
            if ($currentMedia && !filter_var($currentMedia->gambar, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($currentMedia->gambar);
            }
            $konten->media()->updateOrCreate(
                ['konten_id' => $konten->id_konten],
                ['gambar' => $request->media_url]
            );
        }

        return redirect()->route('admin-data.konten.index')
            ->with('success', 'Konten berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Konten $konten)
    {
        foreach ($konten->media as $media) {
        if (!filter_var($media->gambar, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($media->gambar);
        }
    }

    $konten->media()->delete(); 

    $konten->delete(); 

    return redirect()->route('admin-data.konten.index')
                     ->with('success', 'Konten berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\AdminPusat;

use App\Http\Controllers\Controller;
use App\Models\JadwalPenimbangan;
use App\Models\Desa;
use App\Models\User;
use App\Models\Kecamatan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JadwalPenimbanganController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalPenimbangan::with('desa');

        if ($request->filled('search_driver')) {
            $query->where('nama_driver', 'like', '%' . $request->search_driver . '%');
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tgl_jadwal', [$request->start_date, $request->end_date]);
        }

        $perPage = $request->input('per_page', 10);

        $jadwals = $query->with(['desa.kecamatan'])
            ->latest('tgl_jadwal')
            ->paginate($perPage)
            ->withQueryString();

        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();

        return view('admin-pusat.jadwal.index', compact('jadwals', 'kecamatans'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();
        return view('admin-pusat.jadwal.create', compact('kecamatans'));
    }

    public function getDesasByKecamatan($kecamatanId)
    {
        $desas = Desa::where('kecamatan_id', $kecamatanId)
            ->orderBy('nama_desa')
            ->get(['id_desa', 'nama_desa']);
        return response()->json($desas);
    }

    public function getRwsByDesa($desaId)
    {
        $rws = User::where('desa_id', $desaId)
            ->whereNotNull('rw')
            ->select('rw')
            ->distinct()
            ->orderBy('rw')
            ->get();

        return response()->json($rws);
    }

    public function store(Request $request)
    {
        $request->validate([
            'desa_id' => 'required|exists:desa,id_desa',
            'rw_penimbangan' => 'required|string|max:5',
            'nama_driver' => 'required|string|max:100',
            'tgl_jadwal' => 'required|date',
            'jam_penimbangan' => 'required',
        ]);

        $jadwal = JadwalPenimbangan::create([
            'user_id' => Auth::id(),
            'desa_id' => $request->desa_id,
            'rw_penimbangan' => $request->rw_penimbangan,
            'nama_driver' => $request->nama_driver,
            'tgl_jadwal' => $request->tgl_jadwal,
            'jam_penimbangan' => $request->jam_penimbangan,
        ]);

        $desa = Desa::with('kecamatan')->findOrFail($request->desa_id);

        Notifikasi::create([
            'jadwal_id' => $jadwal->id_jadwal,
            'judul' => "Penimbangan Sampah di RW " . $request->rw_penimbangan . "\n" . "Driver: " . $request->nama_driver,
            'tgl_kegiatan' => $request->tgl_jadwal,
            'jam_kegiatan' => $request->jam_penimbangan,
            'desa_kegiatan' => $desa->nama_desa,
            'kecamatan_kegiatan' => $desa->kecamatan->nama_kecamatan ?? '-',
            'kab_kota' => $desa->kecamatan->kab_kota ?? 'Kab. Bandung',
            'rw_kegiatan' => $request->rw_penimbangan,
        ]);

        return redirect()->route('admin-pusat.jadwal.index')
            ->with('success', 'Jadwal berhasil dibuat.');
    }

    public function edit($id)
    {
        $jadwal = JadwalPenimbangan::with(['desa.kecamatan'])->findOrFail($id);
        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();

        $desas = Desa::where('kecamatan_id', $jadwal->desa->kecamatan_id)
            ->orderBy('nama_desa')
            ->get();

        $rws = User::where('desa_id', $jadwal->desa_id)
            ->whereNotNull('rw')
            ->select('rw')
            ->distinct()
            ->orderBy('rw')
            ->get();

        return view('admin-pusat.jadwal.edit', compact('jadwal', 'kecamatans', 'desas', 'rws'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'desa_id' => 'required|exists:desa,id_desa',
            'rw_penimbangan' => 'required|string|max:5',
            'nama_driver' => 'required|string|max:100',
            'tgl_jadwal' => 'required|date',
            'jam_penimbangan' => 'required',
        ]);

        $jadwal = JadwalPenimbangan::findOrFail($id);

        $jadwal->update([
            'desa_id' => $request->desa_id,
            'rw_penimbangan' => $request->rw_penimbangan,
            'nama_driver' => $request->nama_driver,
            'tgl_jadwal' => $request->tgl_jadwal,
            'jam_penimbangan' => $request->jam_penimbangan,
        ]);

        $desaBaru = Desa::with('kecamatan')->findOrFail($request->desa_id);

        $notif = Notifikasi::where('jadwal_id', $jadwal->id_jadwal)->first();

        if ($notif) {
            $notif->update([
                'judul' => "Update: Penimbangan Sampah di RW " . $request->rw_penimbangan . "\n" . "Driver: " . $request->nama_driver,
                'tgl_kegiatan' => $request->tgl_jadwal,
                'jam_kegiatan' => $request->jam_penimbangan,
                'desa_kegiatan' => $desaBaru->nama_desa,
                'kecamatan_kegiatan' => $desaBaru->kecamatan->nama_kecamatan ?? '-',
                'kab_kota' => $desaBaru->kecamatan->kab_kota ?? 'Kab. Bandung',
                'rw_kegiatan' => $request->rw_penimbangan,
            ]);

            DB::table('notifikasi_status')
                ->where('notifikasi_id', $notif->id_notif)
                ->update(['read_at' => null]);
        }

        return redirect()->route('admin-pusat.jadwal.index')
            ->with('success', 'Jadwal diperbarui. Notifikasi warga telah di-reset menjadi belum dibaca.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalPenimbangan::findOrFail($id);

        Notifikasi::where('jadwal_id', $jadwal->id_jadwal)->delete();

        $jadwal->delete();

        return redirect()->route('admin-pusat.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}

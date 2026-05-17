<!DOCTYPE html>
<html>
<head>
    <title>E-Statement Penarikan Saldo</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        
        .kop-surat { width: 100%; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; border-collapse: collapse; }
        .kop-surat td { border: none; padding: 0; background-color: transparent; vertical-align: middle; }
        .kop-surat .logo { width: 15%; text-align: left; }
        .kop-surat .teks { width: 70%; text-align: center; }
        .kop-surat .kosong { width: 15%; }
        .kop-surat h2 { font-size: 18px; margin: 0; font-weight: bold; }
        .kop-surat h3 { font-size: 14px; margin: 5px 0; }
        
        .profil-nasabah { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .profil-nasabah td { padding: 4px; border: none; font-size: 12px; }
        .kotak-saldo { background-color: #dcfce7; border: 1px solid #16a34a; padding: 10px; border-radius: 5px; text-align: center; }
        .kotak-saldo h4 { margin: 0; color: #166534; font-size: 11px; text-transform: uppercase; }
        .kotak-saldo h2 { margin: 5px 0 0 0; color: #16a34a; font-size: 20px; }

        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data-table th, table.data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table.data-table th { background-color: #f4f4f4; text-align: center; font-size: 11px; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge { padding: 3px 6px; border-radius: 3px; font-weight: bold; font-size: 9px; }
        
        .bg-green { color: #166534; background-color: #dcfce7; }
        .bg-blue { color: #1e3a8a; background-color: #dbeafe; }
        .bg-yellow { color: #854d0e; background-color: #fef9c3; }
        .bg-red { color: #991b1b; background-color: #fee2e2; }
    </style>
</head>
<body>

    @php
        $imagePath = public_path('images/logosimbasa.png');
        $base64Logo = '';
        if(file_exists($imagePath)) {
            $type = pathinfo($imagePath, PATHINFO_EXTENSION);
            $data = file_get_contents($imagePath);
            $base64Logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    @endphp

    <table class="kop-surat">
        <tr>
            <td class="logo">
                @if($base64Logo)
                    <img src="{{ $base64Logo }}" style="width: 75px; height: auto;" alt="Logo SIMBASA">
                @endif
            </td>
            <td class="teks">
                <h2>BANK SAMPAH KABUPATEN BANDUNG (SIMBASA)</h2>
                <h3>E-STATEMENT / BUKU TABUNGAN NASABAH</h3>
                <p>Periode: {{ $request->start_date ?? 'Awal' }} s/d {{ $request->end_date ?? 'Sekarang' }}</p>
            </td>
            <td class="kosong"></td>
        </tr>
    </table>

    <table class="profil-nasabah">
        <tr>
            <td width="15%"><strong>Nama Nasabah</strong></td>
            <td width="2%">:</td>
            <td width="48%">{{ $user->nama_lengkap }} ({{ $user->username }})</td>
            <td width="35%" rowspan="3" style="vertical-align: top;">
                <div class="kotak-saldo">
                    <h4>Sisa Saldo Tabungan</h4>
                    <h2>Rp {{ number_format($saldo, 0, ',', '.') }}</h2>
                </div>
            </td>
        </tr>
        <tr>
            <td><strong>RT / RW</strong></td>
            <td>:</td>
            <td>RT {{ str_pad($user->rt ?? 0, 2, '0', STR_PAD_LEFT) }} / RW {{ str_pad($user->rw ?? 0, 2, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td style="vertical-align: top;"><strong>Desa / Kec</strong></td>
            <td style="vertical-align: top;">:</td>
            <td style="vertical-align: top;">Desa {{ $user->desa->nama_desa ?? '-' }}, Kec. {{ $user->desa->kecamatan->nama_kecamatan ?? '-' }}</td>
        </tr>
    </table>

    <h4 style="margin-bottom: 5px;">Riwayat Penarikan Saldo:</h4>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tgl Request</th>
                <th width="20%">Nominal (Rp)</th>
                <th width="15%">Status</th>
                <th width="15%">Tgl Selesai</th>
                <th width="30%">Keterangan Ditolak</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tgl_request)->format('d-m-Y') }}</td>
                <td class="text-right"><strong>{{ number_format($item->jumlah, 0, ',', '.') }}</strong></td>
                <td class="text-center">
                    @if($item->status == 'selesai') <span class="badge bg-green">SELESAI</span>
                    @elseif($item->status == 'disetujui') <span class="badge bg-blue">SIAP DIAMBIL</span>
                    @elseif($item->status == 'pending') <span class="badge bg-yellow">PENDING</span>
                    @else <span class="badge bg-red">DITOLAK</span> @endif
                </td>
                <td class="text-center">
                    {{ $item->tgl_selesai ? \Carbon\Carbon::parse($item->tgl_selesai)->format('d-m-Y') : '-' }}
                </td>
                <td style="font-size: 10px;">{{ $item->status == 'ditolak' ? ($item->catatan_ketua ?? '-') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada riwayat penarikan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 10px; color: #666; font-style: italic;">
        * Dokumen ini di-generate secara otomatis oleh sistem SIMBASA dan sah sebagai bukti riwayat mutasi.
    </div>

</body>
</html>
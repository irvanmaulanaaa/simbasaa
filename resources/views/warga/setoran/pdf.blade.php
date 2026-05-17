<!DOCTYPE html>
<html>
<head>
    <title>E-Statement Setoran Sampah</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        
        .kop-surat { width: 100%; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; border-collapse: collapse; }
        .kop-surat td { border: none; padding: 0; background-color: transparent; vertical-align: middle; }
        .kop-surat .logo { width: 15%; text-align: left; }
        .kop-surat .teks { width: 70%; text-align: center; }
        .kop-surat .kosong { width: 15%; }
        .kop-surat h2 { font-size: 18px; margin: 0; font-weight: bold; }
        .kop-surat h3 { font-size: 14px; margin: 5px 0; }
        
        .info-panel { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-panel td { padding: 4px; border: none; vertical-align: top; }
        
        .kotak-rekap { border: 1px solid #16a34a; background-color: #dcfce7; padding: 10px; border-radius: 5px; text-align: center; margin-bottom: 5px; }
        .kotak-rekap h4 { margin: 0; color: #166534; font-size: 11px; text-transform: uppercase; }
        .kotak-rekap h2 { margin: 3px 0 0 0; color: #16a34a; font-size: 18px; }

        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data-table th, table.data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; vertical-align: top;}
        table.data-table th { background-color: #f4f4f4; text-align: center; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; background-color: #e2f0d9; }
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
                <h3>E-STATEMENT RIWAYAT SETORAN SAMPAH</h3>
                <p>Periode: {{ $request->start_date ?? 'Awal' }} s/d {{ $request->end_date ?? 'Sekarang' }}</p>
            </td>
            <td class="kosong"></td>
        </tr>
    </table>

    <table class="info-panel">
        <tr>
            <td width="40%">
                <table width="100%">
                    <tr><td width="30%"><strong>Nasabah</strong></td><td>: {{ $user->nama_lengkap }} ({{ $user->username }})</td></tr>
                    <tr><td><strong>RT / RW</strong></td><td>: RT {{ str_pad($user->rt ?? 0, 2, '0', STR_PAD_LEFT) }} / RW {{ str_pad($user->rw ?? 0, 2, '0', STR_PAD_LEFT) }}</td></tr>
                    <tr><td><strong>Lokasi</strong></td><td>: Desa {{ $user->desa->nama_desa ?? '-' }}, Kec. {{ $user->desa->kecamatan->nama_kecamatan ?? '-' }}</td></tr>
                </table>
            </td>
            <td width="30%">
                <div class="kotak-rekap">
                    <h4>Total Sampah Disetor</h4>
                    <h2>{{ number_format($totalKg, 2) }} Kg @if($totalPcs > 0) / {{ number_format($totalPcs, 0) }} Pcs @endif</h2>
                </div>
            </td>
            <td width="30%">
                <div class="kotak-rekap">
                    <h4>Sisa Saldo Tabungan</h4>
                    <h2>Rp {{ number_format($saldoSaatIni, 0, ',', '.') }}</h2>
                </div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal Setor</th>
                <th width="60%">Rincian Sampah Disetor (Item | Berat | Harga | Subtotal)</th>
                <th width="20%">Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($setorans as $index => $setoran)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($setoran->tgl_setor)->format('d-m-Y') }}</td>
                <td>
                    <ul style="margin: 0; padding-left: 15px; font-size:11px;">
                        @foreach($setoran->detail as $detail)
                            @php
                                $hargaPerSatuan = $detail->subtotal / $detail->berat;
                            @endphp
                            <li>
                                <strong>{{ $detail->sampah->nama_sampah ?? 'Sampah Terhapus' }}</strong> : 
                                {{ (float)$detail->berat }} {{ $detail->sampah->UOM ?? 'Kg' }} 
                                (Rp {{ number_format($hargaPerSatuan, 0, ',', '.') }}/{{ $detail->sampah->UOM ?? 'Kg' }}) 
                                = Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </li>
                        @endforeach
                    </ul>
                </td>
                <td class="text-right"><strong>Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada riwayat setoran pada periode ini.</td>
            </tr>
            @endforelse
            <tr class="total-row">
                <td colspan="3" class="text-right">TOTAL PENDAPATAN DARI SETORAN :</td>
                <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 10px; color: #666; font-style: italic;">
        * Dokumen ini di-generate secara otomatis oleh sistem SIMBASA dan sah sebagai bukti riwayat setoran nasabah.
    </div>

</body>
</html>

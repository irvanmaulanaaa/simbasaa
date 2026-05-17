<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penarikan Saldo</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; } /* Ukuran font dikecilkan sedikit agar muat banyak kolom */
        .header { position: relative; text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2, .header h3, .header p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f4f4f4; text-align: center; font-size: 10px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row { font-weight: bold; background-color: #e2f0d9; }
        .footer-note { margin-top: 30px; font-size: 10px; color: #555; font-style: italic; }
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

    <div class="header">
        @if($base64Logo)
            <img src="{{ $base64Logo }}" style="position: absolute; top: 0; left: 10px; width: 75px; height: auto;" alt="Logo SIMBASA">
        @endif

        <h2>BANK SAMPAH UNIT RW {{ str_pad($ketua->rw, 2, '0', STR_PAD_LEFT) }}</h2>
        <h3>Laporan Mutasi Penarikan Saldo Warga</h3>
        <p>
            RT / RW: {{ $ketua->rt ? str_pad($ketua->rt, 2, '0', STR_PAD_LEFT) : '-' }} / {{ str_pad($ketua->rw, 2, '0', STR_PAD_LEFT) }}<br>
            Desa: {{ $ketua->desa->nama_desa ?? '-' }}, 
            Kecamatan: {{ $ketua->desa->kecamatan->nama_kecamatan ?? '-' }}, 
            {{ $ketua->desa->kecamatan->kab_kota ?? 'Kabupaten Bandung' }}
        </p>
        @if($request->start_date && $request->end_date)
            <p>Periode: {{ \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">Tgl Request</th>
                <th width="18%">Nama Warga</th>
                <th width="4%">RT</th>
                <th width="15%">Nominal (Rp)</th>
                <th width="12%">Status</th>
                <th width="15%">ACC Ketua</th>
                <th width="12%">Tgl Selesai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penarikans as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($p->tgl_request)->format('d-m-Y') }}</td>
                <td>{{ $p->warga->nama_lengkap ?? '-' }}</td>
                <td class="text-center">{{ str_pad($p->warga->rt, 2, '0', STR_PAD_LEFT) ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                <td class="text-center">{{ strtoupper($p->status) }}</td>
                <td class="text-center">{{ $p->ketua->nama_lengkap ?? '-' }}</td>
                <td class="text-center">
                    {{ $p->tgl_selesai ? \Carbon\Carbon::parse($p->tgl_selesai)->format('d-m-Y') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
            
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL PENARIKAN (SELESAI)</td>
                <td class="text-right">Rp {{ number_format($totalPenarikan, 0, ',', '.') }}</td>
                <td colspan="3"></td> 
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; border: none; margin-top: 40px;">
        <tr style="border: none;">
            <td style="border: none; width: 65%;"></td>
            <td style="border: none; text-align: center; width: 35%;">
                <p>Bandung, {{ date('d F Y') }}</p>
                <p>Ketua BSU RW {{ str_pad($ketua->rw, 2, '0', STR_PAD_LEFT) }}</p>
                <br><br><br><br>
                <p><strong><u>{{ strtoupper($ketua->nama_lengkap) }}</u></strong></p>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        * Keterangan: BSU = Bank Sampah Unit
    </div>

</body>
</html>
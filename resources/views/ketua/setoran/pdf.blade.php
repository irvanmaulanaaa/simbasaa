<!DOCTYPE html>
<html>
<head>
    <title>Laporan Setoran Sampah</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { position: relative; text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2, .header h3, .header p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; text-align: center; }
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
        <h3>Laporan Riwayat Setoran Sampah Warga</h3>
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
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Nama Warga</th>
                <th width="5%">RT</th>
                <th width="40%">Rincian Sampah (Item / Berat / Subtotal)</th>
                <th width="15%">Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($setorans as $index => $setoran)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($setoran->tgl_setor)->format('d-m-Y') }}</td>
                <td>{{ $setoran->warga->nama_lengkap ?? '-' }}</td>
                <td class="text-center">{{ str_pad($setoran->warga->rt, 2, '0', STR_PAD_LEFT) ?? '-' }}</td>
                <td>
                    <ul style="margin: 0; padding-left: 15px;">
                        @foreach($setoran->detail as $detail)
                            <li>{{ $detail->sampah->nama_sampah ?? '-' }} : {{ (float)$detail->berat }} {{ $detail->sampah->UOM ?? 'Kg' }} (Rp {{ number_format($detail->subtotal, 0, ',', '.') }})</li>
                        @endforeach
                    </ul>
                </td>
                <td class="text-right">Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
            
            <tr class="total-row">
                <td colspan="5" class="text-right">TOTAL KESELURUHAN PENDAPATAN</td>
                <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
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
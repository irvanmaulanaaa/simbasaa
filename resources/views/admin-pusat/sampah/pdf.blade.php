<!DOCTYPE html>
<html>
<head>
    <title>Master Data Sampah</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        .header { position: relative; text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2, .header h3, .header p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #f4f4f4; text-align: center; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge { padding: 2px 5px; border-radius: 3px; font-weight: bold; font-size: 9px; }
        .bg-green { background-color: #dcfce7; color: #166534; }
        .bg-red { background-color: #fee2e2; color: #991b1b; }
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

        <h2>BANK SAMPAH KABUPATEN BANDUNG (SIMBASA)</h2>
        <h3>MASTER DATA JENIS & HARGA SAMPAH</h3>
        <p>Dicetak pada: {{ date('d F Y - H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">Kode</th>
                <th width="10%">Kode BSB</th>
                <th width="15%">Nama Sampah</th>
                <th width="12%">Kategori</th>
                <th width="5%">UOM</th>
                <th width="10%">Harga Anggota</th>
                <th width="10%">Harga BSB</th>
                <th width="20%">Deskripsi</th>
                <th width="5%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sampahs as $index => $s)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center"><strong>{{ $s->kode_sampah }}</strong></td>
                <td class="text-center">{{ $s->kode_bsb ?? '-' }}</td>
                <td><strong>{{ $s->nama_sampah }}</strong></td>
                <td class="text-center">{{ $s->kategori->nama_kategori ?? '-' }}</td>
                <td class="text-center">{{ strtoupper($s->UOM) }}</td>
                <td class="text-right text-green-600">Rp {{ number_format($s->harga_anggota, 0, ',', '.') }}</td>
                <td class="text-right text-blue-600">Rp {{ number_format($s->harga_bsb, 0, ',', '.') }}</td>
                <td>{{ $s->deskripsi ?? '-' }}</td>
                <td class="text-center">
                    @if($s->status_sampah == 'aktif') <span class="badge bg-green">AKTIF</span>
                    @else <span class="badge bg-red">NONAKTIF</span> @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">Belum ada data sampah.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table style="width: 100%; border: none; margin-top: 30px;">
        <tr style="border: none;">
            <td style="border: none; width: 65%;"></td>
            <td style="border: none; text-align: center; width: 35%;">
                <p>Bandung, {{ date('d F Y') }}</p>
                <p>Administrator BSB</p>
                <br><br><br>
                <p><strong><u>{{ strtoupper($admin->nama_lengkap) }}</u></strong></p>
            </td>
        </tr>
    </table>

</body>
</html>
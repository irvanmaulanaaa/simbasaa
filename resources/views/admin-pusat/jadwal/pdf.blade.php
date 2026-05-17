<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Penimbangan Sampah</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        
        .kop-surat { width: 100%; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; border-collapse: collapse; }
        .kop-surat td { border: none; padding: 0; background-color: transparent; vertical-align: middle; }
        .kop-surat .logo { width: 15%; text-align: left; }
        .kop-surat .teks { width: 70%; text-align: center; }
        .kop-surat .kosong { width: 15%; } 
        .kop-surat h2, .kop-surat h3, .kop-surat p { margin: 2px 0; }

        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data-table th, table.data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table.data-table th { background-color: #f4f4f4; text-align: center; }
        
        .text-center { text-align: center; }
        .badge { padding: 3px 6px; border-radius: 3px; font-weight: bold; font-size: 10px; }
        .bg-green { background-color: #dcfce7; color: #166534; }
        .bg-yellow { background-color: #fef9c3; color: #854d0e; }
        .bg-blue { background-color: #dbeafe; color: #1e40af; }
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
                <h2>BANK SAMPAH BERSINAR KABUPATEN BANDUNG</h2>
                <h3>SURAT TUGAS / JADWAL PENIMBANGAN</h3>
                @if($request->start_date && $request->end_date)
                    <p>Periode: {{ \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}</p>
                @endif
                @if($request->search_driver)
                    <p>Driver: {{ $request->search_driver }}</p>
                @endif
            </td>
            <td class="kosong"></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Hari, Tanggal</th>
                <th width="10%">Jam</th>
                <th width="20%">Nama Driver</th>
                <th width="30%">Lokasi (RW & Desa)</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jadwals as $index => $j)
                @php
                    $tgl = \Carbon\Carbon::parse($j->tgl_jadwal);
                    $isToday = $tgl->isToday();
                    $isPast = $tgl->isPast() && !$isToday;
                @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $tgl->translatedFormat('l, d F Y') }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($j->jam_penimbangan)->format('H:i') }} WIB</td>
                <td><strong>{{ $j->nama_driver }}</strong></td>
                <td>
                    RW {{ str_pad($j->rw_penimbangan, 2, '0', STR_PAD_LEFT) }}, Desa {{ $j->desa->nama_desa ?? '-' }}<br>
                    <span style="font-size:10px; color:gray;">Kec. {{ $j->desa->kecamatan->nama_kecamatan ?? '-' }}</span>
                </td>
                <td class="text-center">
                    @if($isToday) <span class="badge bg-green">HARI INI</span>
                    @elseif($isPast) <span class="badge bg-blue">SELESAI</span>
                    @else <span class="badge bg-yellow">AKAN DATANG</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data jadwal.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table style="width: 100%; border: none; margin-top: 40px;">
        <tr style="border: none;">
            <td style="border: none; text-align: center; width: 33%;">
                <p>Mengetahui,</p>
                <p>Koordinator Lapangan</p>
                <br><br><br>
                <p>_______________________</p>
            </td>
            <td style="border: none; width: 33%;"></td>
            <td style="border: none; text-align: center; width: 33%;">
                <p>Bandung, {{ date('d F Y') }}</p>
                <p>Admin BSB</p>
                <br><br><br>
                <p><strong><u>{{ strtoupper($admin->nama_lengkap) }}</u></strong></p>
            </td>
        </tr>
    </table>

</body>
</html>
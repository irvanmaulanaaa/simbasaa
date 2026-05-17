<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Pengguna</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; } 
        .header { position: relative; text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2, .header h3, .header p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
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

        <h2>SISTEM INFORMASI MANAJEMEN BANK SAMPAH (SIMBASA)</h2>
        <h3>LAPORAN DATA PENGGUNA TERDAFTAR</h3>
        <p>Dicetak pada: {{ date('d F Y - H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="15%">Nama Lengkap</th>
                <th width="10%">Role</th>
                <th width="10%">No. Telp</th>
                <th width="30%">Alamat Lengkap</th>
                <th width="10%">RT / RW</th>
                <th width="7%">Status</th>
                <th width="15%">Saldo Warga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $u)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $u->nama_lengkap }} <br><span style="color:gray; font-size:9px;">({{ $u->username }})</span></td>
                <td class="text-center">{{ strtoupper($u->role->nama_role ?? '-') }}</td>
                <td class="text-center">{{ $u->no_telepon ?? '-' }}</td>
                <td>
                    {{ $u->jalan ?? '-' }}<br>
                    Ds. {{ $u->desa->nama_desa ?? '-' }}, Kec. {{ $u->desa->kecamatan->nama_kecamatan ?? '-' }}, {{ $u->desa->kecamatan->kab_kota ?? 'Kabupaten Bandung' }}
                </td>
                <td class="text-center">{{ str_pad($u->rt ?? 0, 2, '0', STR_PAD_LEFT) }} / {{ str_pad($u->rw ?? 0, 2, '0', STR_PAD_LEFT) }}</td>
                <td class="text-center">
                    @if($u->status == 'aktif') <span class="badge bg-green">AKTIF</span>
                    @else <span class="badge bg-red">NONAKTIF</span> @endif
                </td>
                <td class="text-right">
                    @if($u->role && $u->role->nama_role == 'warga')
                        Rp {{ number_format($u->saldo->jumlah_saldo ?? 0, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data pengguna yang ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table style="width: 100%; border: none; margin-top: 30px;">
        <tr style="border: none;">
            <td style="border: none; width: 65%;"></td>
            <td style="border: none; text-align: center; width: 35%;">
                <p>Bandung, {{ date('d F Y') }}</p>
                <p>Administrator SIMBASA</p>
                <br><br><br>
                <p><strong><u>{{ strtoupper($admin->nama_lengkap) }}</u></strong></p>
            </td>
        </tr>
    </table>

</body>
</html>

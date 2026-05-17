<?php

namespace App\Exports;

use App\Models\Setoran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SetoranExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $ketua = Auth::user();
        
        $query = Setoran::with(['warga', 'detail.sampah'])
            ->where(function ($q) use ($ketua) {
                $q->where('ketua_id', $ketua->id_user)
                    ->orWhereHas('warga', function ($subQ) use ($ketua) {
                        $subQ->where('desa_id', $ketua->desa_id)->where('rw', $ketua->rw);
                    });
            });

        if ($this->request->filled('search')) {
            $query->whereHas('warga', function ($q) {
                $q->where('nama_lengkap', 'like', "%{$this->request->search}%");
            });
        }
        if ($this->request->filled('rt')) {
            $query->whereHas('warga', function ($q) {
                $q->where('rt', $this->request->rt);
            });
        }
        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $query->whereBetween('tgl_setor', [$this->request->start_date, $this->request->end_date]);
        }

        return $query->latest('tgl_setor')->get();
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Tanggal Setor',
            'Nama Warga',
            'RT',
            'Total Pendapatan (Rp)',
            'Rincian Sampah (Jenis - Berat - Subtotal)'
        ];
    }

    public function map($setoran): array
    {
        $rincian = [];
        foreach($setoran->detail as $dt) {
            $nama = $dt->sampah->nama_sampah ?? '-';
            $berat = floatval($dt->berat) . ' ' . ($dt->sampah->UOM ?? 'Kg');
            $sub = 'Rp ' . number_format($dt->subtotal, 0, ',', '.');
            $rincian[] = $nama . ' (' . $berat . ') = ' . $sub;
        }

        return [
            $setoran->id_setor,
            \Carbon\Carbon::parse($setoran->tgl_setor)->format('d/m/Y'),
            $setoran->warga->nama_lengkap ?? '-',
            str_pad($setoran->warga->rt, 2, '0', STR_PAD_LEFT) ?? '-', 
            $setoran->total_harga,
            implode(" || ", $rincian)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $cellRange = 'A1:' . $highestColumn . $highestRow;

        return [
            1 => [
                'font' => [
                    'bold' => true, 
                    'color' => ['argb' => 'FF000000'] 
                ], 
                'fill' => [
                    'fillType' => Fill::FILL_SOLID, 
                    'startColor' => ['argb' => 'FF4CAF50'] 
                ]
            ],

            $cellRange => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'], 
                    ],
                ],
            ],
        ];
    }
}
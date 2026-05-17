<?php

namespace App\Exports;

use App\Models\Penarikan;
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

class PenarikanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $ketua = Auth::user();

        $query = Penarikan::with('warga', 'ketua')
            ->whereHas('warga', function ($q) use ($ketua) {
                $q->where('desa_id', $ketua->desa_id)
                    ->where('rw', $ketua->rw);
            });

        if ($this->request->filled('search')) {
            $query->whereHas('warga', function ($q) {
                $q->where('nama_lengkap', 'like', "%{$this->request->search}%");
            });
        }
        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }
        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $query->whereBetween('tgl_request', [
                $this->request->start_date . ' 00:00:00',
                $this->request->end_date . ' 23:59:59'
            ]);
        }

        return $query->latest('tgl_request')->get();
    }

    public function headings(): array
    {
        return [
            'ID Tarik',
            'Tanggal Request',
            'Nama Warga',
            'RT',
            'Nominal Penarikan (Rp)',
            'Status',
            'ACC Ketua',
            'Tanggal Selesai'
        ];
    }

    public function map($penarikan): array
    {
        $namaWarga = $penarikan->warga ? $penarikan->warga->nama_lengkap : '-';
        $rtWarga = ($penarikan->warga && $penarikan->warga->rt) ? str_pad($penarikan->warga->rt, 2, '0', STR_PAD_LEFT) : '-';
        $namaKetua = $penarikan->ketua ? $penarikan->ketua->nama_lengkap : '-';
        
        $tglSelesai = $penarikan->tgl_selesai ? \Carbon\Carbon::parse($penarikan->tgl_selesai)->format('d/m/Y H:i') : '-';

        return [
            $penarikan->id_tarik,
            \Carbon\Carbon::parse($penarikan->tgl_request)->format('d/m/Y H:i'),
            $namaWarga,
            $rtWarga,
            $penarikan->jumlah,
            strtoupper($penarikan->status),
            $namaKetua,
            $tglSelesai
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $cellRange = 'A1:' . $highestColumn . $highestRow;

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']], 
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2563EB']]
            ],
            $cellRange => [
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']]],
            ],
        ];
    }
}
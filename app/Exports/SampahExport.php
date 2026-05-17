<?php

namespace App\Exports;

use App\Models\Sampah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SampahExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Sampah::with('kategori');

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_sampah', 'like', "%{$search}%")
                    ->orWhere('kode_bsb', 'like', "%{$search}%")
                    ->orWhere('kode_sampah', 'like', "%{$search}%");
            });
        }
        if ($this->request->filled('kategori_id')) {
            $query->where('kategori_id', $this->request->kategori_id);
        }
        if ($this->request->filled('status')) {
            $query->where('status_sampah', $this->request->status);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Kode Sampah',
            'Kode BSB',
            'Nama Sampah',
            'Kategori',
            'Satuan',
            'Harga Anggota (Rp)',
            'Harga BSB (Rp)',
            'Status',
            'Deskripsi'
        ];
    }

    public function map($sampah): array
    {
        return [
            $sampah->kode_sampah,
            $sampah->kode_bsb ?? '-',
            $sampah->nama_sampah,
            $sampah->kategori ? $sampah->kategori->nama_kategori : '-',
            strtoupper($sampah->UOM),
            $sampah->harga_anggota,
            $sampah->harga_bsb,
            strtoupper($sampah->status_sampah),
            $sampah->deskripsi ?? '-'
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
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF166534']] 
            ],
            $cellRange => [
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']]],
            ],
        ];
    }
}

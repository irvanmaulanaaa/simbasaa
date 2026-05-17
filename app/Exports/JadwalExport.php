<?php

namespace App\Exports;

use App\Models\JadwalPenimbangan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class JadwalExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = JadwalPenimbangan::with('desa.kecamatan');

        if ($this->request->filled('search_driver')) {
            $query->where('nama_driver', 'like', '%' . $this->request->search_driver . '%');
        }

        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $query->whereBetween('tgl_jadwal', [$this->request->start_date, $this->request->end_date]);
        }

        return $query->latest('tgl_jadwal')->get();
    }

    public function headings(): array
    {
        return [
            'ID Jadwal',
            'Tanggal Penimbangan',
            'Jam (WIB)',
            'Nama Driver',
            'Lokasi (RW)',
            'Desa',
            'Kecamatan',
            'Status'
        ];
    }

    public function map($jadwal): array
    {
        $tgl = Carbon::parse($jadwal->tgl_jadwal);
        $status = $tgl->isPast() && !$tgl->isToday() ? 'SELESAI' : ($tgl->isToday() ? 'HARI INI' : 'AKAN DATANG');

        return [
            $jadwal->id_jadwal,
            $tgl->translatedFormat('l, d F Y'),
            Carbon::parse($jadwal->jam_penimbangan)->format('H:i'),
            $jadwal->nama_driver,
            str_pad($jadwal->rw_penimbangan, 2, '0', STR_PAD_LEFT),
            $jadwal->desa->nama_desa ?? '-',
            $jadwal->desa->kecamatan->nama_kecamatan ?? '-',
            $status
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $cellRange = 'A1:' . $highestColumn . $highestRow;

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FF000000']], 
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFACC15']] 
            ],
            $cellRange => [
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']]],
            ],
        ];
    }
}

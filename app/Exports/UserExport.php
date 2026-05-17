<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class UserExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = User::with(['role', 'desa.kecamatan', 'saldo'])
            ->when($this->request->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_lengkap', 'like', '%' . $this->request->search . '%')
                        ->orWhere('username', 'like', '%' . $this->request->search . '%');
                });
            })
            ->when($this->request->role, function ($query) {
                $query->where('role_id', $this->request->role);
            })
            ->when($this->request->status, function ($query) {
                $query->where('status', $this->request->status);
            });

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID User',
            'Nama Lengkap',
            'Username',
            'Role',
            'No Telepon',
            'Alamat Lengkap',
            'RT / RW',
            'Status',
            'Saldo Tabungan (Rp)' 
        ];
    }

   public function map($user): array
    {
        $alamat = '-';
        if ($user->desa) {
            $kecamatan = $user->desa->kecamatan->nama_kecamatan ?? '';
            $kabupaten = $user->desa->kecamatan->kab_kota ?? 'Kabupaten Bandung';
            $alamat = $user->jalan . ', Desa ' . $user->desa->nama_desa . ', Kec. ' . $kecamatan . ', ' . $kabupaten;
        }

        $rt = str_pad($user->rt ?? 0, 2, '0', STR_PAD_LEFT);
        $rw = str_pad($user->rw ?? 0, 2, '0', STR_PAD_LEFT);
        
        $saldo = '-';
        if ($user->role && $user->role->nama_role == 'warga' && $user->saldo) {
            $saldo = $user->saldo->jumlah_saldo;
        }

        return [
            $user->id_user,
            $user->nama_lengkap,
            $user->username,
            $user->role ? strtoupper($user->role->nama_role) : '-',
            $user->no_telepon ?? '-',
            $alamat,
            $rt . ' / ' . $rw,
            strtoupper($user->status),
            $saldo
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
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF4F46E5']]
            ],
            $cellRange => [
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']]],
            ],
        ];
    }
}

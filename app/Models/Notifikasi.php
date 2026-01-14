<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NotifikasiStatus;

class Notifikasi extends Model
{
    use HasFactory;
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notif';
    protected $fillable = [
        'jadwal_id',
        'judul',
        'tgl_kegiatan',
        'jam_kegiatan',
        'kecamatan_kegiatan',
        'kab_kota',
        'desa_kegiatan',
        'rw_kegiatan'
    ];

    public function statuses()
    {
        return $this->hasMany(NotifikasiStatus::class, 'notifikasi_id', 'id_notif');
    }
}
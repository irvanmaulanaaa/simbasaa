<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notif';
    protected $fillable = [
        'judul', 'tgl_kegiatan', 'jam_kegiatan', 'kecamatan_kegiatan', 
        'kab_kota', 'desa_kegiatan', 'rw_kegiatan'
    ];
}
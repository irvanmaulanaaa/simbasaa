<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sampah extends Model
{
    use HasFactory;
    protected $table = 'sampah';
    protected $primaryKey = 'id_sampah';

    protected $fillable = [
        'kategori_id',
        'diinput_oleh',
        'harga_diupdate_oleh',
        'nama_sampah',
        'kode_sampah',
        'kode_bsb',
        'harga_anggota',
        'harga_bsb',
        'UOM',
        'status_sampah',
        'tgl_nonaktif',
        'deskripsi'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSampah::class, 'kategori_id', 'id_kategori');
    }

    public function diinputOleh()
    {
        return $this->belongsTo(User::class, 'diinput_oleh', 'id_user');
    }

    public function hargaDiupdateOleh()
    {
        return $this->belongsTo(User::class, 'harga_diupdate_oleh', 'id_user');
    }
}
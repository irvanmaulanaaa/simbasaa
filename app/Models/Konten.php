<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    use HasFactory;
    protected $table = 'konten';
    protected $primaryKey = 'id_konten';

    protected $fillable = [
        'judul',
        'deskripsi',
        'status_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function status()
    {
        return $this->belongsTo(StatusKonten::class, 'status_id', 'id_status');
    }

    public function media()
    {
        return $this->hasMany(MediaKonten::class, 'konten_id', 'id_konten');
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class, 'konten_id', 'id_konten');
    }
}
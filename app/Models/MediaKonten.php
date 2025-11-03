<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaKonten extends Model
{
    use HasFactory;
    protected $table = 'media_konten';
    protected $primaryKey = 'id_media';

    protected $fillable = ['konten_id', 'gambar'];

    public function konten()
    {
        return $this->belongsTo(Konten::class, 'konten_id', 'id_konten');
    }
}
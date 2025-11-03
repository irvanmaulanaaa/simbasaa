<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusKonten extends Model
{
    use HasFactory;
    protected $table = 'status_konten';
    protected $primaryKey = 'id_status';
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifikasiStatus extends Model
{
    protected $table = 'notifikasi_status';
    protected $fillable = ['user_id', 'notifikasi_id', 'read_at', 'deleted_at'];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gajiCustom extends Model
{
    protected $table = 'gaji_custom';
    protected $fillable = ['id', 'pengajar', 'tanggal', 'keterangan', 'status', 'history_gaji_id', 'created_at', 'updated_at'];
}

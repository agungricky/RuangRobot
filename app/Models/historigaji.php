<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class historigaji extends Model
{
    protected $table = 'history_gaji';
    protected $fillable = [
        'id',
        'tanggal_terbayar',
        'created_at',
        'updated_at',
    ];
}

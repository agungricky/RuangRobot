<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gajiCustom extends Model
{
    protected $table = 'gaji_custom';
    protected $fillable = [
        'id',
        'pengajar',
        'tanggal',
        'keterangan',
        'nominal',
        'status',
        'history_gaji_id',
        'created_at',
        'updated_at'
    ];

    public function pengguna(){
        return $this->belongsTo(pengguna::class, 'pengajar', 'id');
    }

    public function history_gaji(){
        return $this->belongsTo(historigaji::class, 'history_gaji_id', 'id');
    }
}

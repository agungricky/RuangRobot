<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gajiTransport extends Model
{
    protected $table = 'transport';
    protected $fillable = [
        'id',
        'pengajar',
        'nominal',
        'status',
        'status_pengajar',
        'pembelajaran_id',
        'history_gaji_id',
        'created_at',
        'updated_at'
    ];

    public function pengguna(){
        return $this->belongsTo(pengguna::class, 'pengajar', 'id');
    }

    public function pembelajaran(){
        return $this->belongsTo(pembelajaran::class, 'pembelajaran_id', 'id');
    }

    public function history_gaji(){
        return $this->belongsTo(historigaji::class, 'history_gaji_id', 'id');
    }
}

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

    public function gajiUtama(){
        return $this->hasMany(gajiUtama::class, 'history_gaji_id', 'id');
    }

    public function gajiTransport(){
        return $this->hasMany(gajiTransport::class, 'history_gaji_id', 'id');
    }

    public function gajiCustom(){
        return $this->hasMany(gajiCustom::class, 'history_gaji_id', 'id');
    }
}

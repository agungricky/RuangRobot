<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class riwayatPembayaran extends Model
{
    protected $table = 'riwayat_pembayarans';
    protected $fillable = [
        'id',
        'nama',
        'kelas_id',
        'nominal',
        'tanggal',
        'jenis_pembayaran',
        'metode_pembayaran',
        'created_at',
        'updated_at',
    ];

    public function pengguna(){
        return $this->belongsTo(pengguna::class, 'nama', 'id');
    }

    public function kelas(){
        return $this->belongsTo(kelas::class, 'kelas_id', 'id');
    }
}

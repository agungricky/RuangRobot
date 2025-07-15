<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pembelajaran extends Model
{
    protected $table = 'pembelajaran';
    protected $fillable = [
        'id',
        'kode_pertemuan',
        'pengajar',
        'tanggal',
        'materi',
        'catatan_pengajar',
        'absensi',
        'status_tersimpan',
        'kelas_id',
        'created_at',
        'updated_at',
    ];

    public function kelas(){
        return $this->belongsTo(kelas::class, 'kelas_id' , 'id');
    }

    public function pengajar(){
        return $this->belongsTo(pengguna::class, 'pengajar' , 'id');
    }

    public function gaji_utama(){
        return $this->hasMany(gajiUtama::class, 'pembelajaran_id', 'id');
    }

    public function gaji_transport(){
        return $this->hasMany(gajiTransport::class, 'pembelajaran_id', 'id');
    }
}

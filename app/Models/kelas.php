<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = [
        'id',
        'nama_kelas',
        'kode_kelas',
        'harga',
        'durasi_belajar',
        'program_belajar_id',
        'kategori_kelas_id',
        'penanggung_jawab',
        'gaji_pengajar',
        'gaji_transport',
        'status_kelas',
        'jatuh_tempo',
        'created_at',
        'updated_at'
    ];
    
    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_kelas_id', 'id');
    }

    public function program_belajar(){
        return $this->belongsTo(programbelajar::class, 'program_belajar_id', 'id');
    }

    public function pengajar(){
        return $this->belongsTo(pengguna::class, 'penanggung_jawab', 'id');
    }

    public function pembelajaran(){
        return $this->hasMany(pembelajaran::class, 'kelas_id', 'id');
    }

    public function murid_kelas(){
        return $this->hasMany(muridKelas::class, 'kelas_id', 'id');
    }

    public function riwayat_pembayaran(){
        return $this->hasMany(riwayatPembayaran::class, 'kelas_id', 'id');
    }

    public function invoice(){
        return $this->hasMany(invoice::class, 'kelas_id', 'id');
    }

}

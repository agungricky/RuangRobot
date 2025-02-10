<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = [
        'id',
        'nama_kelas',
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

    public function program_belajar()
    {
        return $this->belongsTo(programbelajar::class, 'program_belajar_id');
    }

    public function kategori_kelas()
    {
        return $this->belongsTo(Kategori::class, 'kategori_kelas_id');
    }

    public function pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class, 'kelas_id', 'id');
    }

    //Noted:
    //menggunakan hasMany karena satu kelas bisa memiliki banyak pembelajaran (tabel pembelajaran adalah foreign tabel) 
}

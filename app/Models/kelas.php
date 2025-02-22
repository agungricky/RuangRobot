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
}

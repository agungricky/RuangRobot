<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = ['id','nama_kelas','durasi_belajar', 'program_belajar_id', 'jenis_kelas_id','penanggung_jawab',
    'gaji_pengajar','gaji_transport','status_kelas','created_at','updated_at'];
}

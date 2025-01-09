<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = ['id','nama_kelas','durasi_belajar', 'jenis_kelas','gaji_pengajar','gaji_transport','status_kelas','created_at','updated_at','program_belajar_id'];
}

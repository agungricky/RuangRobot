<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class programbelajar extends Model
{
    protected $table = 'program_belajar';
    protected $fillable = ['id', 'nama_program', 'harga', 'deskripsi', 'level', 'Jenis_kelas_id','mekanik', 'elektronik', 'pemrograman', 'created_at', 'updated_at'];
}

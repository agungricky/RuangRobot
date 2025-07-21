<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class programbelajar extends Model
{
    protected $table = 'program_belajar';
    protected $fillable = ['id', 'nama_program', 'deskripsi', 'level', 'tipe_kelas_id','mekanik', 'elektronik', 'pemrograman', 'created_at', 'updated_at'];

    public function kelas(){
        return $this->hasMany(kelas::class, 'program_belajar_id', 'id')->orderBy('tanggal', 'asc');
    }

    public function tipe_kelas(){
        return $this->belongsTo(Tipekelas::class, 'tipe_kelas_id', 'id');
    }
}



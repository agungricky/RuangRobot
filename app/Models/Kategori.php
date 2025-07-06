<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori_kelas';
    protected $fillable = ['id', 'kategori_kelas', 'color_bg'];
    public $timestamps = false;

    public function indexPendaftaran(){
        return $this->hasMany(indexPendaftaran::class, 'kategori_id', 'id');
    }

    public function kelas(){
        return $this->hasMany(kelas::class, 'kategori_kelas_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sekolah extends Model
{
    protected $table = 'sekolah';
    protected $fillable = ['nama_sekolah', 'guru', 'no_hp'];
    public $timestamps = false;


    public function pendaftaran(){
        return $this->hasMany(pendaftaran::class, 'sekolah_id', 'id');
    }

    public function pengguna(){
        return $this->hasMany(pengguna::class, 'sekolah_id', 'id');
    }
}

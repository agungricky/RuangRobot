<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengguna extends Model
{
    protected $table = 'profile';
    protected $fillable = ['id', 'nama', 'email', 'alamat', 'no_telp', 'sekolah_id', 'mekanik', 'elektronik', 'pemrograman'];
    public $timestamps = false;


    public function akun()
    {
        return $this->belongsTo(akun::class, 'id', 'id');
    }

    public function Kelas()
    {
        return $this->hasMany(kelas::class, 'penanggung_jawab', 'id');
    }
}

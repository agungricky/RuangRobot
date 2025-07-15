<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengguna extends Model
{
    protected $table = 'profile';
    protected $fillable = [
        'id',
        'nama',
        'email',
        'alamat',
        'no_telp',
        'sekolah_id',
        'kelas',
        'mekanik',
        'elektronik',
        'pemrograman'
    ];
    public $timestamps = false;


    public function akun()
    {
        return $this->belongsTo(akun::class, 'id', 'id');
    }

    public function Kelas()
    {
        return $this->hasMany(kelas::class, 'penanggung_jawab', 'id');
    }

    public function pembelajaran()
    {
        return $this->hasMany(pembelajaran::class, 'pengajar', 'id');
    }

    public function sekolah()
    {
        return $this->belongsTo(sekolah::class, 'sekolah_id', 'id');
    }
}

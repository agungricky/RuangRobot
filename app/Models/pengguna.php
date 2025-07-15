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
        'tgl_lahir',
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

    public function gaji_utama(){
        return $this->hasMany(gajiUtama::class, 'pengajar', 'id');
    }

    public function gaji_transport(){
        return $this->hasMany(gajiTransport::class, 'pengajar', 'id');
    }

    public function gaji_custom(){
        return $this->hasMany(gajiCustom::class, 'pengajar', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pendaftaran extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'pendaftaran';
    protected $fillable = [
        'code_id',
        'nama',
        'tgl_lahir',
        'email',
        'no_telp',
        'sekolah_id',
        'kelas',
        'alamat',
        'kategori',
        'created_at',
        'updated_at'
    ];

    public function indexPendaftaran(){
        return $this->belongsTo(indexPendaftaran::class, 'code_id', 'code');
    }

    public function sekolah(){
        return $this->belongsTo(sekolah::class, 'sekolah_id', 'id');
    }
}

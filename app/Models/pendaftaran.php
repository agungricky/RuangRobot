<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pendaftaran extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'pendaftaran';
    protected $fillable = [
        'nama',
        'email',
        'no_telp',
        'sekolah_id',
        'kelas',
        'alamat',
        'kategori',
        'created_at',
        'updated_at'
    ];
}

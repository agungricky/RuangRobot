<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pembelajaran extends Model
{
    protected $table = 'pembelajaran';
    protected $fillable = [
        'id',
        'pertemuan',
        'pengajar',
        'tanggal',
        'materi',
        'catatan_pengajar',
        'absensi',
        'status_tersimpan',
        'kelas_id',
        'created_at',
        'updated_at',
    ];

    public function kelas()
    {
        return $this->belongsTo(kelas::class, 'kelas_id','id');
    }

    //noted : id adalah primary key dari tabel kelas sedangkan kelas_id adalaah fk dari tabel pembelajaran
}

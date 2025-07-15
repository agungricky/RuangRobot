<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class indexPendaftaran extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'index_pendaftarans';
    protected $fillable = [
        'id',
        'title',
        'kategori_id',
        'code',
        'link_form',
        'link_group',
        'tanggal_p_awal',
        'tanggal_p_akhir',
        'status_pendaftaran',
        'created_at',
        'updated_at'
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function pendaftaran(){
        return $this->hasMany(pendaftaran::class, 'code_id', 'code');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class muridKelas extends Model
{
    protected $table = 'murid_kelas';
    protected $fillable = [
        'murid',
        'kelas_id',
    ];

    public $timestamps = false;

    public function kelas(){
        return $this->belongsTo(kelas::class, 'kelas_id', 'id');
    }
}

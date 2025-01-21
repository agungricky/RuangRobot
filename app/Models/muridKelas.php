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
}

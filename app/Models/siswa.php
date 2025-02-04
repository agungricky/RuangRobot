<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    protected $table = 'murid_kelas';
    protected $fillable = ['id', 'murid', 'kelas_id'];

}

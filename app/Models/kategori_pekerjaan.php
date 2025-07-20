<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategori_pekerjaan extends Model
{
    protected $table = 'kategori_pekerjaans';
    protected $fillable = ['nama_pekerjaan', 'keterangan', 'gaji'];
}

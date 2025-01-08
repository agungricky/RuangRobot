<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sekolah extends Model
{
    protected $table = 'sekolah';
    protected $fillable = ['nama_sekolah'];
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori_kelas';
    protected $fillable = ['id', 'kategori_kelas'];
    public $timestamps = false;
}

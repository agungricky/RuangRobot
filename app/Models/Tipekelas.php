<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipekelas extends Model
{
    protected $table = 'tipe_kelas';
    protected $fillable = ['id', 'nama_kategori'];
}

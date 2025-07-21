<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipekelas extends Model
{
    protected $table = 'tipe_kelas';
    protected $fillable = ['id', 'tipe_kelas'];
    public $timestamps = false;

    public function program_belajar(){
        return $this->hasMany(programbelajar::class, 'tipe_kelas_id', 'id');
    }
}

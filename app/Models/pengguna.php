<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengguna extends Model
{
    protected $table = 'profile';
    protected $fillable = ['id','nama','email','alamat','no_telp'];
}

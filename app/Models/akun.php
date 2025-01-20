<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class akun extends Model
{
    protected $table = 'akun';
    protected $fillable = ['id', 'username', 'password', 'role', 'created_at', 'updated_at'];
}

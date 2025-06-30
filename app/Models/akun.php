<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class akun extends Model
{
    protected $table = 'akun';
    protected $fillable = ['id', 'username', 'password', 'role', 'remeber_token', 'created_at', 'updated_at'];

    public function pengguna()
    {
        return $this->hasOne(pengguna::class, 'id', 'id');
    }
}

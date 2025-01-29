<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    protected $table = 'invoice';
    protected $fillable = ['id', 'profile_id', 'kelas_id', 'created_at', 'updated_at'];
}

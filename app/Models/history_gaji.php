<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class history_gaji extends Model
{
    protected $table = 'history_gaji';
    protected $fillable = ['id', 'taggal_bayar'];

    public function gajiUtama()
    {
        return $this->hasMany(gajiUtama::class, 'history_gaji_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gajiTransport extends Model
{
    protected $table = 'transport';
    protected $fillable = ['id', 'pengajar', 'nominal', 'status', 'status_pengajar', 'pembelajaran_id', 'history_gaji_id', 'created_at', 'updated_at'];
}

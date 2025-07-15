<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gajiUtama extends Model
{
    protected $table = 'gajis';
    protected $fillable = ['id', 'pengajar', 'nominal', 'status', 'status_pengajar', 'pembelajaran_id', 'history_gaji_id', 'created_at', 'updated_at'];

    public function history_gaji()
    {
        return $this->belongsTo(history_gaji::class, 'history_gaji_id');
    }

    public function pengguna(){
        return $this->belongsTo(pengguna::class, 'pengajar', 'id');
    }

    public function pembelajaran(){
        return $this->belongsTo(pembelajaran::class, 'pembelajaran_id', 'id');
    }
}

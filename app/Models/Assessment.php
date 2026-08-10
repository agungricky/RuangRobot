<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'author_id',
        'idreport',
        'kelas_id', 	
        'pemahaman', 	
        'keterampilan', 	
        'keamanan', 	
        'antusiasme',
        'percaya_diri'
    ];

    public function kelas()
    {
        return $this->belongsTo(kelas::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}

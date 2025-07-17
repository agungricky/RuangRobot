<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indexkeuangan extends Model
{
    protected $table = 'indexkeuangans';
    protected $fillable = [
        'id',
        'kesimpulan',
        'created_at',
        'updated_at'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class keuangan extends Model
{
    protected $table = 'keuangan';
    protected $fillable = [
        'id',
        'indexkeuangan_id',
        'tipe',
        'keterangan',
        'tanggal',
        'nominal',
        'saldo_akhir',
        'metode_pembayaran',
    ];
    public $timestamps = false;
}

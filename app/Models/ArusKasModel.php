<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArusKasModel extends Model
{
    use HasFactory;

    protected $table = "arus_kas";
    protected $fillable = [
        'uuid',
        'tgl_transaksi',
        'keterangan',
        'no_ref',
        'debet',
        'kredit',
        'kategori_transaksi',
        'id_user'
    ];
}

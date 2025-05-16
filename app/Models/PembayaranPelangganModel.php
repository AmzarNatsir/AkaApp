<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranPelangganModel extends Model
{
    use HasFactory;
    protected $table = "pembayaran_pelanggan";
    protected $fillable = [
        'tgl_bayar',
        'id_pelanggan',
        'id_pemasangan',
        'tgl_jtp',
        'nominal',
        'id_user',
        'status'
    ];
}

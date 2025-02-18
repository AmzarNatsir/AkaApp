<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabangModel extends Model
{
    use HasFactory;
    protected $table = "cabang";
    protected $fillable = [
        'kode',
        'nama_cabang',
        'alamat',
        'aktif',
        'stok_awal',
        'stok_akhir'
    ];
}

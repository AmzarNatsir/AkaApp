<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganModel extends Model
{
    use HasFactory;
    protected $table = 'pelanggan';
    protected $fillable = [
        "nama_pelanggan",
        "alamat",
        "no_telepon_1",
        "no_telepon_2",
        "wilayah",
        "paket_internet",
        "status"
    ];
}

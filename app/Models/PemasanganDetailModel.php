<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemasanganDetailModel extends Model
{
    use HasFactory;
    protected $table = "pemasangan_detail";
    protected $fillable = [
        "id_pelanggan",
        "id_pemakaian",
        "sn_ont",
        "model_ont",
        "odp",
        "tikor_odp",
        "tikor_pelanggan",
        "port",
        "port_ifle",
        "splitter",
        "kabel_dc",
        "tgl_aktivasi",
        "gambar_rumah",
        "gambar_odp",
        "gambar_ont_terpasang",
        "gambar_belakang_ont",
        "gambar_redaman_odp",
        "gambar_redaman_rumah_pelanggan",
        "gambar_lainnya",
        "user_id",
        "metode_bayar"
    ];

}

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
        "status",
        "aktif",
        "tgl_completed",
        "tgl_finished",
        "tgl_submit_cancel",
        "keterangan_cancel",
        "tgl_canceled",
        "user_canceled"
    ];

    public function getWilayah()
    {
        return $this->belongsTo(WilayahModel::class, 'wilayah', 'id');
    }
    public function getPaket()
    {
        return $this->belongsTo(PaketInternetModel::class, 'paket_internet', 'id');
    }
}

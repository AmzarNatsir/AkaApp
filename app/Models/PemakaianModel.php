<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemakaianModel extends Model
{
    use HasFactory;
    protected $table = "pemakaian";
    protected $fillable = [
        "tanggal",
        "kategori_id",
        "wilayah_id",
        "petugas_id",
        "keterangan",
        "user_id",
        "gudang_id",
        "id_pelanggan",
        "petugas"
    ];

    public function getKategori()
    {
        $arr = array("1" => "Pemesangan Baru", "2" => "Pengembangan", "3" => "Maintanance - Perbaikan", "4" => "Maintanance - Penggantian");
        return $arr;
    }

    public function getWilayah()
    {
        return $this->belongsTo(WilayahModel::class, 'wilayah_id', 'id');
    }

    public function getPetugas()
    {
        return $this->belongsTo(PetugasModel::class, 'petugas_id', 'id');
    }
}

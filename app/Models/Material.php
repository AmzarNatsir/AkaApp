<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Material extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        "material",
        "harga_beli",
        "jumlah",
        "satuan_id",
        "merek_id",
        "gambar",
        "path_gambar",
        "stok_awal",
        "stok_akhir",
        "deskripsi"
    ];

    public function getMerek()
    {
        return $this->belongsTo(Merek::class, 'merek_id', 'id');
    }

    public function getSatuan()
    {
        return $this->belongsTo(SatuanModel::class, 'satuan_id', 'id');
    }
}

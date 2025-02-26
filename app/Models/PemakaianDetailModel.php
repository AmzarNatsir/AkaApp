<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemakaianDetailModel extends Model
{
    use HasFactory;
    protected $table = "pemakaian_detail";
    protected $fillable = [
        "head_id",
        "material_id",
        "jumlah",
        "harga",
        "gudang_id"
    ];

    public function getMaterial()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
}

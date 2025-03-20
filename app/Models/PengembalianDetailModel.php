<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianDetailModel extends Model
{
    use HasFactory;

    protected $table = "pengembalian_detail";
    protected $fillable = [
        "head_id",
        "material_id",
        "jumlah",
        "gudang_id"
    ];

    public function getHeader()
    {
        return $this->belongsTo(PengembalianModel::class, 'head_id', 'id');
    }

    public function getMaterial()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
}

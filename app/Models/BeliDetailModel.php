<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeliDetailModel extends Model
{
    use HasFactory;

    protected $table = "beli_detail";
    protected $fillable = [
        "header_id",
        "material_id",
        "harga",
        "jumlah",
        "sub_total"
    ];

    public function getMaterial()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
}

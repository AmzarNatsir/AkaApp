<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherHeadModel extends Model
{
    use HasFactory;
    protected $table = "voucher_head";
    protected $fillable = [
        "bulan",
        "tahun",
        "agen_id",
        "status",
        "total_voucher",
        "total_modal",
        "total_laba",
        "user_id"
    ];

    public function getAgen()
    {
        return $this->belongsTo(AgenVoucherModel::class, 'agen_id', 'id');
    }
}

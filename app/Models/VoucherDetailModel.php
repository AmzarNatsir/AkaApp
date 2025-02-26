<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherDetailModel extends Model
{
    use HasFactory;
    protected $table = "voucher_detail";
    protected $fillable = [
        "head_id",
        "voucher_id",
        "nama_voucher",
        "harga_modal",
        "harga_jual",
        "stok_awal",
        'stok_tambahan',
        "stok_terjual"
    ];
}

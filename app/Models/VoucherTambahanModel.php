<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherTambahanModel extends Model
{
    use HasFactory;
    protected $table = "voucher_head";
    protected $fillable = [
        "head_id",
        "detail_id",
        "tanggal",
        "stok_tambahan"
    ];
}

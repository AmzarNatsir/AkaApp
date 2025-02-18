<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherModel extends Model
{
    use HasFactory;
    protected $table = "voucher";
    protected $fillable = [
        'nama_voucher',
        'harga_modal',
        'harga_jual',
        'aktif'
    ];
}

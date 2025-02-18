<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgenVoucherModel extends Model
{
    use HasFactory;
    protected $table = "agen_voucher";
    protected $fillable = [
        "nama_agen",
        "alamat",
        "no_telepon",
        "kontak_person",
        "aktif"
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianModel extends Model
{
    use HasFactory;

    protected $table = "pengembalian";
    protected $fillable = [
        "tanggal",
        "keterangan",
        "user_id",
        "gudang_id"
    ];

}

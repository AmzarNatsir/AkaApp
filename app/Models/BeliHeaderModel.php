<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeliHeaderModel extends Model
{
    use HasFactory;

    protected $table = "beli_header";
    protected $fillable = [
        "nomor",
        "tanggal",
        "keterangan",
        "total",
        "user_id",
        "status"
    ];
}

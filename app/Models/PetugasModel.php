<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasModel extends Model
{
    use HasFactory;
    protected $table = "petugas";
    protected $fillable = [
        "nama_petugas",
        "tempat_lahir",
        "tanggal_lahir",
        "jenkel",
        "alamat",
        "no_telpon",
        "photo",
        "photo_path",
        "no_identitas",
        "tanggal_bergabung",
        "aktif"
    ];
}

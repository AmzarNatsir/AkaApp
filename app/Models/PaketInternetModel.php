<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketInternetModel extends Model
{
    use HasFactory;

    protected $table = 'paket_internet';
    protected $fillable = [
        'nama_paket',
        'harga',
        'aktif'
    ];

}

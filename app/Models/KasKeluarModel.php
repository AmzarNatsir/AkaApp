<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasKeluarModel extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $table = "kas_keluar";
    protected $fillable = [
        'uuid',
        "tgl_transaksi",
        "no_transaksi",
        "keterangan",
        "nominal",
        "id_user",
        "evidence"
    ];

    protected function evidence(): Attribute {
        return Attribute::make(
            get: fn ($image) => url('/storage/kaskeluar/'.$image),
        );
    }
}

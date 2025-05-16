<?php

namespace App\Imports;

use App\Models\PelangganModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PelangganImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        // \Log::info('Row imported: ', $row); // cek storage/logs/laravel.log
        // Pastikan key sesuai header dan lowercase!
        $phone = $row['phone'] ?? null;
        $nama  = $row['nama_pelanggan'] ?? null;
        $alamat = $row['alamat'] ?? null;

        // Skip jika nama_pelanggan kosong
        if (!$nama) return null;
        $checkDuplicate = PelangganModel::where('no_telepon_1', $phone)->count();

        if ($checkDuplicate == 0) {
            return new PelangganModel([
                'nama_pelanggan' => $nama,
                'no_telepon_1'   => $phone,
                'alamat'         => $alamat,
                'aktif'          => 'y',
            ]);
        }

        return null; // penting untuk skip baris jika duplikat
    }
}

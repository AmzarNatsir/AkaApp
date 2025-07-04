<?php

namespace App\Traits;

use App\Models\PemasanganDetailModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait General
{

    public static function getListMonth()
    {
        $arr_month = array(
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );
        return $arr_month;
    }

    public static function get_nama_bulan($bln)
    {
        $arr_month = array(
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );
        foreach($arr_month as $key => $value)
        {
            if($key==$bln)
            {
                $ket_bulan = $value;
                break;
            }
        }
        return $ket_bulan;
    }

    public static function get_kategori_pemakaian_material($id)
    {
        $arr_kategori = array(
            "1" => "Pemesangan Baru",
            "2" => "Pengembangan",
            "3" => "Maintanance - Perbaikan",
            "4" => "Maintanance - Penggantian"
        );
        foreach($arr_kategori as $key => $value)
        {
            if($key==$id)
            {
                return $value;
                break;
            }
        }
    }

    public static function upload_gambar($file, $folder, $nom)
    {
        try {
            $path = storage_path("app/public/".$folder);
            if(!File::isDirectory($path)) {
                $path = Storage::disk('public')->makeDirectory($folder);
            }
            $image = $file;
            $fileName = $nom."_".time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs("public/" . $folder, $fileName);
            return $fileName;
        } catch (\Throwable $th)
        {
            report($th);
            return $th->getMessage();
        }
    }

    public static function handleNewFileUpload($request, $fileKey, $folder, $urutan) {
        if ($request->hasFile($fileKey)) {
            return General::upload_gambar($request->file($fileKey), $folder, $urutan);
        }
        return null;
    }
    public static function handleFileUpload($request, $fileKey, $tmpKey, $folder, $urutan) {
        if ($request->hasFile($fileKey)) {
            if (!empty($request->$tmpKey)) {
                General::hapus_file_gambar($folder, $request->$tmpKey);
            }
            return General::upload_gambar($request->file($fileKey), $folder, $urutan);
        }
        return (!empty($request->$tmpKey)) ? $request->$tmpKey : null;
    }

    public static function hapus_file_gambar($folder, $file)
    {
        Storage::delete('public/'.$folder.'/'.$file);
    }
}

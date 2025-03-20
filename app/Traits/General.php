<?php

namespace App\Traits;

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
}

<?php

namespace App\Traits;

use App\Models\BeliHeaderModel;
use App\Models\KasKeluarModel;
use App\Models\KasMasukModel;

trait GenerateNumber
{
    public static function genNumber($category, $date) {
        $newNumber = "";
        $currentYear = substr($date, 0, 4);
        $currentMonth = substr($date, 5, 2);
        if($category=='pembelian')
        {
            $firstNumber = $currentYear.sprintf('%02s', $currentMonth);
            $nom = 1;
            $result = BeliHeaderModel::whereYear('tanggal',  $currentYear)->orderBy('nomor', 'desc')->first();
            if(empty($result->nomor)) {
                $newNumber = $firstNumber.sprintf('%03s', $nom);
            } else {
                $lastNumber = substr($result->nomor, 6, 3)+1;
                $newNumber = $firstNumber.sprintf('%03s', $lastNumber);
            }
        }
        return $newNumber;
    }

    public static function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'This is my secret key';
        $secret_iv = 'This is my secret iv';
        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    public static function generateNoKas($kategori, $tanggal)
    {
        if($kategori=="in")
        {
            $no_urut = 1;
            $arr_tgl = explode("-", $tanggal);
            $bulan = sprintf('%02s', $arr_tgl[1]);
            $tahun = $arr_tgl[0];

            $result = KasMasukModel::whereYear('tgl_transaksi', $tahun)->orderby('id', 'desc')->first();
            if(empty($result->no_transaksi)) {
                $no_baru = "IN".$tahun.$bulan.sprintf('%04s', $no_urut); //Kas masuk
            } else {
                $no_bayar_baru = substr($result->no_transaksi, 9, 4)+1;
                $no_baru = "IN".$tahun.$bulan.sprintf('%04s', $no_bayar_baru);
            }
            return $no_baru;
        }
        if($kategori=="ot")
        {
            $no_urut = 1;
            $arr_tgl = explode("-", $tanggal);
            $bulan = sprintf('%02s', $arr_tgl[1]);
            $tahun = $arr_tgl[0];

            $result = KasKeluarModel::whereYear('tgl_transaksi', $tahun)->orderby('id', 'desc')->first();
            if(empty($result->no_transaksi)) {
                $no_baru = "OT".$tahun.$bulan.sprintf('%04s', $no_urut); //Kas masuk
            } else {
                $no_bayar_baru = substr($result->no_transaksi, 9, 4)+1;
                $no_baru = "OT".$tahun.$bulan.sprintf('%04s', $no_bayar_baru);
            }
            return $no_baru;
        }
    }
}

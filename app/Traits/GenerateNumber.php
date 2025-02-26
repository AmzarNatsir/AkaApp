<?php

namespace App\Traits;

use App\Models\BeliHeaderModel;

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
}

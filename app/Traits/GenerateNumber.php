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
}

<?php

namespace App\Traits;

use App\Models\ArusKasModel;

trait Keuangan
{
    public static function getSaldoAkhir($periode) {
        $saldo_d_total = ArusKasModel::whereDate("tgl_transaksi", "<=", $periode)->sum('debet');
        $saldo_k_total = ArusKasModel::whereDate("tgl_transaksi", "<=", $periode)->sum('kredit');
        $saldo_akhir = $saldo_d_total - $saldo_k_total;

        return $saldo_akhir;
    }

    public static function getTotalKasMasuk($periode) {
        $saldo_d_total = ArusKasModel::whereDate("tgl_transaksi", "<=", $periode)->sum('debet');
        return $saldo_d_total;
    }

    public static function getTotalKasKeluar($periode) {
        $saldo_k_total = ArusKasModel::whereDate("tgl_transaksi", "<=", $periode)->sum('kredit');
        return $saldo_k_total;
    }
}

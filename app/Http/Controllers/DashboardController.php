<?php

namespace App\Http\Controllers;

use App\Traits\Keuangan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use Keuangan;
    public function index()
    {
        $toDay = date("Y-m-d");
        $data = [
            'saldo_akhir' => Keuangan::getSaldoAkhir($toDay),
            'total_kas_masuk' => Keuangan::getTotalKasMasuk($toDay),
            'total_kas_keluar' => Keuangan::getTotalKasKeluar($toDay),
        ];
        return view('dashboard.index', $data);
    }
}

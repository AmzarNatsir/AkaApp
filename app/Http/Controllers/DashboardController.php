<?php

namespace App\Http\Controllers;

use App\Models\PelangganModel;
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
            'pelanggan_prospek' => PelangganModel::where('aktif', 'y')->whereNull('status')->get()->count(),
            'pelanggan_proses' => PelangganModel::where('aktif', 'y')->where('status', 'onProses')->get()->count(),
            'pelanggan_batal' => PelangganModel::where('aktif', 'y')->where('status', 'onCanceled')->get()->count(),
            'pelanggan_completed' => PelangganModel::where('aktif', 'y')->where('status', 'onCompleted')->get()->count(),
            'pelanggan_aktif' => PelangganModel::where('aktif', 'y')->where('status', 'onFinished')->get()->count(),
        ];
        return view('dashboard.index', $data);
    }
}

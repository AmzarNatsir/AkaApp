<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\PelangganModel;
use App\Models\PemakaianModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(empty(auth()->user()->petugas->id)) {
            return view('home');
        } else {
            $userId = auth()->user()->petugas->id;
            $data = [
                'listTask' => PelangganModel::select([
                                'pelanggan.*',
                                'pemakaian.id as id_pemakaian',
                                'pemakaian.tanggal',
                                'pemakaian.keterangan',
                                'wilayah.wilayah',
                                'paket_internet.nama_paket'
                            ])
                            ->leftJoin('pemakaian', 'pemakaian.id_pelanggan', '=', 'pelanggan.id')
                            ->leftJoin('wilayah', 'wilayah.id', '=', 'pelanggan.wilayah')
                            ->leftJoin('paket_internet', 'paket_internet.id', '=', 'pelanggan.paket_internet')
                            ->where('pelanggan.aktif', 'y')->where('pelanggan.status', 'onProses')
                            ->where(function($query) use ($userId) {
                                $query->where('pemakaian.petugas', $userId)
                                      ->orWhere('pemakaian.petugas', 'like', $userId . ',%')
                                      ->orWhere('pemakaian.petugas', 'like', '%,' . $userId . ',%')
                                      ->orWhere('pemakaian.petugas', 'like', '%,' . $userId);
                            })

                            ->get(),
                'newTask' => PelangganModel::with([
                    'getWilayah',
                    'getPaket'
                ])->where('aktif', 'y')->where('status', 'onProses')->get()->map(function ($row) {
                    $arr = $row->toArray();
                    $arr['pemakaian_material'] = PemakaianModel::where('id_pelanggan', $arr['id'])->first();
                    return $arr;
                }),
                'onProses' => PelangganModel::leftJoin('pemakaian', 'pemakaian.id_pelanggan', '=', 'pelanggan.id')
                            ->where('pelanggan.aktif', 'y')->where('pelanggan.status', 'onProses')
                            ->where(function($query) use ($userId) {
                                $query->where('pemakaian.petugas', $userId)
                                      ->orWhere('pemakaian.petugas', 'like', $userId . ',%')
                                      ->orWhere('pemakaian.petugas', 'like', '%,' . $userId . ',%')
                                      ->orWhere('pemakaian.petugas', 'like', '%,' . $userId);
                            })
                            ->count(),
                'onComplete' => PelangganModel::leftJoin('pemakaian', 'pemakaian.id_pelanggan', '=', 'pelanggan.id')
                                ->where('pelanggan.aktif', 'y')->where('pelanggan.status', 'onCompleted')
                                ->where(function($query) use ($userId) {
                                    $query->where('pemakaian.petugas', $userId)
                                          ->orWhere('pemakaian.petugas', 'like', $userId . ',%')
                                          ->orWhere('pemakaian.petugas', 'like', '%,' . $userId . ',%')
                                          ->orWhere('pemakaian.petugas', 'like', '%,' . $userId);
                                })
                                ->count(),
                'onFinished' => PelangganModel::leftJoin('pemakaian', 'pemakaian.id_pelanggan', '=', 'pelanggan.id')
                                ->where('pelanggan.aktif', 'y')->where('pelanggan.status', 'onFinished')
                                ->where(function($query) use ($userId) {
                                    $query->where('pemakaian.petugas', $userId)
                                          ->orWhere('pemakaian.petugas', 'like', $userId . ',%')
                                          ->orWhere('pemakaian.petugas', 'like', '%,' . $userId . ',%')
                                          ->orWhere('pemakaian.petugas', 'like', '%,' . $userId);
                                })
                                ->count(),
                'onCancel' => PelangganModel::leftJoin('pemakaian', 'pemakaian.id_pelanggan', '=', 'pelanggan.id')
                                ->where('pelanggan.aktif', 'y')->where('pelanggan.status', 'onCanceled')
                                ->where(function($query) use ($userId) {
                                    $query->where('pemakaian.petugas', $userId)
                                          ->orWhere('pemakaian.petugas', 'like', $userId . ',%')
                                          ->orWhere('pemakaian.petugas', 'like', '%,' . $userId . ',%')
                                          ->orWhere('pemakaian.petugas', 'like', '%,' . $userId);
                                })
                                ->count(),
            ];
            // dd($data);
            return view('service.main', $data);
        }

    }
}

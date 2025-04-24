<?php

namespace App\Http\Controllers;

use App\Models\PelangganModel;
use App\Models\PemakaianDetailModel;
use App\Models\PemakaianModel;
use App\Models\PemasanganDetailModel;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ServiceController extends Controller
{
    use General;
    public function getListMaterialPelanggan($idHead)
    {
        $data = [
            'listPemakaian' => PemakaianDetailModel::with(['getMaterial'])->where('head_id', $idHead)->get()
        ];
        return view('service.list_material', $data);
    }

    public function goFormComplete($idPelanggan)
    {
        $data = [
            'pelanggan' => PelangganModel::with([
                'getWilayah',
                'getPaket'
            ])->find($idPelanggan),
            'pemakaian' => PemakaianModel::where('id_pelanggan', $idPelanggan)->first()
        ];
        return view('service.form_complete', $data);
    }

    public function storeFormComplete(Request $request)
    {
        DB::beginTransaction();
        try {
            $fileRumah = NULL;
            $fileODP = NULL;
            $fileOntTerpasang = NULL;
            $fileOntBelakang = NULL;
            $fileRedamanDiOdp = NULL;
            $fileRedamanRumahPelanggan = NULL;
            $fileLainnya = NULL;
            if($request->hasFile('fileRumah'))
            {
                $fileRumah = General::upload_gambar($request->file('fileRumah'), 'gambar_rumah');
            }
            if($request->hasFile('fileODP'))
            {
                $fileODP = General::upload_gambar($request->file('fileODP'), 'gambar_odp');
            }
            if($request->hasFile('fileOntTerpasang'))
            {
                $fileOntTerpasang = General::upload_gambar($request->file('fileOntTerpasang'), 'gambar_ont_terpasang');
            }
            if($request->hasFile('fileOntBelakang'))
            {
                $fileOntBelakang = General::upload_gambar($request->file('fileOntBelakang'), 'gambar_ont_belakang');
            }
            if($request->hasFile('fileRedamanDiOdp'))
            {
                $fileRedamanDiOdp = General::upload_gambar($request->file('fileRedamanDiOdp'), 'gambar_redaman_odp');
            }
            if($request->hasFile('fileRedamanRumahPelanggan'))
            {
                $fileRedamanRumahPelanggan = General::upload_gambar($request->file('fileRedamanRumahPelanggan'), 'gambar_redaman_rumah_pelanggan');
            }
            if($request->hasFile('fileLainnya'))
            {
                $fileLainnya = General::upload_gambar($request->file('fileLainnya'), 'gambar_lainnya');
            }
            $data = [
                'id_pelanggan' => $request->id_pelanggan,
                'id_pemakaian' => $request->id_pemakaian,
                'sn_ont' => $request->inpSN_ONT,
                'model_ont' => $request->inpModel_ONT,
                'odp' => $request->inpODP,
                'tikor_odp' => $request->inpTikorODP,
                'tikor_pelanggan' => $request->inpTikorPelanggan,
                'port' => $request->inpPort,
                'port_ifle' => $request->inpPortIfle,
                'splitter' => $request->inpSplitter,
                'kabel_dc' => $request->inpKabelDC,
                'gambar_rumah' => $fileRumah,
                'gambar_odp' => $fileODP,
                'gambar_ont_terpasang' => $fileOntTerpasang,
                'gambar_belakang_ont' => $fileOntBelakang,
                'gambar_redaman_odp' => $fileRedamanDiOdp,
                'gambar_redaman_rumah_pelanggan' => $fileRedamanRumahPelanggan,
                'gambar_lainnya' => $fileLainnya,
                'user_id' => auth()->user()->id,
            ];
            PemasanganDetailModel::create($data);

            PelangganModel::find($request->id_pelanggan)->update([
                'status' => 'onCompleted',
                'tgl_completed' => date("Y-m-d")
            ]);

            DB::commit();
            $rs = response()->json([
                'success' => true,
                'message' => "Data berhasil disimpan."
            ]);
        } catch (Throwable $e) {
            DB::rollBack(); // Rollback transaction on error
            // Log the error for debugging
            // \Log::error('Transaction failed: '.$e->getMessage());
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data. error: ".$e->getMessage()
            ]);
        }
        return $rs;
    }
    public function listTaskComplete()
    {
        $userId = auth()->user()->petugas->id;
        $data = [
            'listTask' => PelangganModel::select([
                                'pelanggan.*',
                                'pemakaian.id as id_pemakaian',
                                'pemakaian.tanggal',
                                'pemakaian.keterangan',
                                'wilayah.wilayah',
                                'paket_internet.nama_paket',
                                'pemasangan_detail.sn_ont',
                                'pemasangan_detail.model_ont',
                                'pemasangan_detail.odp',
                                'pemasangan_detail.tikor_odp',
                                'pemasangan_detail.tikor_pelanggan',
                                'pemasangan_detail.port',
                                'pemasangan_detail.port_ifle',
                                'pemasangan_detail.splitter',
                                'pemasangan_detail.kabel_dc',
                                'pemasangan_detail.tgl_aktivasi',
                                'pemasangan_detail.gambar_rumah',
                                'pemasangan_detail.gambar_odp',
                                'pemasangan_detail.gambar_ont_terpasang',
                                'pemasangan_detail.gambar_belakang_ont',
                                'pemasangan_detail.gambar_redaman_odp',
                                'pemasangan_detail.gambar_redaman_rumah_pelanggan',
                                'pemasangan_detail.gambar_lainnya',
                            ])
                            ->leftJoin('pemakaian', 'pemakaian.id_pelanggan', '=', 'pelanggan.id')
                            ->leftJoin('wilayah', 'wilayah.id', '=', 'pelanggan.wilayah')
                            ->leftJoin('paket_internet', 'paket_internet.id', '=', 'pelanggan.paket_internet')
                            ->leftJoin('pemasangan_detail', 'pemasangan_detail.id_pelanggan', '=', 'pelanggan.id')
                            ->where('pelanggan.aktif', 'y')->where('pelanggan.status', 'onCompleted')
                            ->where(function($query) use ($userId) {
                                $query->where('pemakaian.petugas', $userId)
                                      ->orWhere('pemakaian.petugas', 'like', $userId . ',%')
                                      ->orWhere('pemakaian.petugas', 'like', '%,' . $userId . ',%')
                                      ->orWhere('pemakaian.petugas', 'like', '%,' . $userId);
                            })->get(),
            'completedTask' => PelangganModel::with([
                'getWilayah',
                'getPaket'
            ])->where('aktif', 'y')->where('status', 'onCompleted')->get()->map(function ($row) {
                $arr = $row->toArray();
                $arr['pemakaian_material'] = PemakaianModel::where('id_pelanggan', $arr['id'])->first();
                $arr['pemasangan_detail'] = PemasanganDetailModel::where('id_pelanggan', $arr['id'])->first();
                return $arr;
            })
        ];
        // dd($data);
        return view('service.list_task_complete', $data);
    }

    public function listTaskFinished()
    {
        $userId = auth()->user()->petugas->id;
        $data = [
            'listTask' => PelangganModel::select([
                                'pelanggan.*',
                                'pemakaian.id as id_pemakaian',
                                'pemakaian.tanggal',
                                'pemakaian.keterangan',
                                'wilayah.wilayah',
                                'paket_internet.nama_paket',
                                'pemasangan_detail.sn_ont',
                                'pemasangan_detail.model_ont',
                                'pemasangan_detail.odp',
                                'pemasangan_detail.tikor_odp',
                                'pemasangan_detail.tikor_pelanggan',
                                'pemasangan_detail.port',
                                'pemasangan_detail.port_ifle',
                                'pemasangan_detail.splitter',
                                'pemasangan_detail.kabel_dc',
                                'pemasangan_detail.tgl_aktivasi',
                                'pemasangan_detail.gambar_rumah',
                                'pemasangan_detail.gambar_odp',
                                'pemasangan_detail.gambar_ont_terpasang',
                                'pemasangan_detail.gambar_belakang_ont',
                                'pemasangan_detail.gambar_redaman_odp',
                                'pemasangan_detail.gambar_redaman_rumah_pelanggan',
                                'pemasangan_detail.gambar_lainnya',
                            ])
                            ->leftJoin('pemakaian', 'pemakaian.id_pelanggan', '=', 'pelanggan.id')
                            ->leftJoin('wilayah', 'wilayah.id', '=', 'pelanggan.wilayah')
                            ->leftJoin('paket_internet', 'paket_internet.id', '=', 'pelanggan.paket_internet')
                            ->leftJoin('pemasangan_detail', 'pemasangan_detail.id_pelanggan', '=', 'pelanggan.id')
                            ->where('pelanggan.aktif', 'y')->where('pelanggan.status', 'onFinished')
                            ->where(function($query) use ($userId) {
                                $query->where('pemakaian.petugas', $userId)
                                      ->orWhere('pemakaian.petugas', 'like', $userId . ',%')
                                      ->orWhere('pemakaian.petugas', 'like', '%,' . $userId . ',%')
                                      ->orWhere('pemakaian.petugas', 'like', '%,' . $userId);
                            })

                            ->get(),
            'completedTask' => PelangganModel::with([
                'getWilayah',
                'getPaket'
            ])->where('aktif', 'y')->where('status', 'onFinished')->get()->map(function ($row) {
                $arr = $row->toArray();
                $arr['pemakaian_material'] = PemakaianModel::where('id_pelanggan', $arr['id'])->first();
                $arr['pemasangan_detail'] = PemasanganDetailModel::where('id_pelanggan', $arr['id'])->first();
                return $arr;
            })
        ];
        return view('service.list_task_finished', $data);
    }

    public function goFormCacelTask($idPelanggan)
    {
        $data = [
            'pelanggan' => PelangganModel::with([
                'getWilayah',
                'getPaket'
            ])->find($idPelanggan)
        ];
        return view('service.form_cancel', $data);
    }
    public function storeCanceledTask(Request $request)
    {
        try {
            PelangganModel::find($request->id_pelanggan)->update([
                'status' => 'onCanceled',
                'keterangan_cancel' => $request->inpAlasan,
                'tgl_canceled' => date("Y-m-d"),
                'user_canceled' => auth()->user()->id
            ]);

            DB::commit();
            $rs = response()->json([
                'success' => true,
                'message' => "Task berhasil dibatalkan."
            ]);
        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data. error: ".$e->getMessage()
            ]);
        }
        return $rs;
    }
}

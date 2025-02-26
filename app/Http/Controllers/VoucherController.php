<?php

namespace App\Http\Controllers;

use App\Models\AgenVoucherModel;
use App\Models\VoucherDetailModel;
use App\Models\VoucherHeadModel;
use App\Models\VoucherModel;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class VoucherController extends Controller
{
    use General;
    protected $dateTimeInsert;

    function __construct()
    {
        $this->dateTimeInsert = date("Y-m-d H:s:i");
    }

    public function list()
    {
        return view('voucher.list');
    }
    public function getData(Request $request)
    {
        $columns = ['created_at'];
        $totalData = VoucherModel::where('aktif', 'y')->count();
        $search = $request->input('search.value');
        $query = VoucherModel::where('aktif', 'y')->select('*');
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('nama_voucher', 'like', "%{$search}%");
            });
        }
        $totalFiltered = $query->count();
        $query = $query->offset($request->input('start'))
                      ->limit($request->input('length'))
                        ->orderBy('id', 'asc')
                      ->get();

        $data = array();
        if($query){
            $counter = $request->input('start') + 1;
            foreach($query as $r){
                $btn = "<button type='button' class='btn btn-danger btn-sm' id='btn_delete' value='".$r->id."' onclick='konfirmDelete(this)'><i class='icon-trash'></i></button><button type='button' class='btn btn-success btn-sm' id='btn_edit' data-bs-toggle='modal' data-bs-target='#exampleModalgetbootstrap' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-pencil-alt'></i></button>";
                $Data['act'] = $btn;
                $Data['id'] =  $r->id;
                $Data['voucher'] =  $r->nama_voucher;
                $Data['harga_modal'] =  $r->harga_modal;
                $Data['harga_jual'] =  $r->harga_jual;
                $Data['no'] = $counter;
                $data[] = $Data;
                $counter++;
            }
        }
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('voucher.create');
    }

    public function store(Request $request)
    {
        try {
            VoucherModel::create([
                "nama_voucher" => $request->inpNama,
                "harga_modal" => str_replace(",","", $request->inpHargaModal),
                "harga_jual" => str_replace(",","", $request->inpHargaJual),
                'aktif' => "y"
            ]);
            $rs = response()->json([
                'success' => true,
                'message' => "Data baru berhasil disimpan"
            ]);
        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data baru"
            ]);
        }
        return $rs;

        // return redirect()->route('datamaster.merek')
        //         ->withSuccess('New Merek is added successfully.');
    }
    public function edit($id)
    {
        $data = [
            'res' => VoucherModel::find($id)
        ];
        return view('voucher.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            VoucherModel::find($id)->update([
                "nama_voucher" => $request->inpNama,
                "harga_modal" => str_replace(",","", $request->inpHargaModal),
                "harga_jual" => str_replace(",","", $request->inpHargaJual),
            ]);
            $rs = response()->json([
                'success' => true,
                'message' => "Perubahan data berhasil disimpan"
            ]);
        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data"
            ]);
        }
        return $rs;
    }

    public function destroy($id)
    {
        $del = VoucherModel::find($id)->update(['aktif' => 't']);
        if($del) {
            $rs = response()->json([
                'success' => true
            ]);
        } else {
            $rs = response()->json([
                'success' => false
            ]);
        }
        return $rs;
    }

    //distribusi
    public function distribusi()
    {
        $data = [
            'list_bulan' => General::getListMonth(),
            "list_agen" => AgenVoucherModel::where('aktif', 'y')->get(),
            'start_year' => 2024,
            'end_year' => date('Y')
        ];
        return view('voucher.distribusi.index', $data);
    }
    public function load_form_pengaturan($bulan, $tahun, $agen)
    {
        $dataH  = VoucherHeadModel::where('agen_id', $agen)->where('bulan', $bulan)->where('tahun', $tahun)->get();
        if($dataH->count()==0) {
            $data = [
                'bulan' => $bulan,
                'tahun' => $tahun,
                'agen' => $agen,
                "list_voucher" => VoucherModel::where('aktif', 'y')->orderBy('harga_modal')->get()
            ];
            return view('voucher.distribusi.form_pengaturan_baru', $data);
        } else {
            $data = [
                'bulan' => $bulan,
                'tahun' => $tahun,
                'agen' => $agen,
                'head_id' => $dataH->first()->id,
                'status_data' => $dataH->first()->status,
                "list_distribusi" => VoucherDetailModel::where('head_id', $dataH->first()->id)->get()
            ];
            return view('voucher.distribusi.form_pengaturan_open', $data);
        }

    }
    public function distribusi_store(Request $request)
    {
        DB::beginTransaction();
        try {
            if($request->postAction=="store")
            {
                $dataH = [
                    "bulan" => $request->postBulan,
                    "tahun" => $request->postTahun,
                    "agen_id" => $request->postAgen,
                    "status" => 'open',
                    "user_id" => auth()->user()->id,
                    "created_at" => $this->dateTimeInsert
                ];
                $lastID = VoucherHeadModel::insertGetId($dataH);
                if($lastID) {
                    $jml_item = count($request->inpVoucherID);
                    foreach(array($request) as $key => $value)
                    {
                        for($i=0; $i<$jml_item; $i++)
                        {
                            $dataD = [
                                "head_id" => $lastID,
                                "voucher_id" => $value['inpVoucherID'][$i],
                                "nama_voucher" => $value['inpVoucher'][$i],
                                "harga_modal" => $value['inphargaModal'][$i],
                                "harga_jual" => $value['inphargaJual'][$i],
                                "stok_awal" => str_replace(",","", $value['inpStokAwal'][$i]),
                                "created_at" => $this->dateTimeInsert
                            ];

                            VoucherDetailModel::insert($dataD);
                        }
                    }
                    DB::commit(); // Commit Transaction if everything is successful
                    $rs = response()->json([
                        'success' => true,
                        'message' => "Pengaturan distribusi voucher agen berhasil disimpan"
                    ]);
                } else {
                    DB::rollBack(); // Rollback on error
                    $rs = response()->json([
                        'success' => false,
                        'message' => "Terdapat error pada proses penyimpanan data"
                    ]);
                }
            }

            if($request->postAction=="update")
            {
                $jml_item = count($request->idDetail);
                foreach(array($request) as $key => $value)
                {
                    for($i=0; $i<$jml_item; $i++)
                    {
                        $idDetail = $value['idDetail'][$i];
                        $dataUpdate = [
                            "stok_awal" => str_replace(",","", $value['inpStokAwal'][$i]),
                            "stok_tambahan" => str_replace(",","", $value['inpStokTambahan'][$i]),
                            "updated_at" => $this->dateTimeInsert
                        ];

                        VoucherDetailModel::find($idDetail)->update($dataUpdate);
                    }
                }
                DB::commit(); // Commit Transaction if everything is successful
                $rs = response()->json([
                    'success' => true,
                    'message' => "Pengaturan distribusi voucher agen berhasil disimpan"
                ]);
            }

        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data ".$e->getMessage()
            ]);
        }
        return $rs;
    }

    //penjualan
    public function penjualan()
    {
        $data = [
            'list_bulan' => General::getListMonth(),
            "list_agen" => AgenVoucherModel::where('aktif', 'y')->get(),
            'start_year' => 2024,
            'end_year' => date('Y')
        ];
        return view('voucher.penjualan.index', $data);
    }
    public function load_form_data_agen_voucher($bulan, $tahun, $agen)
    {
        $dataH  = VoucherHeadModel::where('agen_id', $agen)->where('bulan', $bulan)->where('tahun', $tahun)->get();
        if($dataH->count()==0) {
            return view('voucher.penjualan.data_empty');
        } else {
            $data = [
                'bulan' => $bulan,
                'tahun' => $tahun,
                'agen' => $agen,
                'head_id' => $dataH->first()->id,
                'status_data' => $dataH->first()->status,
                "list_distribusi" => VoucherDetailModel::where('head_id', $dataH->first()->id)->get()
            ];
            return view('voucher.penjualan.form_penjualan', $data);
        }

    }
}

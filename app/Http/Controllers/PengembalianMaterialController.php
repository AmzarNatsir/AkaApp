<?php

namespace App\Http\Controllers;

use App\Models\CabangModel;
use App\Models\Material;
use App\Models\PengembalianDetailModel;
use App\Models\PengembalianModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PengembalianMaterialController extends Controller
{
    protected $dateTimeInsert;

    function __construct()
    {
        $this->dateTimeInsert = date("Y-m-d H:s:i");
    }

    public function index()
    {
        $data = [
            'gudang_utama' => Material::get()->sum('stok_akhir'),
            'list_cabang' => CabangModel::where('aktif', 'y')->get(),
        ];
        return view('pengembalian.material.index', $data);
    }

    public function baru($gudang)
    {
        if($gudang==1) {
            $list_material = Material::with(['getMerek'])->get();
        }
        $data = [
            'gudangID' => $gudang,
            'list_material' => $list_material,
        ];
        return view('pengembalian.material.baru', $data);
    }

    public function getItem(Request $request)
    {
        return response()->json([
            'success' => true,
            'result' => Material::with(['getMerek', 'getSatuan'])->find($request->itemID),
            'message' => "Data ditemukan"
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $dataH = [
                "tanggal" => $request->inpTanggal,
                "keterangan" => $request->inpKeterangan,
                "user_id" => auth()->user()->id,
                "gudang_id" => $request->gudangID,
                "created_at" => $this->dateTimeInsert
            ];
            $lastID = PengembalianModel::insertGetId($dataH);
            $jml_item = count($request->item_id_material);
            foreach(array($request) as $key => $value)
            {
                for($i=0; $i<$jml_item; $i++)
                {
                    $dataD = [
                        "head_id" => $lastID,
                        "material_id" => $value['item_id_material'][$i],
                        "jumlah" => $value['item_qty'][$i],
                        "gudang_id" => $request->gudangID,
                        "created_at" => $this->dateTimeInsert
                    ];
                    PengembalianDetailModel::insert($dataD);
                    //update stok
                    if($request->gudangID==1)
                    {
                        $updateStok = Material::find($value['item_id_material'][$i]);
                        $updateStok->stok_akhir += str_replace(",","", $value['item_qty'][$i]);
                        $updateStok->update();
                    }
                }

            }
            DB::commit(); // Commit Transaction if everything is successful
            $rs = response()->json([
                'success' => true,
                'message' => "Data pengembalian material berhasil disimpan."
            ]);

        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data. ".$e->getMessage()
            ]);
        }
        return $rs;
    }

    public function list()
    {
        return view("pengembalian.material.list");
    }

    public function getData(Request $request)
    {
        $columns = ['created_at'];
        $totalData = PengembalianModel::count();
        $search = $request->input('search.value');
        $query = PengembalianModel::select("*");
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('tanggal', 'like', "%{$search}%");
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
                $btn = "<button type='button' class='btn btn-success btn-sm' id='btn_detail' data-bs-toggle='modal' data-bs-target='#exampleModalgetbootstrap' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-eye'></i></button>";
                $totalItem = PengembalianDetailModel::where('head_id', $r->id)->sum('jumlah');
                $Data['act'] = $btn;
                $Data['id'] =  $r->id;
                $Data['tanggal'] =  $r->tanggal; // $r->material;
                $Data['keterangan'] =  $r->keterangan;
                $Data['total'] =  "<span class='badge badge-success'>".$totalItem."</span>";
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

    public function detail($id)
    {
        $resultH = PengembalianModel::find($id);
        $data = [
            "dataH" => $resultH,
            'dataD' => PengembalianDetailModel::with([
                "getMaterial"
            ])->where('head_id', $id)->get()
        ];
        return view("pengembalian.material.detail", $data);
    }

}

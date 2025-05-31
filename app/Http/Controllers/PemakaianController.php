<?php

namespace App\Http\Controllers;

use App\Models\CabangModel;
use App\Models\Material;
use App\Models\PemakaianDetailModel;
use App\Models\PemakaianModel;
use App\Models\PetugasModel;
use App\Models\WilayahModel;
use App\Traits\General;
use App\Traits\GenerateNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Colors\Rgb\Channels\Red;
use Throwable;

class PemakaianController extends Controller
{
    use GenerateNumber;
    use General;
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
        return view('pemakaian.index', $data);
    }

    public function create($gudang)
    {
        if($gudang==1) {
            $list_material = Material::with(['getMerek'])->get();
        }
        $data = [
            'gudangID' => $gudang,
            'list_material' => $list_material,
            'list_wilayah' => WilayahModel::all(),
            'list_petugas' => PetugasModel::where('aktif', 'y')->get()
        ];
        return view('pemakaian.create', $data);
    }

    public function getItem(Request $request)
    {
        $resMaterial = Material::with(['getMerek', 'getSatuan'])->find($request->itemID);
        return response()->json([
            'success' => true,
            'result' => $resMaterial,
            'message' => "Data ditemukan"
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $dataH = [
                "tanggal" => $request->inpTanggal,
                "kategori_id" => $request->pilKategori,
                "wilayah_id" => $request->pilWilayah,
                "petugas_id" => $request->pilPetugas,
                "keterangan" => $request->inpKeterangan,
                "user_id" => auth()->user()->id,
                "gudang_id" => $request->gudangID,
                "created_at" => $this->dateTimeInsert
            ];
            $lastID = PemakaianModel::insertGetId($dataH);
            $jml_item = count($request->item_id_material);
            foreach(array($request) as $key => $value)
            {
                for($i=0; $i<$jml_item; $i++)
                {
                    $dataD = [
                        "head_id" => $lastID,
                        "material_id" => $value['item_id_material'][$i],
                        "jumlah" => $value['item_qty'][$i],
                        "harga" => $value['current_harga'][$i],
                        "gudang_id" => $request->gudangID,
                        "created_at" => $this->dateTimeInsert
                    ];
                    PemakaianDetailModel::insert($dataD);
                    //update stok
                    if($request->gudangID==1)
                    {
                        $updateStok = Material::find($value['item_id_material'][$i]);
                        $updateStok->stok_akhir -= str_replace(",","", $value['item_qty'][$i]);
                        $updateStok->update();
                    }
                }

            }
            DB::commit(); // Commit Transaction if everything is successful
            $rs = response()->json([
                'success' => true,
                'message' => "Data pemakaian material berhasil disimpan."
            ]);

        } catch (Throwable $e) {
            DB::rollBack();
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data"
            ]);
        }
        return $rs;
    }
    //list pemakaian
    public function list()
    {
        return view("pemakaian.list");
    }

    public function getData(Request $request)
    {
        $columns = ['created_at'];
        $totalData = PemakaianModel::count();
        $search = $request->input('search.value');
        $query = PemakaianModel::with(['getWilayah', 'getPetugas']);
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('tanggal', 'like', "%{$search}%");
            });
        }
        $totalFiltered = $query->count();
        $query = $query->offset($request->input('start'))
                      ->limit($request->input('length'))
                        ->orderBy('tanggal', 'desc')
                      ->get();

        $data = array();
        $petugas="";
        if($query){
            $counter = $request->input('start') + 1;
            foreach($query as $r){
                if(empty($r->petugas_id)) {
                    $petugas = $this->getMultiPetugas($r->petugas);
                } else {
                    $petugas = $r->getPetugas->nama_petugas;
                }
                $btn = "<button type='button' class='btn btn-success btn-sm' id='btn_detail' data-bs-toggle='modal' data-bs-target='#exampleModalgetbootstrap' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-eye'></i></button>";
                $totalItem = PemakaianDetailModel::where('head_id', $r->id)->sum('jumlah');
                $Data['act'] = $btn;
                $Data['id'] =  $r->id;
                $Data['tanggal'] =  $r->tanggal; // $r->material;
                $Data['kategori'] =  $this->getKategori($r->kategori_id);
                $Data['wilayah'] =  $r->getWilayah->wilayah;
                $Data['petugas'] =  $petugas;
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
        $resultH = PemakaianModel::with([
            "getWilayah",
            "getPetugas"
        ])->find($id);
        if(empty($resultH->petugas_id)) {
            $petugas = $this->getMultiPetugas($resultH->petugas);
        } else {
            $petugas = $resultH->getPetugas->nama_petugas;
        }
        $data = [
            "dataH" => $resultH,
            'kategori_pemakaian' => General::get_kategori_pemakaian_material($resultH->kategori_id),
            'dataD' => PemakaianDetailModel::with([
                "getMaterial"
            ])->where('head_id', $id)->get(),
            'petugas' => $petugas
        ];
        return view("pemakaian.detail", $data);
    }

    function getKategori($id)
    {
        $arr = array("1" => "Pemesangan Baru", "2" => "Pengembangan", "3" => "Maintanance - Perbaikan", "4" => "Maintanance - Penggantian");
        foreach($arr as $key => $value)
        {
            if($key==$id)
            {
                return $value;
                break;
            }
        }
    }

    function getMultiPetugas($arrPetugas)
    {
        $petugasArray = explode(',', $arrPetugas);

        // Get all petugas in one query
        $petugas = PetugasModel::whereIn('id', $petugasArray)->pluck('nama_petugas', 'id');

        // Map IDs to names (preserving order)
        $petugasArray = [];
        foreach ($petugas as $key => $value) {
            $petugasArray[] = $value;
        }
        $allPetugas = (count($petugasArray) > 0) ? (implode(',', $petugasArray)) : "-";

        return $allPetugas;
    }
}

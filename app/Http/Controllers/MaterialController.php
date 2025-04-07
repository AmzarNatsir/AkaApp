<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Models\BeliDetailModel;
use App\Models\BeliHeaderModel;
use App\Models\CabangModel;
use App\Models\Merek;
use App\Models\PemakaianDetailModel;
use App\Models\PengembalianDetailModel;
use App\Models\SatuanModel;
use App\Traits\General;
use Generator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;
use Intervention\Image\Laravel\Facades\Image;

class MaterialController extends Controller
{
    use General;

    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('permission:material_view|material_edit|material_delete|material_create', ['only' => ['index']]);
       $this->middleware('permission:material_kartu_stok_view', ['only' => ['kontrol']]);
    //    $this->middleware('permission:create-material', ['only' => ['create','store']]);
    //    $this->middleware('permission:edit-material', ['only' => ['edit','update']]);
    //    $this->middleware('permission:delete-material', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('material.index');
    }

    public function getData(Request $request)
    {
        $columns = ['created_at'];
        $totalData = Material::count();
        $search = $request->input('search.value');
        $query = Material::with(['getMerek', 'getSatuan']);
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('material', 'like', "%{$search}%");
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
                $btn2 = "";
                $material = '<div class="product-names">
                                <div class="light-product-box"><a href="'.Storage::url('material/'.$r->gambar).'" data-fancybox data-caption="'. $r->material.'"><img class="img-fluid" src="'.Storage::url('material/'.$r->gambar).'" alt="headphones"></a></div>
                                <p>'.$r->material.'</p>
                              </div>';
                $btn2 .= '<ul class="action">';
                $btn2 .= '<li class="show"><a href="'.url('material/show',$r->id).'"><i class="icon-eye"></i></a></li>&nbsp;&nbsp;';
                if(auth()->user()->can('material_edit'))
                {
                    $btn2 .= '<li class="edit"> <a href="'.url('material/edit',$r->id).'"><i class="icon-pencil-alt"></i></a></li>';
                }
                if(auth()->user()->can('material_delete'))
                {
                    $btn2 .= '<li class="delete"><a href="javascript:void(0)" value="'.$r->id.'" id="btn_delete" onclick="konfirmDelete('.$r->id.')"><i class="icon-trash"></i></a></li>';
                }
                $btn2 .= '</ul>';
                $Data['act'] = $btn2;
                $Data['id'] =  $r->id;
                $Data['material'] =  $material; // $r->material;
                $Data['merek'] =  (empty($r->getMerek->merek)) ? "" : $r->getMerek->merek;
                $Data['satuan'] =  (empty($r->getSatuan->satuan)) ? "" : $r->getSatuan->satuan;
                $Data['jumlah'] =  $r->stok_akhir;
                $Data['harga'] =  "Rp. ".number_format($r->harga_beli, 0);
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

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data = [
            'listMerek' => Merek::whereNull('deleted_at')->get(),
            'listSatuan' => SatuanModel::whereNull('deleted_at')->get()
        ];
        return view('material.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $fileImage = NULL;
            $path = NULL;
            if($request->hasFile('inpFile'))
            {

                $path = storage_path("app/public/material");
                if(!File::isDirectory($path)) {
                    $path = Storage::disk('public')->makeDirectory('material');
                }
                $image = $request->file('inpFile');
                $fileImage = time() . '.' . $image->getClientOriginalExtension();
                $image_resize = Image::read($image->getRealPath());
                $image_resize->resize(300, 300, function($construction){
                    $construction->aspectRatio();
                });
                $image_resize->save(storage_path("app/public/material/".$fileImage));

            }
            $insert = [
                'material' => $request->inpMaterial,
                'satuan_id' => $request->selectSatuan,
                'merek_id' => $request->selectMerek,
                'harga_beli' => str_replace(",","", $request->inpHargaBeli),
                'stok_awal' => str_replace(",","", $request->inpStokAwal),
                'stok_akhir' => str_replace(",","", $request->inpStokAkhir),
                'gambar' => $fileImage,
                'path_gambar' => $path,
                'deskripsi' => $request->inpDeskripsi
            ];
            Material::create($insert);
            $rs = response()->json([
                'success' => true,
                'message' => "New Data is added successfully."
            ]);
        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return $rs;
    }

    /**
     * Display the specified resource.
     */
    public function show($material): View
    {
        $data = [
            'res' => Material::with([
                "getMerek",
                "getSatuan"
            ])->find($material),
            'listMerek' => Merek::whereNull('deleted_at')->get(),
            'listSatuan' => SatuanModel::whereNull('deleted_at')->get()
        ];
        return view('material.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($material): View
    {
        $data = [
            'res' => Material::find($material),
            'listMerek' => Merek::whereNull('deleted_at')->get(),
            'listSatuan' => SatuanModel::whereNull('deleted_at')->get()
        ];
        return view('material.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $material)
    {
        try {

            $fileImage = (empty($request->tmpFile)) ? NULL : $request->tmpFile;
            $path = (empty($request->tmpFilePath)) ? NULL : $request->tmpFilePath;
            if($request->hasFile('inpFile'))
            {
                if(!empty($fileImage)) {
                    $this->del_image_folder($material);
                }
                $path = storage_path("app/public/material");
                if(!File::isDirectory($path)) {
                    $path = Storage::disk('public')->makeDirectory('material');
                }
                $image = $request->file('inpFile');
                $fileImage = time() . '.' . $image->getClientOriginalExtension();
                $image_resize = Image::read($image->getRealPath());
                $image_resize->resize(300, 300, function($construction){
                    $construction->aspectRatio();
                });
                $image_resize->save(storage_path("app/public/material/".$fileImage));

            }
            $update = [
                'material' => $request->inpMaterial,
                'satuan_id' => $request->selectSatuan,
                'merek_id' => $request->selectMerek,
                'harga_beli' => str_replace(",","", $request->inpHargaBeli),
                'stok_awal' => str_replace(",","", $request->inpStokAwal),
                'stok_akhir' => str_replace(",","", $request->inpStokAkhir),
                'gambar' => $fileImage,
                'path_gambar' => $path,
                'deskripsi' => $request->inpDeskripsi
            ];
            $updateExec = Material::find($material)->update($update);
            if($updateExec) {
                $status = true;
                $message = "Data updated successfully.";
            } else {
                $status = false;
                $message = "Data update not successfully.";
            }
            $rs = response()->json([
                'success' => $status,
                'message' => $message
            ]);
        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return $rs;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $checkUses = BeliDetailModel::where('material_id', $id)->count();
        if($checkUses > 0) {
            $success = false;
            $message = "Data material yang dipilih tidak bisa dihapus. Data sudah terpakai.";
        } else {
            $execDelete = Material::find($id)->delete();
            if($execDelete) {
                $success = true;
                $message = "Data material berhasil dihapus";
            } else {
                $success = false;
                $message = "Data material gagal dihapus. Terdapat error";
            }

        }
        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }

    public function del_image_folder($id)
    {
        $resfile = Material::find($id);
        $filename = $resfile->gambar;
        $image_path = storage_path('app/public/material/'.$filename);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
    }

    //kontrol stok
    public function kontrol()
    {
        $data = [
            'list_material' => Material::with([
                'getMerek',
                'getSatuan'
            ])->get()
        ];
        return view('material.kontrol', $data);
    }

    public function kontrol_get_data_material(Request $request)
    {
        $itemID = $request->itemID;
        $dataMaterial = Material::with([
            'getMerek',
            'getSatuan'
        ])->find($itemID);
        $result_cabang = CabangModel::where('aktif', 'y')->get();
        return response()->json([
            "material" => $dataMaterial->material,
            "material_keterangan" => $dataMaterial->deskripsi,
            "material_merk" => (empty($dataMaterial->getMerek->merek)) ? "" : $dataMaterial->getMerek->merek,
            "material_satuan" => (empty($dataMaterial->getSatuan->satuan)) ? "" : $dataMaterial->getSatuan->satuan,
            "material_stok_awal" => $dataMaterial->stok_awal,
            "material_stok_akhir" => $dataMaterial->stok_akhir,
            'list_cabang' => $result_cabang,
            'total_penerimaan' => BeliDetailModel::where('material_id', $itemID)->sum('jumlah'),
            'total_pemakaian' => PemakaianDetailModel::where('material_id', $itemID)->sum('jumlah'),
            'total_pengembalian' => PengembalianDetailModel::where('material_id', $itemID)->sum('jumlah')

        ]);
    }

    public function kontrol_get_detail($gudang, $material)
    {
        $rs = BeliDetailModel::with(['getHeader', 'getMaterial'])->where('material_id', $material)->get();
        $data = [
            'list_penerimaan' => $rs,
            'list_pemakaian' => PemakaianDetailModel::with(['getHeader'])->where('material_id', $material)->get(),
            'list_return' => PengembalianDetailModel::with(['getHeader'])->where('material_id', $material)->get(),
            'getKategori' => General::class,
        ];
        return view('material.detail_transaksi', $data);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BeliDetailModel;
use App\Models\BeliHeaderModel;
use App\Models\Material;
use App\Traits\GenerateNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Colors\Rgb\Channels\Red;
use Throwable;

class PembelianController extends Controller
{
    use GenerateNumber;
    //
    public function create()
    {
        return view('pembelian.create');
    }

    public function storeHead(Request $request)
    {
        try {
            $noTrans = GenerateNumber::genNumber("pembelian", $request->inpTanggal);
            $dataH = [
                "nomor" => $noTrans,
                "tanggal" => $request->inpTanggal,
                "total" => 0,
                'keterangan' => $request->inpKeterangan,
                'user_id' => auth()->user()->id,
                "status" => "draft"
            ];
            $lastID = BeliHeaderModel::insertGetId($dataH);

            if($lastID) {
                $rs = response()->json([
                    'success' => true,
                    'dataID' => $lastID,
                    'message' => "Transaksi pembelian baru berhasil disimpan."
                ]);
            } else {
                $rs = response()->json([
                    'success' => false,
                    'message' => "Transaksi pembelian baru gagal disimpan."
                ]);
            }
        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return $rs;
    }

    public function addDetail($id)
    {
        $data = [
            'dataH'=> BeliHeaderModel::find($id)
        ];
        return view('pembelian.create_next', $data);
    }


    public function addItems($id)
    {
        $currTotal = BeliDetailModel::where('header_id', $id)->sum('sub_total');
        $data = [
            'listMaterial' => Material::orderBy('material')->get(),
            'idHead' => $id,
            'tempTotal' => $currTotal
        ];
        return view('pembelian.add_items', $data);
    }

    public function storeItem(Request $request)
    {
        try {
            $lastID = $request->idHead;
            $dataD = [
                'header_id' => $lastID,
                'material_id' => $request->selectItem,
                'harga' => str_replace(",","", $request->inpHarga),
                'jumlah' => str_replace(",","", $request->inpJumlah),
                'sub_total' => str_replace(",","", $request->inpSubTotal),
            ];
            $execQuery = BeliDetailModel::insert($dataD);
            $currTotal = BeliDetailModel::where('header_id', $lastID)->sum('sub_total');
            if($execQuery) {
                BeliHeaderModel::find($lastID)->update(["total" => $currTotal]);
                $updateStok = Material::find($request->selectItem);
                $updateStok->stok_akhir += str_replace(",","", $request->inpJumlah);
                $updateStok->harga_beli = str_replace(",","", $request->inpHarga);
                $updateStok->update();
                $rs = response()->json([
                    'success' => true,
                    'dataTotal' => $currTotal,
                    'message' => "Item pembelian berhasil disimpan"
                ]);
            } else {
                $rs = response()->json([
                    'success' => false,
                    'message' => "Item pembelian gagal disimpan"
                ]);
            }

        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return $rs;
    }

    public function getDataItems(Request $request)
    {
        $headID = $request->headID;
        $dataH = BeliHeaderModel::find($headID);
        $columns = ['created_at'];
        $totalData = BeliDetailModel::where('header_id', $headID)->count();
        $search = $request->input('search.value');
        $query = BeliDetailModel::with([
            "getMaterial"
        ])->where('header_id', $headID);
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('harga', 'like', "%{$search}%");
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
                $material = '<div class="product-names">
                                <div class="light-product-box"><a href="'.url(Storage::url('material/'.$r->getMaterial->gambar)).'" data-fancybox data-caption="'. $r->getMaterial->material.'"><img class="img-fluid" src="'.url(Storage::url('material/'.$r->getMaterial->gambar)).'" alt="gambar"></a></div>
                                <ul style="padding: 0;margin: 0;list-style: none;">
                                    <li class="invoice-title invoice-text">
                                    <h4 style="font-weight:600; margin:4px 0px; font-size: 18px;">'.$r->getMaterial->material.'</h4><span style="opacity: 0.8; font-size: 16px;">'.$r->getMaterial->getMerek->merek.'</span><br><span style="opacity: 0.8; font-size: 16px;">'. $r->getMaterial->deskripsi.'</span></li>
                            </ul>
                              </div>';
                if($dataH->status=="draft") {
                    $btn2 = '<ul class="action"><li class="edit"> <a href="javascript:void(0)" onclick="editData('.$r->id.')" data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap" data-whatever="@getbootstrap"><i class="icon-pencil-alt"></i></a></li><li class="delete"><a href="javascript:void(0)" value="'.$r->id.'" id="btn_delete" onclick="konfirmDelete('.$r->id.')"><i class="icon-trash"></i></a></li>';
                } else {
                    $btn2 = "<span class='badge badge-success'>Finished</span>";
                }
                $Data['act'] = $btn2;
                // $Data['id'] =  $r->id;
                $Data['material'] =  $material; // $r->material;
                $Data['jumlah'] =  $r->jumlah;
                $Data['harga'] =  "Rp. ".number_format($r->harga, 0);
                $Data['sub_total'] =  "Rp. ".number_format($r->sub_total, 0);
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

    public function editItem($id)
    {
        $data = [
            "dataItem" => BeliDetailModel::with(["getMaterial"])->find($id),
            'listMaterial' => Material::orderBy('material')->get(),
        ];
        return view('pembelian.edit_item', $data);
    }

    public function updateItem(Request $request, $id)
    {
        try {
            $idHead = $request->idHead;
            $dataD = [
                'harga' => str_replace(",","", $request->inpHarga),
                'jumlah' => str_replace(",","", $request->inpJumlah),
                'sub_total' => str_replace(",","", $request->inpSubTotal),
            ];
            $execQuery = BeliDetailModel::find($id)->update($dataD);
            if($execQuery) {
                $currTotal = BeliDetailModel::where('header_id', $idHead)->sum('sub_total');
                BeliHeaderModel::find($idHead)->update(["total" => $currTotal]);
                $updateStok = Material::find($request->material_id);
                $currStok = ($updateStok->stok_akhir - $request->jumlahOld) + str_replace(",","", $request->inpJumlah);
                $updateStok->stok_akhir = $currStok;
                $updateStok->harga_beli = str_replace(",","", $request->inpHarga);
                $updateStok->update();
                $rs = response()->json([
                    'success' => true,
                    'message' => "Pembaharuan data item pembelian berhasil disimpan"
                ]);
            } else {
                $rs = response()->json([
                    'success' => false,
                    'message' => "Pembaharuan data item pembelian gagal disimpan"
                ]);
            }

        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return $rs;
    }

    public function destroyItem($idItem)
    {
        $dataItems = BeliDetailModel::find($idItem);
        $jumlah = $dataItems->jumlah;
        $idHead = $dataItems->header_id;
        $updateStok = Material::find($dataItems->material_id);
        $updateStok->stok_akhir = $updateStok->stok_akhir - $jumlah;
        $updateStok->update();
        $execQuery = $dataItems->delete();
        $currTotal = BeliDetailModel::where('header_id', $idHead)->sum('sub_total');
        $updateHead = BeliHeaderModel::find($dataItems->header_id);
        $updateHead->total = $currTotal;
        $updateHead->update();
        if($execQuery) {
            $rs = response()->json([
                'success' => true,
                'message' => "Item pembelian berhasil dihapus"
            ]);
        } else {
            $rs = response()->json([
                'success' => false,
                'message' => "Item pembelian gagal dihapus"
            ]);
        }
        return $rs;
    }

    public function finishTrans(Request $request, $id)
    {
        $updateHead = BeliHeaderModel::find($id);
        $updateHead->status = "finish";
        $execQuery = $updateHead->update();
        if($execQuery) {
            $rs = response()->json([
                'success' => true,
                'message' => "Perubahan status transaksi berhasil disimpan"
            ]);
        } else {
            $rs = response()->json([
                'success' => false,
                'message' => "Perubahan status transaksi gala disimpan"
            ]);
        }
        return $rs;
    }

    //list data
    public function list()
    {
        return view('pembelian.list');
    }
    public function getData(Request $request)
    {
        $columns = ['created_at'];
        $totalData = BeliHeaderModel::count();
        $search = $request->input('search.value');
        $query = BeliHeaderModel::select("*");
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('nomor', 'like', "%{$search}%");
            });
        }
        $totalFiltered = $query->count();
        $query = $query->offset($request->input('start'))
                      ->limit($request->input('length'))
                        ->orderBy('tanggal', 'desc')
                      ->get();

        $data = array();
        if($query){
            $counter = $request->input('start') + 1;
            foreach($query as $r){
                $action = '<ul class="action">';
                if($r->status=="draft") {
                    if(auth()->user()->can("trans_pembelian_edit")) {
                        $action .= '<li class="edit"> <a href="javascript:void(0)" onclick="editData('.$r->id.')"><i class="icon-pencil-alt"></i></a></li>';
                    }
                    if(auth()->user()->can("trans_pembelian_delete")) {
                        $action .= '<li class="delete"><a href="javascript:void(0)" value="'.$r->id.'" id="btn_delete" onclick="konfirmDelete('.$r->id.')"><i class="icon-trash"></i></a></li>';
                    }
                } else {
                    $action .= '<li class="delete"><a href="javascript:void(0)" onclick="detailData('.$r->id.')" data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap" data-whatever="@getbootstrap"><i class="icon-eye"></i></a></li></ul>';
                }
                $action .= '</ul>';
                $Data['act'] = $action;
                $Data['tanggal'] = $r->tanggal;
                $Data['nomor'] = $r->nomor;
                $Data['total'] = "Rp. ".number_format($r->total, 0);
                $Data['keterangan'] = $r->keterangan;
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

    //show detail
    public function show($id)
    {
        $data = [
            "dataH" => BeliHeaderModel::find($id),
            'dataD' => BeliDetailModel::with(['getMaterial'])->where('header_id', $id)->get()
        ];
        return view('pembelian.detail', $data);
    }
}

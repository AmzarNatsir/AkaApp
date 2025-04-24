<?php

namespace App\Http\Controllers;

use App\Models\PaketInternetModel;
use Illuminate\Http\Request;
use Throwable;

class PaketInternetController extends Controller
{
    public function index()
    {
        return view('paketinternet.index');
    }
    public function getData(Request $request)
    {
        $columns = ['created_at'];
        $totalData = PaketInternetModel::where('aktif', 'y')->count();
        $search = $request->input('search.value');
        $query = PaketInternetModel::where('aktif', 'y')->select('*');
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('nama_paket', 'like', "%{$search}%");
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
                $btn = "";
                if(auth()->user()->can("paket_internet_delete")) {
                    $btn .= "<button type='button' class='btn btn-danger btn-sm' id='btn_delete' value='".$r->id."' onclick='konfirmDelete(this)'><i class='icon-trash'></i></button>";
                }
                if(auth()->user()->can("paket_internet_edit")) {
                    $btn .="<button type='button' class='btn btn-success btn-sm' id='btn_edit' data-bs-toggle='modal' data-bs-target='#exampleModalgetbootstrap' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-pencil-alt'></i></button>";
                }
                $Data['act'] = $btn;
                $Data['id'] =  $r->id;
                $Data['nama_paket'] =  $r->nama_paket;
                $Data['harga'] = number_format($r->harga, 0);
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
        return view('paketinternet.create');
    }
    public function store(Request $request)
    {
        try {
            PaketInternetModel::create([
                "nama_paket" => $request->inpNama,
                "harga" => str_replace(",","", $request->inpHarga),
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

    }
    public function edit($id)
    {
        $data = [
            'res' => PaketInternetModel::find($id)
        ];
        return view('paketinternet.edit', $data);
    }
    public function update(Request $request, $id)
    {
        try {
            PaketInternetModel::find($id)->update([
                "nama_paket" => $request->inpNama,
                "harga" => str_replace(",","", $request->inpHarga),
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
        $del = PaketInternetModel::find($id)->update(['aktif' => 't']);
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
}

<?php

namespace App\Http\Controllers;

use App\Models\CabangModel;
use Illuminate\Http\Request;
use Throwable;

class CabangController extends Controller
{
    public function list()
    {
        return view('cabang.list');
    }
    public function getData(Request $request)
    {
        $columns = ['created_at'];
        $totalData = CabangModel::count();
        $search = $request->input('search.value');
        $query = CabangModel::select('*');
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('nama_cabang', 'like', "%{$search}%");
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
                $Data['kode'] =  $r->kode;
                $Data['cabang'] =  $r->nama_cabang;
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
        return view('cabang.create');
    }

    public function store(Request $request)
    {
        try {
            CabangModel::create([
                "kode" => $request->inpKode,
                "nama_cabang" => $request->inpNama,
                "alamat" => $request->inpAlamat,
                'aktif' => "y"
            ]);
            $rs = response()->json([
                'success' => true,
                'message' => "Data cabang baru berhasil disimpan"
            ]);
        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data cabang baru"
            ]);
        }
        return $rs;

        // return redirect()->route('datamaster.merek')
        //         ->withSuccess('New Merek is added successfully.');
    }
    public function edit($satuan)
    {
        $data = [
            'res' => CabangModel::find($satuan)
        ];
        return view('cabang.edit', $data);
    }

    public function update(Request $request, $cabang)
    {
        try {
            CabangModel::find($cabang)->update([
                "kode" => $request->inpKode,
                "nama_cabang" => $request->inpNama,
                "alamat" => $request->inpAlamat,
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

    public function destroy($cabang)
    {
        $del = CabangModel::find($cabang)->delete();
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

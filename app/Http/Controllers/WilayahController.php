<?php

namespace App\Http\Controllers;

use App\Models\WilayahModel;
use Illuminate\Http\Request;
use Throwable;

class WilayahController extends Controller
{
    public function list()
    {
        return view('wilayah.list');
    }
    public function getData(Request $request)
    {
        $columns = ['created_at'];
        $totalData = WilayahModel::count();
        $search = $request->input('search.value');
        $query = WilayahModel::select('*');
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('wilayah', 'like', "%{$search}%");
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
                if(auth()->user()->can("wilayah_delete")) {
                    $btn .= "<button type='button' class='btn btn-danger btn-sm' id='btn_delete' value='".$r->id."' onclick='konfirmDelete(this)'><i class='icon-trash'></i></button>";
                }
                if(auth()->user()->can("wilayah_edit")) {
                    $btn .= "<button type='button' class='btn btn-success btn-sm' id='btn_edit' data-bs-toggle='modal' data-bs-target='#exampleModalgetbootstrap' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-pencil-alt'></i></button>";
                }
                $Data['act'] = $btn;
                $Data['id'] =  $r->id;
                $Data['wilayah'] =  $r->wilayah;
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
        return view('wilayah.create');
    }

    public function store(Request $request)
    {
        try {
            WilayahModel::create([
                "wilayah" => $request->inpNama,
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
    public function edit($wilayah)
    {
        $data = [
            'res' => WilayahModel::find($wilayah)
        ];
        return view('wilayah.edit', $data);
    }

    public function update(Request $request, $wilayah)
    {
        try {
            WilayahModel::find($wilayah)->update([
                "wilayah" => $request->inpNama,
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

    public function destroy($wilayah)
    {
        $del = WilayahModel::find($wilayah)->delete();
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

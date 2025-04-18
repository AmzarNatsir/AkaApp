<?php

namespace App\Http\Controllers;

use App\Models\AgenVoucherModel;
use Illuminate\Http\Request;
use Throwable;

class AgenVoucherController extends Controller
{
    public function list()
    {
        return view('agen.list');
    }
    public function getData(Request $request)
    {
        $columns = ['created_at'];
        $totalData = AgenVoucherModel::where('aktif', 'y')->count();
        $search = $request->input('search.value');
        $query = AgenVoucherModel::where('aktif', 'y')->select('*');
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('nama_agen', 'like', "%{$search}%");
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
                if(auth()->user()->can("trans_agen_delete")) {
                    $btn .= "<button type='button' class='btn btn-danger btn-sm' id='btn_delete' value='".$r->id."' onclick='konfirmDelete(this)'><i class='icon-trash'></i></button>";
                }
                if(auth()->user()->can("trans_agen_edit")) {
                    $btn .="<button type='button' class='btn btn-success btn-sm' id='btn_edit' data-bs-toggle='modal' data-bs-target='#exampleModalgetbootstrap' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-pencil-alt'></i></button>";
                }
                $Data['act'] = $btn;
                $Data['id'] =  $r->id;
                $Data['nama_agen'] =  $r->nama_agen;
                $Data['alamat'] =  $r->alamat;
                $Data['no_telepon'] =  $r->no_telepon;
                $Data['kontak_person'] =  $r->kontak_person;
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
        return view('agen.create');
    }

    public function store(Request $request)
    {
        try {
            AgenVoucherModel::create([
                "nama_agen" => $request->inpNama,
                "alamat" => $request->inpAlamat,
                "no_telepon" => $request->inpNotel,
                "kontak_person" => $request->inpKontak,
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
    public function edit($id)
    {
        $data = [
            'res' => AgenVoucherModel::find($id)
        ];
        return view('agen.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            AgenVoucherModel::find($id)->update([
                "nama_agen" => $request->inpNama,
                "alamat" => $request->inpAlamat,
                "no_telepon" => $request->inpNotel,
                "kontak_person" => $request->inpKontak,
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
        $del = AgenVoucherModel::find($id)->update(['aktif' => 't']);
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

<?php

namespace App\Http\Controllers;

use App\Models\VoucherModel;
use Illuminate\Http\Request;
use Throwable;

class VoucherController extends Controller
{
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
}

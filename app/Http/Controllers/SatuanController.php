<?php

namespace App\Http\Controllers;

use App\Models\SatuanModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class SatuanController extends Controller
{
    public function index(): View
    {
        return view('master.satuan.index');
    }

    public function getData(Request $request)
    {
        $columns = ['created_at'];
        $totalData = SatuanModel::count();
        $search = $request->input('search.value');
        $query = SatuanModel::select('*');
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('satuan', 'like', "%{$search}%");
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
                $Data['satuan'] =  $r->satuan;
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
        return view('master.satuan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            SatuanModel::create(["satuan" => $request->inpNama]);
            $rs = response()->json([
                'success' => true,
                'message' => "New Satuan is added successfully."
            ]);
        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => "There was an error creating the satuan."
            ]);
        }
        return $rs;

        // return redirect()->route('datamaster.merek')
        //         ->withSuccess('New Merek is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($satuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($satuan)
    {
        $data = [
            'res' => SatuanModel::find($satuan)
        ];
        return view('master.satuan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $merek)
    {
        try {
            SatuanModel::find($merek)->update(["satuan" => $request->inpNama]);
            $rs = response()->json([
                'success' => true,
                'message' => "Satuan is successfully updated."
            ]);
        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => "There was an error updated the satuan."
            ]);
        }
        return $rs;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($merek)
    {
        $del = SatuanModel::find($merek)->delete();
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

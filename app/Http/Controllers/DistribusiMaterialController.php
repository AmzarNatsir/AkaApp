<?php

namespace App\Http\Controllers;

use App\Models\CabangModel;
use App\Models\Material;
use Illuminate\Http\Request;

class DistribusiMaterialController extends Controller
{
    public function list()
    {
        $data = [
            'gudang_utama' => Material::get()->sum('stok_akhir'),
            'list_cabang' => CabangModel::where('aktif', 'y')->get()
        ];
        return view('distribusi_material.list', $data);
    }
}

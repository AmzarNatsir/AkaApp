<?php

namespace App\Http\Controllers;

use App\Models\ArusKasModel;
use App\Models\KasKeluarModel;
use App\Models\KasMasukModel;
use App\Traits\GenerateNumber;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Str;

class KeuanganController extends Controller
{
    use GenerateNumber;
    //kas masuk
    public function kasMasuk()
    {
        return view('keuangan.kas_masuk.index');
    }
    public function getDataKasMasuk(Request $request)
    {
        $toDay = date("Y-m-d");
        $columns = ['created_at'];
        $totalData = KasMasukModel::count();
        $search = $request->input('search.value');
        $tglMulai = $request->input('tglStart');
        $tglSampai = $request->input('tglEnd');
        $query = KasMasukModel::select('*');
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('no_transaksi', 'like', "%{$search}%")
                ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }
        if(!empty($tglMulai) && !empty($tglSampai)) {
            $query->WhereDate('tgl_transaksi', '>=', "{$tglMulai}")
                ->WhereDate('tgl_transaksi', '<=', "{$tglSampai}");
        } else {
            $query->WhereDate('tgl_transaksi', '=', "{$toDay}");
        }
        // dd($query->toSql());
        $totalFiltered = $query->count();
        $query = $query->offset($request->input('start'))
                      ->limit($request->input('length'))
                      ->orderBy($columns[$request->input('order.0.column')], $request->input('order.0.dir'))
                        ->orderBy('tgl_transaksi', 'desc')
                      ->get();

        $data = array();
        if($query){
            $counter = $request->input('start') + 1;
            foreach($query as $r){
                $action = '<ul class="action">';
                    if(auth()->user()->can("trans_keuangan_kas_masuk_edit")) {
                    $action .= '<li class="edit"> <a href="javascript:void(0)" onclick="editData('.$r->id.')" data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap" data-whatever="@getbootstrap"><i class="icon-pencil-alt"></i></a></li>';
                }
                if(auth()->user()->can("trans_keuangan_kas_masuk_delete")) {
                    $action .= '<li class="delete"><a href="javascript:void(0)" value="'.$r->id.'" id="btn_delete" onclick="konfirmDelete('.$r->id.')"><i class="icon-trash"></i></a></li>';
                    }
                $action .= '</ul>';
                $Data['act'] = $action;
                $Data['id'] =  $r->id;
                $Data['tgl_transaksi'] = date('d-m-Y', strtotime($r->tgl_transaksi));
                $Data['no_transaksi'] = $r->no_transaksi;
                $Data['keterangan'] = $r->keterangan;
                $Data['nominal'] = number_format($r->nominal, 0);
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
    public function kasMasukBaru()
    {
        return view('keuangan.kas_masuk.baru');
    }
    public function kasMasukSimpan(Request $request)
    {
        DB::beginTransaction();
        try {
            $uUIDH = Str::uuid();
            $uUIDAK = Str::uuid();
            $data = [
                'uuid' => $uUIDH,
                'tgl_transaksi' => $request->inpTanggal,
                'no_transaksi' => GenerateNumber::generateNoKas("in", $request->inpTanggal),
                'keterangan' => $request->inpKeterangan,
                'nominal' => str_replace(",","", $request->inpNominal),
                'id_user' => auth()->user()->id,
                'created_at' => date("Y-m-d H:i:s")
            ];
            KasMasukModel::create($data);
            //insert to arus kas
            $dataAK = [
                'uuid' => $uUIDAK,
                'no_ref' => $uUIDH,
                'tgl_transaksi' => $request->inpTanggal,
                'keterangan' => $request->inpKeterangan,
                'debet' => str_replace(",","", $request->inpNominal),
                'kredit' => 0,
                'kategori_transaksi' => 'Kas Masuk',
                'id_user' => auth()->user()->id
            ];
            ArusKasModel::create($dataAK);
            DB::commit(); // Commit Transaction if everything is successful
            $rs = response()->json([
                'success' => true,
                'message' => "Data kas masuk berhasil disimpan."
            ]);
        } catch (Throwable $e) {
            DB::rollBack();
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data. ".$e->getMessage()
            ]);
        }
        return $rs;
    }
    public function kasMasukEdit($id)
    {
        $data = [
            "res" => KasMasukModel::find($id)
        ];
        return view('keuangan.kas_masuk.edit', $data);
    }
    public function kasMasukUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $refArusKas = $request->refArusKas;
            $idArusKas = ArusKasModel::where('no_ref',$refArusKas)->first()->id;
            $data = [
                'tgl_transaksi' => $request->inpTanggal,
                'keterangan' => $request->inpKeterangan,
                'nominal' => str_replace(",","", $request->inpNominal),
                'id_user' => auth()->user()->id
            ];
            KasMasukModel::find($id)->update($data);
            //insert to arus kas
            $dataAK = [
                'tgl_transaksi' => $request->inpTanggal,
                'keterangan' => $request->inpKeterangan,
                'debet' => str_replace(",","", $request->inpNominal),
                'id_user' => auth()->user()->id
            ];
            ArusKasModel::find($idArusKas)->update($dataAK);
            DB::commit(); // Commit Transaction if everything is successful
            $rs = response()->json([
                'success' => true,
                'message' => "Perubahan data kas masuk berhasil disimpan."
            ]);
        } catch (Exception $e) {
            // DB::rollBack();
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses pembaharuan data. ".$e->getMessage()
            ]);
        }
        return $rs;
    }
    public function kasMasukDelete($id)
    {
        DB::beginTransaction();
        try {
            $dataH = KasMasukModel::find($id);
            $idArusKas = ArusKasModel::where('no_ref',$dataH->uuid)->first()->id;
            $execDel = $dataH->delete();
            if($execDel) {
                ArusKasModel::find($idArusKas)->delete();
            }
            DB::commit(); // Commit Transaction if everything is successful
            $rs = response()->json([
                'success' => true,
                'message' => "Data kas masuk berhasil dihapus."
            ]);
        } catch (Exception $e) {
            // DB::rollBack();
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penghapusan data. ".$e->getMessage()
            ]);
        }
        return $rs;
    }

    //kas keluar
    public function kasKeluar()
    {
        return view('keuangan.kas_keluar.index');
    }
    public function getDataKasKeluar(Request $request)
    {
        $toDay = date("Y-m-d");
        $columns = ['created_at'];
        $totalData = KasKeluarModel::count();
        $search = $request->input('search.value');
        $tglMulai = $request->input('tglStart');
        $tglSampai = $request->input('tglEnd');
        $query = KasKeluarModel::select('*');
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('no_transaksi', 'like', "%{$search}%")
                ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }
        if(!empty($tglMulai) && !empty($tglSampai)) {
            $query->WhereDate('tgl_transaksi', '>=', "{$tglMulai}")
                ->WhereDate('tgl_transaksi', '<=', "{$tglSampai}");
        } else {
            $query->WhereDate('tgl_transaksi', '=', "{$toDay}");
        }
        // dd($query->toSql());
        $totalFiltered = $query->count();
        $query = $query->offset($request->input('start'))
                      ->limit($request->input('length'))
                      ->orderBy($columns[$request->input('order.0.column')], $request->input('order.0.dir'))
                        ->orderBy('tgl_transaksi', 'desc')
                      ->get();

        $data = array();
        if($query){
            $counter = $request->input('start') + 1;
            foreach($query as $r){
                $action = '<ul class="action">';
                if(auth()->user()->can("trans_keuangan_kas_keluar_edit")) {
                    $action .= '<li class="edit"> <a href="javascript:void(0)" onclick="editData('.$r->id.')" data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap" data-whatever="@getbootstrap"><i class="icon-pencil-alt"></i></a></li>';
                }
                if(auth()->user()->can("trans_keuangan_kas_keluar_delete")) {
                    $action .= '<li class="delete"><a href="javascript:void(0)" value="'.$r->id.'" id="btn_delete" onclick="konfirmDelete('.$r->id.')"><i class="icon-trash"></i></a></li>';
                }
                $action .= '</ul>';
                $Data['act'] = $action;
                $Data['id'] =  $r->id;
                $Data['tgl_transaksi'] = date('d-m-Y', strtotime($r->tgl_transaksi));
                $Data['no_transaksi'] = $r->no_transaksi;
                $Data['keterangan'] = $r->keterangan;
                $Data['nominal'] = number_format($r->nominal, 0);
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
    public function kasKeluarBaru()
    {
        return view('keuangan.kas_keluar.baru');
    }
    public function kasKeluarSimpan(Request $request)
    {
        DB::beginTransaction();
        try {
            $uUIDH = Str::uuid();
            $uUIDAK = Str::uuid();
            $data = [
                'uuid' => $uUIDH,
                'tgl_transaksi' => $request->inpTanggal,
                'no_transaksi' => GenerateNumber::generateNoKas("ot", $request->inpTanggal),
                'keterangan' => $request->inpKeterangan,
                'nominal' => str_replace(",","", $request->inpNominal),
                'id_user' => auth()->user()->id,
                'created_at' => date("Y-m-d H:i:s")
            ];
            KasKeluarModel::create($data);
            //insert to arus kas
            $dataAK = [
                'uuid' => $uUIDAK,
                'no_ref' => $uUIDH,
                'tgl_transaksi' => $request->inpTanggal,
                'keterangan' => $request->inpKeterangan,
                'debet' => 0,
                'kredit' => str_replace(",","", $request->inpNominal),
                'kategori_transaksi' => 'Kas Keluar',
                'id_user' => auth()->user()->id
            ];
            ArusKasModel::create($dataAK);
            DB::commit(); // Commit Transaction if everything is successful
            $rs = response()->json([
                'success' => true,
                'message' => "Data kas keluar berhasil disimpan."
            ]);
        } catch (Throwable $e) {
            DB::rollBack();
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data. ".$e->getMessage()
            ]);
        }
        return $rs;
    }
    public function kasKeluarEdit($id)
    {
        $data = [
            "res" => KasKeluarModel::find($id)
        ];
        return view('keuangan.kas_keluar.edit', $data);
    }
    public function kasKeluarUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $refArusKas = $request->refArusKas;
            $idArusKas = ArusKasModel::where('no_ref',$refArusKas)->first()->id;
            $data = [
                'tgl_transaksi' => $request->inpTanggal,
                'keterangan' => $request->inpKeterangan,
                'nominal' => str_replace(",","", $request->inpNominal),
                'id_user' => auth()->user()->id
            ];
            KasKeluarModel::find($id)->update($data);
            //insert to arus kas
            $dataAK = [
                'tgl_transaksi' => $request->inpTanggal,
                'keterangan' => $request->inpKeterangan,
                'kredit' => str_replace(",","", $request->inpNominal),
                'id_user' => auth()->user()->id
            ];
            ArusKasModel::find($idArusKas)->update($dataAK);
            DB::commit(); // Commit Transaction if everything is successful
            $rs = response()->json([
                'success' => true,
                'message' => "Perubahan data kas masuk berhasil disimpan."
            ]);
        } catch (Exception $e) {
            // DB::rollBack();
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses pembaharuan data. ".$e->getMessage()
            ]);
        }
        return $rs;
    }
    public function kaskeluarDelete($id)
    {
        DB::beginTransaction();
        try {
            $dataH = KasKeluarModel::find($id);
            $idArusKas = ArusKasModel::where('no_ref',$dataH->uuid)->first()->id;
            $execDel = $dataH->delete();
            if($execDel) {
                ArusKasModel::find($idArusKas)->delete();
            }
            DB::commit(); // Commit Transaction if everything is successful
            $rs = response()->json([
                'success' => true,
                'message' => "Data kas masuk berhasil dihapus."
            ]);
        } catch (Exception $e) {
            // DB::rollBack();
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penghapusan data. ".$e->getMessage()
            ]);
        }
        return $rs;
    }
}

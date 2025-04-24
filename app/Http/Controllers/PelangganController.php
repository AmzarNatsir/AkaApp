<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\PaketInternetModel;
use App\Models\PelangganModel;
use App\Models\PemakaianDetailModel;
use App\Models\PemakaianModel;
use App\Models\PemasanganDetailModel;
use App\Models\PetugasModel;
use App\Models\WilayahModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PelangganController extends Controller
{
    public function index(){
        return view('pelanggan.index');
    }

    public function getData(Request $request) {
        $columns = ['created_at'];
        $totalData = PelangganModel::where('aktif', 'y')->whereNull('status')->count();
        $search = $request->input('search.value');
        $query = PelangganModel::with(['getWilayah', 'getPaket'])->where('aktif', 'y')->whereNull('status');
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('nama_pelanggan', 'like', "%{$search}%");
            });
        }
        $totalFiltered = $query->count();
        $query = $query->offset($request->input('start'))
                      ->limit($request->input('length'))
                        ->orderBy('id', 'asc')
                      ->get();
        // dd($query);
        $data = array();
        if($query){
            $counter = $request->input('start') + 1;
            foreach($query as $r){
                $btn = "";
                $btn .= '<div class="btn-group">';
                $btn .="<button type='button' class='btn btn-info btn-sm' title='Proses' id='btn_proses' data-bs-toggle='modal' data-bs-target='#modalProses' data-whatever='@getbootstrap' value='".$r->id."'><i class='fa fa-gears'></i></button>";
                $btn .="<button type='button' class='btn btn-warning btn-sm' title='Detail' id='btn_show' data-bs-toggle='modal' data-bs-target='#exampleModalgetbootstrap' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-eye'></i></button>";
                if(auth()->user()->can("pelanggan_edit")) {
                    $btn .="<button type='button' class='btn btn-success btn-sm' title='Edit' id='btn_edit' data-bs-toggle='modal' data-bs-target='#exampleModalgetbootstrap' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-pencil-alt'></i></button>";
                }
                if(auth()->user()->can("pelanggan_delete")) {
                    $btn .= "<button type='button' class='btn btn-danger btn-sm' title='Hapus' id='btn_delete' value='".$r->id."' onclick='konfirmDelete(this)'><i class='icon-trash'></i></button>";
                }
                $btn .='</div>';
                $Data['act'] = $btn;
                $Data['id'] =  $r->id;
                $Data['nama_pelanggan'] =  $r->nama_pelanggan;
                $Data['alamat'] =  $r->alamat;
                $Data['no_telepon'] =  $r->no_telepon_1." / ".$r->no_telepon_2;
                $Data['wilayah'] =  $r->getWilayah->wilayah;
                $Data['paket_internet'] =  $r->getPaket->nama_paket;
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
    public function create(){
        $data = [
            'listWilayah' => WilayahModel::all(),
            'listPaket' => PaketInternetModel::where('aktif', 'y')->get()
        ];
        return view('pelanggan.create', $data);
    }
    public function store(Request $request){
        try {
            PelangganModel::create([
                "nama_pelanggan" => $request->inpNama,
                "alamat" => $request->inpAlamat,
                "no_telepon_1" => $request->inpNotel_1,
                "no_telepon_2" => $request->inpNotel_2,
                "wilayah" => $request->selectWilayah,
                "paket_internet" => $request->selectpaket,
                "aktif" => 'y',
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

    public function show($id)
    {
        $data = [
            'res' => PelangganModel::with(['getWilayah', 'getPaket'])->find($id)
        ];
        return view('pelanggan.show', $data);
    }

    public function edit($id) {
        $data = [
            'res' => PelangganModel::find($id),
            'listWilayah' => WilayahModel::all(),
            'listPaket' => PaketInternetModel::where('aktif', 'y')->get()
        ];
        return view('pelanggan.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $updateExec = PelangganModel::find($id)->update([
                "nama_pelanggan" => $request->inpNama,
                "alamat" => $request->inpAlamat,
                "no_telepon_1" => $request->inpNotel_1,
                'no_telepon_2' => $request->inpNotel_2,
                'wilayah' => $request->selectWilayah,
                'paket_internet' => $request->selectpaket,
            ]);
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
                'message' => "Terdapat error pada proses penyimpanan data"
            ]);
        }
        return $rs;
    }

    public function destroy($id)
    {
        $del = PelangganModel::find($id)->update(['aktif' => 't']);
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

    //proses pemasangan tahap 1 - pengaturan awal
    public function proses($id){
        $gudang=1;
        if($gudang==1) {
            $list_material = Material::with(['getMerek'])->get();
        }
        $data = [
            'res' => PelangganModel::with(['getWilayah', 'getPaket'])->find($id),
            'listPetugas' => PetugasModel::where('aktif', 'y')->get(),
            'listMaterial' => $list_material
        ];
        return view('pelanggan.pemasangan.proses', $data);
    }

    public function storeProses(Request $request)
    {
        DB::beginTransaction();
        try {
            $dataH = [
                "tanggal" => $request->inpTanggal,
                "kategori_id" => $request->pilKategori,
                "wilayah_id" => $request->idWilayahPelanggan,
                "petugas" => implode(',', $request->pilPetugas),
                "keterangan" => $request->inpKeterangan,
                "user_id" => auth()->user()->id,
                "gudang_id" => $request->gudangID,
                "id_pelanggan" => $request->idPelanggan,
            ];
            $saveH = PemakaianModel::create($dataH);
            $lastID = $saveH->id;
            $jml_item = count($request->item_id_material);
            foreach(array($request) as $key => $value)
            {
                for($i=0; $i<$jml_item; $i++)
                {
                    $dataD = [
                        "head_id" => $lastID,
                        "material_id" => $value['item_id_material'][$i],
                        "jumlah" => $value['item_qty'][$i],
                        "harga" => $value['current_harga'][$i],
                        "gudang_id" => $request->gudangID,
                    ];
                    PemakaianDetailModel::create($dataD);
                    //update stok
                    if($request->gudangID==1)
                    {
                        $updateStok = Material::find($value['item_id_material'][$i]);
                        $updateStok->stok_akhir -= str_replace(",","", $value['item_qty'][$i]);
                        $updateStok->update();
                    }
                }

            }
            //update ststus pelanggan
            $updatePelanggan = PelangganModel::find($request->idPelanggan);
            $updatePelanggan->status = 'onProses';
            $updatePelanggan->update();
            DB::commit(); // Commit Transaction if everything is successful
            $rs = response()->json([
                'success' => true,
                'message' => "Data pemakaian material berhasil disimpan."
            ]);

        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data.".$e->getMessage()
            ]);
        }
        return $rs;
    }

    public function monitoring()
    {
        return view('pelanggan.pemasangan.monitoring');
    }

    public function getDataMonitoring(Request $request){
        $columns = ['created_at'];
        $totalData = PelangganModel::where('aktif', 'y')->whereNotNull('status')->count();
        $search = $request->input('search.value');
        $query = PelangganModel::with(['getWilayah', 'getPaket'])->where('aktif', 'y')->whereNotNull('status');
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('nama_pelanggan', 'like', "%{$search}%");
            });
        }
        $totalFiltered = $query->count();
        $query = $query->offset($request->input('start'))
                      ->limit($request->input('length'))
                        ->orderBy('id', 'asc')
                      ->get();
        // dd($query);
        $data = array();
        if($query){
            $counter = $request->input('start') + 1;
            foreach($query as $r){
                $btn = "";
                $btn .= '<div class="btn-group">';
                if($r->status=="onProses") {
                    $btn .="<button type='button' class='btn btn-info btn-sm' title='Proses' id='btn_proses' data-bs-toggle='modal' data-bs-target='#modalProses' data-whatever='@getbootstrap' value='".$r->id."'><i class='fa fa-gears'></i></button>";
                }
                if($r->status=="onCanceled" || empty($r->status)) {
                    $btn .="<button type='button' class='btn btn-warning btn-sm' title='Detail' id='btn_show' data-bs-toggle='modal' data-bs-target='#modalProses' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-eye'></i></button>";
                }
                if($r->status=="onCompleted") {
                    $btn .="<button type='button' class='btn btn-danger btn-sm' title='Proses Aktivasi' id='btn_proses_aktivasi' data-bs-toggle='modal' data-bs-target='#modalAktivasi' data-whatever='@getbootstrap' value='".$r->id."'><i class='fa fa-gears'></i> Aktivasi</button>";
                }
                $btn .='</div>';
                if(empty($r->status)) {
                    $status = "<div class='badge-light-primary product-sub badge rounded-pill'>Registrasi</div>";
                } elseif($r->status=="onProses") {
                    $status = "<div class='badge-light-secondary product-sub badge rounded-pill'>".$r->status."</div>";
                } elseif($r->status=="onCompleted") {
                    $status = "<div class='badge-light-info product-sub badge rounded-pill'>".$r->status."</div>";
                } elseif($r->status=="onFinished") {
                    $status = "<div class='badge-light-success product-sub badge rounded-pill'>".$r->status."</div>";
                } else {
                    $status = "<div class='badge-light-danger product-sub badge rounded-pill'>".$r->status."</div>";
                }
                $nama_pelanggan = '<div class="inbox-user"><p>'.$r->nama_pelanggan.'</p></div>';
                $alamat_pelanggan = '<div class="inbox-message">
                                  <div class="email-data"><span><i class="fa fa-location-arrow"></i> '.$r->alamat.'<br>Wilayah : '.$r->getWilayah->wilayah.'<span><br>
                                    <i class="fa fa-phone"></i> '.$r->no_telepon_1.' / '.$r->no_telepon_2.'<br>
                                  </div>
                                </div>';
                $dataHPemakaian = PemakaianModel::where('id_pelanggan', $r->id)->first();
                $petugasArray = explode(',', $dataHPemakaian->petugas);
                $petugas = PetugasModel::whereIn('id', $petugasArray)->pluck('nama_petugas', 'id');
                $petugasArray = [];
                foreach ($petugas as $key => $value) {
                    $petugasArray[] = $value;
                }
                $allPetugas = (count($petugasArray) > 0) ? (implode(',', $petugasArray)) : " - ";
                $Data['act'] = $btn;
                $Data['id'] =  $r->id;
                $Data['nama_pelanggan'] =  $nama_pelanggan;
                $Data['alamat'] =  $alamat_pelanggan;
                $Data['petugas'] =  $allPetugas;
                $Data['paket_internet'] =  $r->getPaket->nama_paket;
                $Data['status'] =  $status;
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
    public function showDetail($id) {
        $dataHPemakaian = PemakaianModel::where('id_pelanggan', $id)->first();
        $petugasArray = explode(',', $dataHPemakaian->petugas);

        // Get all petugas in one query
        $petugas = PetugasModel::whereIn('id', $petugasArray)->pluck('nama_petugas', 'id');

        // Map IDs to names (preserving order)
        $petugasArray = [];
        foreach ($petugas as $key => $value) {
            $petugasArray[] = $value;
        }
        $allPetugas = (count($petugasArray) > 0) ? (implode(',', $petugasArray)) : "-";
        $data = [
            'res' => PelangganModel::with(['getWilayah', 'getPaket'])->find($id),
            'listPetugas' => PetugasModel::where('aktif', 'y')->get(),
            'pemakaian' => $dataHPemakaian,
            'listPemakaianMaterial' => PemakaianDetailModel::with(['getMaterial'])->where('head_id', $dataHPemakaian->id)->get(),
            'petugas' => $allPetugas
        ];
        // dd($data);
        return view('pelanggan.pemasangan.detail', $data);
    }

    public function showFormAktivasi($idPelanggan)
    {
        $data = [
            'pelanggan' => PelangganModel::with([
                'getWilayah',
                'getPaket'
            ])->find($idPelanggan),
            'pemakaian_material' => PemakaianModel::where('id_pelanggan', $idPelanggan)->first(),
            'pemasangan_detail' => PemasanganDetailModel::where('id_pelanggan', $idPelanggan)->first()
        ];
        return view('pelanggan.pemasangan.form_aktivasi', $data);
    }
    public function storeAktivasi(Request $request)
    {
        try {
            $data = [
                'tgl_finished' => $request->inpTanggalAktivasi,
                'status' => 'onFinished'
            ];
            PelangganModel::find($request->id_pelanggan)->update($data);
            $rs = response()->json([
                'success' => true,
                'message' => "Data pemakaian material berhasil disimpan."
            ]);
        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data.".$e->getMessage()
            ]);
        }
        return $rs;
    }
}

<?php

namespace App\Http\Controllers;

use App\Imports\PelangganImport;
use App\Models\ArusKasModel;
use App\Models\KasKeluarModel;
use App\Models\KasMasukModel;
use App\Models\Material;
use App\Models\PaketInternetModel;
use App\Models\PelangganModel;
use App\Models\PemakaianDetailModel;
use App\Models\PemakaianModel;
use App\Models\PemasanganDetailModel;
use App\Models\PembayaranPelangganModel;
use App\Models\PetugasModel;
use App\Models\WilayahModel;
use App\Traits\General;
use App\Traits\GenerateNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class PelangganController extends Controller
{
    use GenerateNumber;
    use General;
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
                        ->orderBy('created_at', 'asc')
                        ->orderBy('nama_pelanggan', 'asc')
                      ->get();
        // dd($query);
        $data = array();
        if($query){
            $counter = $request->input('start') + 1;
            foreach($query as $r){
                $btn = "";
                $btn .= '<div class="btn-group">';
                $btn .="<button type='button' class='btn btn-warning btn-sm' title='Detail' id='btn_show' data-bs-toggle='modal' data-bs-target='#exampleModalgetbootstrap' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-eye'></i></button>";
                if(auth()->user()->can("pelanggan_edit")) {
                    $btn .="<button type='button' class='btn btn-success btn-sm' title='Edit' id='btn_edit' data-bs-toggle='modal' data-bs-target='#exampleModalgetbootstrap' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-pencil-alt'></i></button>";
                }
                if(auth()->user()->can("pelanggan_delete")) {
                    $btn .= "<button type='button' class='btn btn-danger btn-sm' title='Hapus' id='btn_delete' value='".$r->id."' onclick='konfirmDelete(this)'><i class='icon-trash'></i></button>";
                }
                if(!empty($r->wilayah) || (!empty($r->paket_internet)))
                {
                    $btn .="<button type='button' class='btn btn-info btn-sm' title='Proses' id='btn_proses' data-bs-toggle='modal' data-bs-target='#modalProses' data-whatever='@getbootstrap' value='".$r->id."'><i class='fa fa-gears'></i></button>";
                    $btn .="<button type='button' class='btn btn-success btn-sm' title='Aktivasi' id='btn_aktivasi' value='".$r->id."'><i class='fa fa-calendar'></i></button>";
                }
                $btn .='</div>';
                $Data['act'] = $btn;
                $Data['id'] =  $r->id;
                $Data['nama_pelanggan'] =  $r->nama_pelanggan;
                $Data['alamat'] =  $r->alamat;
                $Data['no_telepon'] =  $r->no_telepon_1." / ".$r->no_telepon_2;
                $Data['wilayah'] = (empty($r->wilayah)) ? "" : $r->getWilayah->wilayah;
                $Data['paket_internet'] = (empty($r->paket_internet)) ? "" : $r->getPaket->nama_paket;
                $Data['sales'] = (empty($r->nama_sales)) ? "-" : $r->nama_sales;
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
                "nama_sales" => $request->inpNamaSales,
                "no_telepon_sales" => $request->inpNotelSales,
                "no_rekening_sales" => $request->inpNorekSales,
                "nama_bank" => $request->inpNamaBankSales,
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
                "nama_sales" => $request->inpNamaSales,
                "no_telepon_sales" => $request->inpNotelSales,
                "no_rekening_sales" => $request->inpNorekSales,
                "nama_bank" => $request->inpNamaBankSales,
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

    public function aktivasi($id)
    {
        $gudang=1;
        if($gudang==1) {
            $list_material = Material::with(['getMerek'])->get();
        }
        $data = [
            'pelanggan' => PelangganModel::with([
                'getWilayah',
                'getPaket'
            ])->find($id),
            'pemakaian' => PemakaianModel::where('id_pelanggan', $id)->first(),
            'listPetugas' => PetugasModel::where('aktif', 'y')->get(),
            'listMaterial' => $list_material
        ];
        return view('pelanggan.aktivasi', $data);
    }
    //daftar pelanggan aktif
    public function daftar()
    {
        return view('pelanggan.daftar.list');
    }
    public function getDataPelangganAktif(Request $request) {
        $columns = ['created_at'];
        $totalData = PelangganModel::where('aktif', 'y')->where('status', 'onFinished')->count();
        $search = $request->input('search.value');
        $query = PelangganModel::with(['getWilayah', 'getPaket'])->where('aktif', 'y')->where('status', 'onFinished');
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('nama_pelanggan', 'like', "%{$search}%");
            });
        }
        $totalFiltered = $query->count();
        $query = $query->offset($request->input('start'))
                      ->limit($request->input('length'))
                      ->orderBy('tgl_finished', 'desc')
                      ->get();
        // dd($query);
        $data = array();
        if($query){
            $counter = $request->input('start') + 1;
            foreach($query as $r){
                $queryPemasangan = PemasanganDetailModel::where('id_pelanggan', $r->id)->first();
                $tgl_aktivasi = (empty($queryPemasangan->tgl_aktivasi)) ? "" : date('d-m-Y', strtotime($queryPemasangan->tgl_aktivasi));
                $btn = "";
                $btn .= '<div class="btn-group">';
                $btn .="<button type='button' class='btn btn-info btn-sm' title='Profil' id='btn_profil' data-bs-toggle='modal' data-bs-target='#modalProfil' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-user'></i></button>";
                if(auth()->user()->can("pelanggan_edit")) {
                    $btn .="<button type='button' class='btn btn-success btn-sm' title='Perbaharui Data' id='btn_edit' value='".$r->id."'><i class='fa fa-pencil'></i></button>";
                }
                $btn .="<button type='button' class='btn btn-primary btn-sm' title='Pembayaran' id='btn_pembayaran' data-bs-toggle='modal' data-bs-target='#modalPembayaran' data-whatever='@getbootstrap' value='".$r->id."'><i class='fa fa-money'></i></button>";
                if(auth()->user()->can("pelanggan_delete")) {
                    $btn .= "<button type='button' class='btn btn-danger btn-sm' title='Hapus' id='btn_delete' value='".$r->id."' onclick='konfirmDelete(this)'><i class='icon-trash'></i></button>";
                }
                $btn .='</div>';
                $Data['act'] = $btn;
                $Data['id'] =  $r->id;
                $Data['nama_pelanggan'] =  $r->nama_pelanggan;
                $Data['alamat'] =  $r->alamat;
                $Data['no_telepon'] =  $r->no_telepon_1." / ".$r->no_telepon_2;
                $Data['wilayah'] = (empty($r->wilayah)) ? "" : $r->getWilayah->wilayah;
                $Data['paket_internet'] = (empty($r->paket_internet)) ? "" : $r->getPaket->nama_paket;
                $Data['sales'] = (empty($r->nama_sales)) ? "-" : $r->nama_sales;
                $Data['tgl_aktivasi'] = $tgl_aktivasi;
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
    public function profilPelanggan($id)
    {
        $resPemakaian = PemakaianModel::where('id_pelanggan', $id)->first();
        $data = [
            'pelanggan' => PelangganModel::with([
                'getWilayah',
                'getPaket'
            ])->find($id),
            'pemakaian' => $resPemakaian,
            'listPetugas' => PetugasModel::where('aktif', 'y')->get(),
            'pemasangan_detail' => PemasanganDetailModel::where('id_pelanggan', $id)->first(),
            'pemakaian_material' => PemakaianDetailModel::with(['getMaterial'])->where('head_id', $resPemakaian->id)->get(),
            'qty_material' => PemakaianDetailModel::where('head_id', $resPemakaian->id)->sum('jumlah')
        ];
        // dd($data);
        return view('pelanggan.daftar.profil', $data);
    }
    //daftar pelanggan
    public function editPelanggan($id)
    {
        $gudang=1;
        if($gudang==1) {
            $list_material = Material::with(['getMerek', 'getSatuan'])->get();
        }
        $resPemakaian = PemakaianModel::where('id_pelanggan', $id)->first();
        $data = [
            'pelanggan' => PelangganModel::with([
                'getWilayah',
                'getPaket'
            ])->find($id),
            'pemakaian' => $resPemakaian,
            'listPetugas' => PetugasModel::where('aktif', 'y')->get(),
            'listMaterial' => $list_material,
            'pemasangan_detail' => PemasanganDetailModel::where('id_pelanggan', $id)->first(),
            'pemakaian_material' => PemakaianDetailModel::with(['getMaterial'])->where('head_id', $resPemakaian->id)->get(),
            'qty_material' => PemakaianDetailModel::where('head_id', $resPemakaian->id)->sum('jumlah'),
            'listWilayah' => WilayahModel::all(),
            'listPaket' => PaketInternetModel::where('aktif', 'y')->get()
        ];
        return view('pelanggan.daftar.form_pembaharuan_data', $data);
    }
    public function showPembayaranPelanggan($id)
    {
        $data = [
            'pelanggan' => PelangganModel::with([
                'getWilayah',
                'getPaket'
            ])->find($id),
            'detail' => PemasanganDetailModel::where('id_pelanggan', $id)->first(),
            'list_pembayaran' => PembayaranPelangganModel::where('id_pelanggan', $id)->get(),
            'total_pembayaran' => PembayaranPelangganModel::where('id_pelanggan', $id)->sum('nominal')
        ];
        return view('pelanggan.daftar.list_pembayaran', $data);
    }

    public function simpanAktivasi(Request $request)
    {
        DB::beginTransaction();
        try {
            $fileRumah = General::handleNewFileUpload($request, 'fileRumah', 'gambar_rumah', 1);
            $fileODP = General::handleNewFileUpload($request, 'fileODP', 'gambar_odp', 2);
            $fileOntTerpasang = General::handleNewFileUpload($request, 'fileOntTerpasang', 'gambar_ont_terpasang', 3);
            $fileOntBelakang = General::handleNewFileUpload($request, 'fileOntBelakang', 'gambar_ont_belakang', 4);
            $fileRedamanDiOdp = General::handleNewFileUpload($request, 'fileRedamanDiOdp', 'gambar_redaman_odp', 5);
            $fileRedamanRumahPelanggan = General::handleNewFileUpload($request, 'fileRedamanRumahPelanggan', 'gambar_redaman_rumah_pelanggan', 6);
            $fileLainnya = General::handleNewFileUpload($request, 'fileLainnya', 'gambar_lainnya', 7);
            $dataH = [
                "tanggal" => date('Y-m-d'),
                "kategori_id" => 1, //pemasangan baru
                "wilayah_id" => $request->id_wilayah,
                "petugas" => implode(',', $request->pilPetugas),
                "keterangan" => "Pemasangan Baru (Pelanggan Lama)",
                "user_id" => auth()->user()->id,
                "gudang_id" => $request->gudangID,
                "id_pelanggan" => $request->id_pelanggan,
            ];
            $saveH = PemakaianModel::create($dataH);
            $id_pemakaian = $saveH->id;

            $dataPemasangan = [
                'id_pelanggan' => $request->id_pelanggan,
                'id_pemakaian' => $id_pemakaian,
                'sn_ont' => $request->inpSN_ONT,
                'model_ont' => $request->inpModel_ONT,
                'odp' => $request->inpODP,
                'tikor_odp' => $request->inpTikorODP,
                'tikor_pelanggan' => $request->inpTikorPelanggan,
                'port' => $request->inpPort,
                'port_ifle' => $request->inpPortIfle,
                'splitter' => $request->inpSplitter,
                'kabel_dc' => $request->inpKabelDC,
                'gambar_rumah' => $fileRumah,
                'gambar_odp' => $fileODP,
                'gambar_ont_terpasang' => $fileOntTerpasang,
                'gambar_belakang_ont' => $fileOntBelakang,
                'gambar_redaman_odp' => $fileRedamanDiOdp,
                'gambar_redaman_rumah_pelanggan' => $fileRedamanRumahPelanggan,
                'gambar_lainnya' => $fileLainnya,
                'user_id' => auth()->user()->id,
                'tgl_aktivasi' => $request->inpTanggalAktivasi
            ];
            PemasanganDetailModel::create($dataPemasangan);
            if($request->totalItem > 0)
            {
                $jml_item = count($request->item_id_material);
                foreach(array($request) as $key => $value)
                {
                    for($i=0; $i<$jml_item; $i++)
                    {
                        $dataD = [
                            "head_id" => $id_pemakaian,
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
            }
            PelangganModel::find($request->id_pelanggan)->update([
                'status' => 'onFinished',
                'tgl_finished' => $request->inpTanggalAktivasi,
                'tgl_completed' => $request->inpTanggalAktivasi,
                'petugas' => implode(',', $request->pilPetugas)
            ]);

            DB::commit();
            $rs = response()->json([
                'success' => true,
                'message' => "Data berhasil disimpan."
            ]);
        } catch (Throwable $e) {
            DB::rollBack(); // Rollback transaction on error
            // Log the error for debugging
            // \Log::error('Transaction failed: '.$e->getMessage());
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data. error: ".$e->getMessage()
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
            DB::rollBack();
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
        $totalData = PelangganModel::where('aktif', 'y')->whereIn('status', ['onProses', 'onCompleted', 'onCanceled'])->count();
        $search = $request->input('search.value');
        $query = PelangganModel::with(['getWilayah', 'getPaket'])->where('aktif', 'y')->whereIn('status', ['onProses', 'onCompleted', 'onCanceled']);
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
                if(empty($r->status)) {
                    $btn .="<button type='button' class='btn btn-info btn-sm' title='Proses' id='btn_proses' data-bs-toggle='modal' data-bs-target='#modalProses' data-whatever='@getbootstrap' value='".$r->id."'><i class='fa fa-gears'></i></button>";
                }
                if($r->status=="onCanceled" || empty($r->status)) {
                    $btn .="<button type='button' class='btn btn-danger btn-sm' title='Detail' id='btn_show' data-bs-toggle='modal' data-bs-target='#modalProses' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-user'></i> Detail</button>";
                    if(auth()->user()->can("pelanggan_delete")) {
                        $btn .= "<button type='button' class='btn btn-danger btn-sm' title='Hapus' id='btn_delete' value='".$r->id."' onclick='konfirmDelete(this)'><i class='icon-trash'></i></button>";
                    }
                }
                if($r->status=="onCompleted") {
                    $btn .="<button type='button' class='btn btn-info btn-sm' title='Proses Aktivasi' id='btn_proses_aktivasi' data-bs-toggle='modal' data-bs-target='#modalAktivasi' data-whatever='@getbootstrap' value='".$r->id."'><i class='fa fa-gears'></i> Aktivasi</button>";
                }
                if($r->status=="onFinished") {
                    $btn .="<button type='button' class='btn btn-success btn-sm' title='Detail Pelanggan' id='btn_detail_finished' data-bs-toggle='modal' data-bs-target='#modalAktivasi' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-user'></i> Detail</button>";
                    $btn .="<button type='button' class='btn btn-primary btn-sm' title='Pembaharuan Data' id='btn_update_data' value='".$r->id."'><i class='icon-pencil'></i> Update</button>";
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
        DB::beginTransaction();
        try {
            $fee_sales = NULL;
            if($request->inpFeeSales > 0)
            {
                $fee_sales = str_replace(",","", $request->inpFeeSales);
            }
            $data = [
                'tgl_finished' => date('Y-m-d'),
                'status' => 'onFinished',
                'fee_sales' => $fee_sales
            ];
            PelangganModel::find($request->id_pelanggan)->update($data);
            PemasanganDetailModel::find($request->id_pemasangan)->update([
                'tgl_aktivasi' => $request->inpTanggalAktivasi
            ]);
            //kas masuk
            $uUIDH = Str::uuid();
            $uUIDAK = Str::uuid();
            $ket_kas_masuk = "Pembayaran awal pelanggan an. " . $request->id_nama_pelanggan;
            $data = [
                'uuid' => $uUIDH,
                'tgl_transaksi' => $request->inpTanggalAktivasi,
                'no_transaksi' => GenerateNumber::generateNoKas("in", $request->inpTanggalAktivasi),
                'keterangan' => $ket_kas_masuk,
                'nominal' => str_replace(",","", $request->inpPembayaranAwal),
                'id_user' => auth()->user()->id,
                'created_at' => date("Y-m-d H:i:s")
            ];
            KasMasukModel::create($data);
            //insert to arus kas
            $dataAK = [
                'uuid' => $uUIDAK,
                'no_ref' => $uUIDH,
                'tgl_transaksi' => $request->inpTanggalAktivasi,
                'keterangan' => $ket_kas_masuk,
                'debet' => str_replace(",","", $request->inpPembayaranAwal),
                'kredit' => 0,
                'kategori_transaksi' => 'Kas Masuk',
                'id_user' => auth()->user()->id
            ];
            ArusKasModel::create($dataAK);
            //kas keluar jika nominal fee sales terisi
            if($request->inpFeeSales > 0)
            {
                $ket_kas_keluar = "Pembayaran fee sales an. " . $request->id_nama_sales. " untuk pemasangan pelanggan an. " .$request->id_nama_pelanggan;
                $uUIDH_2 = Str::uuid();
                $uUIDAK_2 = Str::uuid();
                $data = [
                    'uuid' => $uUIDH_2,
                    'tgl_transaksi' => $request->inpTanggalAktivasi,
                    'no_transaksi' => GenerateNumber::generateNoKas("ot", $request->inpTanggalAktivasi),
                    'keterangan' => $ket_kas_keluar,
                    'nominal' => str_replace(",","", $request->inpFeeSales),
                    'id_user' => auth()->user()->id,
                    'created_at' => date("Y-m-d H:i:s")
                ];
                KasKeluarModel::create($data);
                //insert to arus kas
                $dataAK = [
                    'uuid' => $uUIDAK_2,
                    'no_ref' => $uUIDH_2,
                    'tgl_transaksi' => $request->inpTanggalAktivasi,
                    'keterangan' => $ket_kas_keluar,
                    'debet' => 0,
                    'kredit' => str_replace(",","", $request->inpFeeSales),
                    'kategori_transaksi' => 'Kas Keluar',
                    'id_user' => auth()->user()->id
                ];
                ArusKasModel::create($dataAK);
            }
            DB::commit(); // Commit Transaction if everything is successful
            $rs = response()->json([
                'success' => true,
                'message' => "Data pemakaian material berhasil disimpan."
            ]);
        } catch (Throwable $e) {
            DB::rollBack();
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data.".$e->getMessage()
            ]);
        }
        return $rs;
    }
    public function showDetaiPelangganFinished($idPelanggan)
    {
        $data = [
            'pelanggan' => PelangganModel::with([
                'getWilayah',
                'getPaket'
            ])->find($idPelanggan),
            'pemakaian_material' => PemakaianModel::where('id_pelanggan', $idPelanggan)->first(),
            'pemasangan_detail' => PemasanganDetailModel::where('id_pelanggan', $idPelanggan)->first()
        ];
        return view('pelanggan.pemasangan.detail_finished', $data);
    }

    //pencarian
    public function pembayaran()
    {
        return view('pelanggan.pembayaran.index');
    }

    public function getPelanggan(Request $request)
        {
        $search = $request->get('q');

        $results = PelangganModel::where('status', 'onFinished')
            ->where('aktif', 'y')
            ->where(function ($query) use ($search) {
                $query->where('nama_pelanggan', 'LIKE', "%$search%")
                ->orWhere('no_telepon_1', 'LIKE', "%$search%");
            })
            ->select('id', DB::raw("
                CONCAT(nama_pelanggan, ' - ', alamat) as text
            "))
            ->limit(10)
            ->get();

        return response()->json($results);
        // ->select('id', DB::raw("
        //         CASE
        //             WHEN no_telepon_1 IS NOT NULL AND no_telepon_1 != '' AND no_telepon_2 IS NOT NULL AND no_telepon_2 != ''
        //                 THEN CONCAT(nama_pelanggan, ' - ', no_telepon_1, ' / ', no_telepon_2, ' - ', alamat)
        //             WHEN no_telepon_1 IS NOT NULL AND no_telepon_1 != ''
        //                 THEN CONCAT(nama_pelanggan, ' - ', no_telepon_1, ' - ', alamat)
        //             WHEN no_telepon_2 IS NOT NULL AND no_telepon_2 != ''
        //                 THEN CONCAT(nama_pelanggan, ' - ', no_telepon_2, ' - ', alamat)
        //             ELSE CONCAT(nama_pelanggan, ' - ', alamat)
        //         END as text
        //     "))
    }

    public function detailPelanggan($id)
    {
        $data = [
            'pelanggan' => PelangganModel::with([
                'getWilayah',
                'getPaket'
            ])->find($id),
            'detail' => PemasanganDetailModel::where('id_pelanggan', $id)->first(),
            'list_pembayaran' => PembayaranPelangganModel::where('id_pelanggan', $id)->get(),
            'total_pembayaran' => PembayaranPelangganModel::where('id_pelanggan', $id)->sum('nominal')
        ];
        return view('pelanggan.pembayaran.form_pembayaran', $data);
    }

    public function storePembayaran(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                "tgl_bayar" => $request->inpTanggal,
                "id_pelanggan" => $request->idPelanggan,
                "id_pemasangan" => $request->idPemasangan,
                "nominal" => str_replace(",","", $request->inpNominal),
                "id_user" => auth()->user()->id
            ];
            PembayaranPelangganModel::create($data);
            DB::commit(); // Commit Transaction if everything is successful
            $rs = response()->json([
                'success' => true,
                'message' => "Data pembayaran pelanggan berhasil disimpan."
            ]);
        } catch (Throwable $e) {
            DB::rollBack();
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data.".$e->getMessage()
            ]);
        }
        return $rs;
    }

    //pembaharuan data
    public function pembaharuanData($id)
    {
        $gudang=1;
        if($gudang==1) {
            $list_material = Material::with(['getMerek'])->get();
        }
        $resPemakaian = PemakaianModel::where('id_pelanggan', $id)->first();
        $data = [
            'pelanggan' => PelangganModel::with([
                'getWilayah',
                'getPaket'
            ])->find($id),
            'pemakaian' => $resPemakaian,
            'listPetugas' => PetugasModel::where('aktif', 'y')->get(),
            'listMaterial' => $list_material,
            'pemasangan_detail' => PemasanganDetailModel::where('id_pelanggan', $id)->first(),
            'pemakaian_material' => PemakaianDetailModel::with(['getMaterial'])->where('head_id', $resPemakaian->id)->get(),
            'qty_material' => PemakaianDetailModel::where('head_id', $resPemakaian->id)->sum('jumlah')
        ];
        // dd($data);
        return view('pelanggan.pembaharuan', $data);
    }
    public function simpanPembaharuanDataPelanggan(Request $request, $id_pelanggan)
    {
        DB::beginTransaction();
        try {
            $fileRumah = General::handleFileUpload($request, 'fileRumah', 'tmp_gambar_rumah', 'gambar_rumah', 1);
            $fileODP = General::handleFileUpload($request, 'fileODP', 'tmp_gambar_odp', 'gambar_odp', 2);
            $fileOntTerpasang = General::handleFileUpload($request, 'fileOntTerpasang', 'tmp_gambar_ont_terpasang', 'gambar_ont_terpasang', 3);
            $fileOntBelakang = General::handleFileUpload($request, 'fileOntBelakang', 'tmp_gambar_ont_belakang', 'gambar_ont_belakang', 4);
            $fileRedamanDiOdp = General::handleFileUpload($request, 'fileRedamanDiOdp', 'tmp_gambar_redaman_odp', 'gambar_redaman_odp', 5);
            $fileRedamanRumahPelanggan = General::handleFileUpload($request, 'fileRedamanRumahPelanggan', 'tmp_gambar_redaman_rumah_pelanggan', 'gambar_redaman_rumah_pelanggan', 6);
            $fileLainnya = General::handleFileUpload($request, 'fileLainnya', 'tmp_gambar_lainnya', 'gambar_lainnya', 7);
            $dataPemasangan = [
                'gambar_rumah' => $fileRumah,
                'gambar_odp' => $fileODP,
                'gambar_ont_terpasang' => $fileOntTerpasang,
                'gambar_belakang_ont' => $fileOntBelakang,
                'gambar_redaman_odp' => $fileRedamanDiOdp,
                'gambar_redaman_rumah_pelanggan' => $fileRedamanRumahPelanggan,
                'gambar_lainnya' => $fileLainnya,
            ];
            PemasanganDetailModel::find($request->id_pemasangan)->update($dataPemasangan);
            if($request->totalItem > 0)
            {
                $jml_item = count($request->item_id_material);
                foreach(array($request) as $key => $value)
                {
                    for($i=0; $i<$jml_item; $i++)
                    {
                        $dataD = [
                            "head_id" => $request->id_pemakaian,
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
            }

            DB::commit();
            $rs = response()->json([
                'success' => true,
                'message' => "Data berhasil disimpan."
            ]);
        } catch (Throwable $e) {
            DB::rollBack(); // Rollback transaction on error
            // Log the error for debugging
            Log::error('Transaction failed: '.$e->getMessage());
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data. error: ".$e->getMessage()
            ]);
        }
        return $rs;
    }
    public function simpanPembaharuanDataPelangganAll(Request $request, $id_pelanggan)
    {
        DB::beginTransaction();
        try {
            $fileRumah = General::handleFileUpload($request, 'fileRumah', 'tmp_gambar_rumah', 'gambar_rumah', 1);
            $fileODP = General::handleFileUpload($request, 'fileODP', 'tmp_gambar_odp', 'gambar_odp', 2);
            $fileOntTerpasang = General::handleFileUpload($request, 'fileOntTerpasang', 'tmp_gambar_ont_terpasang', 'gambar_ont_terpasang', 3);
            $fileOntBelakang = General::handleFileUpload($request, 'fileOntBelakang', 'tmp_gambar_ont_belakang', 'gambar_ont_belakang', 4);
            $fileRedamanDiOdp = General::handleFileUpload($request, 'fileRedamanDiOdp', 'tmp_gambar_redaman_odp', 'gambar_redaman_odp', 5);
            $fileRedamanRumahPelanggan = General::handleFileUpload($request, 'fileRedamanRumahPelanggan', 'tmp_gambar_redaman_rumah_pelanggan', 'gambar_redaman_rumah_pelanggan', 6);
            $fileLainnya = General::handleFileUpload($request, 'fileLainnya', 'tmp_gambar_lainnya', 'gambar_lainnya', 7);
            $dataPemasangan = [
                'tgl_aktivasi' => $request->inpTanggalAktivasi,
                'gambar_rumah' => $fileRumah,
                'gambar_odp' => $fileODP,
                'gambar_ont_terpasang' => $fileOntTerpasang,
                'gambar_belakang_ont' => $fileOntBelakang,
                'gambar_redaman_odp' => $fileRedamanDiOdp,
                'gambar_redaman_rumah_pelanggan' => $fileRedamanRumahPelanggan,
                'gambar_lainnya' => $fileLainnya,
                'sn_ont' => $request->inpSN_ONT,
                'model_ont' => $request->inpModel_ONT,
                'odp' => $request->inpODP,
                'tikor_odp' => $request->inpTikorODP,
                'tikor_pelanggan' => $request->inpTikorPelanggan,
                'port' => $request->inpPort,
                'port_ifle' => $request->inpPortIfle,
                'splitter' => $request->inpSplitter,
                'kabel_dc' => $request->inpKabelDC,
                'metode_bayar' => $request->inpMetode_Bayar,
            ];
            PemasanganDetailModel::find($request->id_pemasangan)->update($dataPemasangan);
            //update data pelanggan
            $pelanggan = [
                "nama_pelanggan" => $request->inpNama,
                "alamat" => $request->inpAlamat,
                "no_telepon_1" => $request->inpNotel_1,
                "no_telepon_2" => $request->inpNotel_2,
                "wilayah" => $request->selectWilayah,
                "paket_internet" => $request->selectpaket,
                "nama_sales" => $request->inpNamaSales,
                "no_telepon_sales" => $request->inpNotelSales,
                "no_rekening_sales" => $request->inpNorekSales,
                "nama_bank" => $request->inpNamaBankSales,
            ];
            PelangganModel::find($id_pelanggan)->update($pelanggan);
            if($request->totalItem > 0)
            {
                $jml_item = count($request->item_id_material);
                foreach(array($request) as $key => $value)
                {
                    for($i=0; $i<$jml_item; $i++)
                    {
                        $dataD = [
                            "head_id" => $request->id_pemakaian,
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
            }

            DB::commit();
            $rs = response()->json([
                'success' => true,
                'message' => "Data berhasil disimpan."
            ]);
        } catch (Throwable $e) {
            DB::rollBack(); // Rollback transaction on error
            // Log the error for debugging
            Log::error('Transaction failed: '.$e->getMessage());
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data. error: ".$e->getMessage()
            ]);
        }
        return $rs;
    }
    public function destroyPelangganAktif($id)
    {
        DB::beginTransaction();
        try {
            // 1. Hapus dan kembalikan stok dari pemakaian
            $pemakaian = PemakaianModel::where('id_pelanggan', $id)->first();
            if ($pemakaian) {
                $pemakaianDetails = PemakaianDetailModel::where('head_id', $pemakaian->id)->get();
                foreach ($pemakaianDetails as $detail) {
                    $material = Material::find($detail->material_id);
                    if ($material) {
                        $material->stok_akhir += $detail->jumlah;
                        $material->update();
                    }
                }
                PemakaianDetailModel::where('head_id', $pemakaian->id)->delete();
            }
            // 2. Hapus gambar & data pemasangan
            $pemasangan = PemasanganDetailModel::where('id_pelanggan', $id)->first();
            if ($pemasangan) {
                $gambarFields = [
                    'gambar_rumah',
                    'gambar_odp',
                    'gambar_ont_terpasang',
                    'gambar_belakang_ont',
                    'gambar_redaman_odp',
                    'gambar_redaman_rumah_pelanggan',
                    'gambar_lainnya'
                ];

                foreach ($gambarFields as $field) {
                    if (!empty($pemasangan->$field)) {
                        General::hapus_file_gambar($field, $pemasangan->$field);
                    }
                }
                $pemasangan->delete();
            }
            // 3. Hapus pembayaran pelanggan
            $queryPembayaran = PembayaranPelangganModel::where('id_pelanggan', $id);
            if($queryPembayaran->exists())
            {
                $queryPembayaran->delete(); //multiple row
            }
            //4. hapus data pelanggan permanen
            PelangganModel::find($id)->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data pelanggan berhasil dihapus.'
            ]);

        } catch (Throwable $e) {
            DB::rollBack(); // Rollback transaction on error
            // Log the error for debugging
            Log::error('Transaction failed: '.$e->getMessage());
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penghapusan data. error: ".$e->getMessage()
            ]);
        }
        return $rs;
    }
    //tools
    public function importData()
    {
        return view('pelanggan.tools.formImport');
    }
    public function doImportData(Request $request)
    {
        DB::beginTransaction();
        try {
            Excel::import(new PelangganImport, $request->file('inpFile'));
            DB::commit();
            $rs = response()->json([
                'success' => true,
                'message' => "Data berhasil disimpan."
            ]);
        } catch (Throwable $e) {
            DB::rollBack(); // Rollback transaction on error
            // Log the error for debugging
            Log::error('Transaction failed: '.$e->getMessage());
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data. error: ".$e->getMessage()
            ]);
        }
        return $rs;
    }
}

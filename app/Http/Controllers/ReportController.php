<?php

namespace App\Http\Controllers;

use App\Models\AgenVoucherModel;
use App\Models\VoucherDetailModel;
use App\Models\VoucherHeadModel;
use App\Traits\General;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use General;
    //distribusi voucher
    public function distribusiVoucher()
    {
        $data = [
            'list_bulan' => General::getListMonth(),
            "list_agen" => AgenVoucherModel::where('aktif', 'y')->get(),
            'start_year' => 2025,
            'end_year' => date('Y')
        ];
        return view('report.voucher.distribusi.index', $data);
    }

    public function distribusiVoucherGetData(Request $request)
    {
        $columns = ['created_at'];
        $totalData = VoucherHeadModel::where('status', 'open')->count();
        $search = $request->input('search.value');
        $query = VoucherHeadModel::with(['getAgen'])->where('status', 'open');
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('bulan', 'like', "%{$search}%");
            });
        }
        if(!empty($request->bulan))
        {
            $query->where('bulan', $request->bulan);
        }
        if(!empty($request->tahun))
        {
            $query->where('tahun', $request->tahun);
        }
        if(!empty($request->agen))
        {
            $query->where('agen_id', $request->agen);
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
                $btn = "<button type='button' class='btn btn-success btn-sm' id='btn_detail' data-bs-toggle='modal' data-bs-target='#exampleModalgetbootstrap' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-eye'></i></button>";
                $Data['act'] = $btn;
                $Data['id'] =  $r->id;
                $Data['bulan'] =  General::get_nama_bulan($r->bulan)." ".$r->tahun; // $r->material;
                $Data['agen'] =  $r->getAgen->nama_agen;
                $Data['status'] =  "<span class='badge badge-primary'>".$r->status."</span>";
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
    public function distribusiVoucherDetail($id)
    {
        $resultH = VoucherHeadModel::with(['getAgen'])->where('status', 'open')->find($id);
        $data = [
            "dataH" => $resultH,
            'periode' => General::get_nama_bulan($resultH->bulan)." ".$resultH->tahun,
            "dataD" => VoucherDetailModel::where('head_id', $id)->get()
        ];
        return view('report.voucher.distribusi.detail', $data);
    }

     //penjualan voucher
     public function penjualanVoucher()
     {
         $data = [
             'list_bulan' => General::getListMonth(),
             "list_agen" => AgenVoucherModel::where('aktif', 'y')->get(),
             'start_year' => 2025,
             'end_year' => date('Y')
         ];
         return view('report.voucher.penjualan.index', $data);
     }

     public function load_data_penjualan_voucher($bulan, $tahun, $agen)
     {
        $dataH  = VoucherHeadModel::where('status', 'close')->where('agen_id', $agen)->where('bulan', $bulan)->where('tahun', $tahun)->get();
        if($dataH->count()==0) {
            return view('voucher.penjualan.data_empty');
        } else {
            $data = [
                'status_data' => $dataH->first()->status,
                "list_penjualan" => VoucherDetailModel::where('head_id', $dataH->first()->id)->get()
            ];
            return view('report.voucher.penjualan.preview', $data);
        }
     }

     public function penjualanVoucherGetData(Request $request)
     {
         $columns = ['created_at'];
         $totalData = VoucherHeadModel::where('status', 'close')->count();
         $search = $request->input('search.value');
         $query = VoucherHeadModel::with(['getAgen'])->where('status', 'close');
         if(!empty($search)) {
             $query->where(function($q) use ($search) {
                 $q->Where('bulan', 'like', "%{$search}%");
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
                 $btn2 = '<ul class="action">
                             <li class="edit"> <a href="javascript:void(0)"><i class="icon-pencil-alt"></i></a></li>
                             <li class="delete"><a href="javascript:void(0)"><i class="icon-trash"></i></a></li>
                         </ul>';
                 $Data['act'] = $btn2;
                 $Data['id'] =  $r->id;
                 $Data['bulan'] =  General::get_nama_bulan($r->bulan)." ".$r->tahun; // $r->material;
                 $Data['agen'] =  $r->getAgen->nama_agen;
                 $Data['total_voucher'] =  number_format($r->total_voucher, 0);
                 $Data['total_laba'] =  number_format($r->total_laba, 0);
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
    public function penjualanVoucherPrint($bulan, $tahun, $agen)
    {
        $dataH  = VoucherHeadModel::with([
            "getAgen"
        ])->where('status', 'close')->where('agen_id', $agen)->where('bulan', $bulan)->where('tahun', $tahun)->get();
        $ket_periode = (empty($dataH->first()->bulan)) ? "" : General::get_nama_bulan($dataH->first()->bulan)." ".$dataH->first()->tahun;
        $idH = (empty($dataH->first()->id)) ? NULL : $dataH->first()->id;
        $data = [
            'data_head' => $dataH->first(),
            'periode' => $ket_periode,
           "list_penjualan" => VoucherDetailModel::where('head_id', $idH)->get()
        ];
        $pdf = Pdf::loadView('report.voucher.penjualan.print', $data)->setPaper('A4', 'potrait');
        return $pdf->stream();
    }
}

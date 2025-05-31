<?php

namespace App\Http\Controllers;

use App\Models\AgenVoucherModel;
use App\Models\ArusKasModel;
use App\Models\PembayaranPelangganModel;
use App\Models\VoucherDetailModel;
use App\Models\VoucherHeadModel;
use App\Models\WilayahModel;
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
                $btn = "";
                $btn .= '<div class="btn-group">';
                    $btn .="<button type='button' class='btn btn-info btn-sm' title='Detail' id='btn_detail' data-bs-toggle='modal' data-bs-target='#modalDetail' data-whatever='@getbootstrap' value='".$r->id."'><i class='fa fa-eye'></i></button>";
                $btn .='</div>';
                 $Data['act'] = $btn;
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
    public function showDetaiPenjualanVoucher($id)
    {
        $dHead = VoucherHeadModel::with(['getAgen'])->find($id);
        $data = [
            'resHead' => $dHead,
            'resDetail' => VoucherDetailModel::where('head_id', $id)->get(),
            'periode' =>  General::get_nama_bulan($dHead->bulan)." ".$dHead->tahun
        ];
        return view('report.voucher.penjualan.detail', $data);
    }

    public function printDetailPenjualanVoucher($bulan, $tahun, $agen)
    {
        $dataH  = VoucherHeadModel::with([
                        "getAgen"
                    ])->where('status', 'close');
        if(!empty($bulan) || $bulan != 0)
        {
            $dataH->where('bulan', $bulan);
        }
        if(!empty($tahun) || $tahun != 0)
        {
            $dataH->where('tahun', $tahun);
        }
        if(!empty($agen) || $agen != 0)
        {
            $dataH->where('agen_id', $agen);
        }
        $resultData = $dataH->get()->map( function($row) {
            $arr = $row->toArray();
                $arr['detail'] = VoucherDetailModel::where('head_id', $arr['id'])->get();
                return $arr;
        });
        $data = [
           "list_penjualan" => $resultData,
           'getGeneral' => General::class
        ];
        // dd($data);
        $pdf = Pdf::loadView('report.voucher.penjualan.print_with_detail', $data)->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
    //keuangan
    public function keuangan()
    {
        return view('report.keuangan.index');
    }
    public function keuanganGetData(Request $request)
    {
        $columns = ['created_at'];
        $totalData = ArusKasModel::count();
        $search = $request->input('search.value');
        $query = ArusKasModel::select("*");
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('id', 'like', "%{$search}%");
            });
        }
        if(!empty($tglMulai) && !empty($tglSampai)) {
            $query->WhereDate('tgl_transaksi', '>=', "{$tglMulai}")
                ->WhereDate('tgl_transaksi', '<=', "{$tglSampai}");
        }
        // else {
        //     $query->WhereDate('tgl_transaksi', '=', "{$toDay}");
        // }

        $totalFiltered = $query->count();
        $query = $query->offset($request->input('start'))
                    ->limit($request->input('length'))
                        ->orderBy('id', 'asc')
                    ->get();

         $data = array();
         if($query){
             $counter = $request->input('start') + 1;
             foreach($query as $r){
                 $Data['id'] =  $r->id;
                 $Data['periode'] =  date("d-m-Y", strtotime($r->tgl_transaksi));
                 $Data['keterangan'] =  $r->keterangan;
                 $Data['debet'] =  number_format($r->debet, 0);
                 $Data['kredit'] =  number_format($r->kredit, 0);
                 $Data['saldo'] =  0;
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

    public function filterKeuangan(Request $request)
    {
        $nom=1;
        $tgl_awal = $request->tgl_1;
        $tgl_akhir = $request->tgl_2;
        $saldo_d_awal = ArusKasModel::whereDate("tgl_transaksi", "<", $tgl_awal)->sum('debet');
        $saldo_k_awal = ArusKasModel::whereDate("tgl_transaksi", "<", $tgl_awal)->sum('kredit');
        $saldo_awal = $saldo_d_awal - $saldo_k_awal;
        if(empty($tgl_akhir)) {
            $query = ArusKasModel::whereDate('tgl_transaksi', '=', $tgl_awal);
        } else {
            $query = ArusKasModel::whereDate('tgl_transaksi', '>=', $tgl_awal)
                        ->whereDate('tgl_transaksi', '<=', $tgl_akhir);
        }
        $all_data = $query->get();
        $html = "<table class='table table-bordered table-hover' style='font-size: 12pt; width: 100%;' id='table_keuangan'>
        <thead>
            <tr>
                <td style='text-align: left;' colspan='6'><h4>Laporan Keuangan</h4>
                <p class='lbl_periode'>Periode laporan tanggal : ".$request->ket_periode_tanggal."</p>
                </td>
            </tr>
            <tr>
                <th style='width: 5%;'>#</th>
                <th style='width: 10%;'>Tanggal</th>
                <th>Keterangan</th>
                <th style='text-align: right; width: 15%;'>Debet</th>
                <th style='text-align: right; width: 15%;'>Kredit</th>
                <th style='text-align: right; width: 15%;'>Saldo</th>
            </tr>
        </thead>
        <tbody>";
        $html .= '<tr style="background-color: #eaedf1">
        <td colspan="5" style="text-align: right;"><b>SALDO AWAL</b></td>
        <td style="text-align: right;"><b>'.number_format($saldo_awal, 0, ",", ".").'</b></td>
        </tr>';
        $saldo = $saldo_awal;
        foreach($all_data as $list)
        {

            if($list->debet != 0) {
                $saldo+=$list->debet;
                $ketDB = "(+)";
            } else {
                $saldo-=$list->kredit;
                $ketDB = "(-)";
            }

            $html .= "<tr>
            <td>".$nom."</td>
            <td>".date_format(date_create($list->tgl_transaksi), 'd-m-Y')."</td>
            <td style='text-align: left'>".$list->keterangan."</td>
            <td style='text-align: right'>".number_format($list->debet, 0, ",", ".")."</td>
            <td style='text-align: right'>".number_format($list->kredit, 0, ",", ".")."</td>
            <td style='text-align: right'>".number_format($saldo, 0, ",", ".")." ".$ketDB."</td>
            </tr>";
            $nom++;
        }
        $html .= '<tr style="background-color: #eaedf1">
        <td colspan="5" style="text-align: right;"><b>SALDO AKHIR</b></td>
        <td style="text-align: right;"><b>'.number_format($saldo, 0, ",", ".").'</b></td>
        </tr></tbody>
        </table>';
        return response()
            ->json([
                'all_result' => $html
            ])
            ->withCallback($request->input('callback'));
    }

    public function keuanganPrint($tanggal_awal, $tanggal_akhir)
    {
        $tgl_awal = $tanggal_awal;
        $tgl_akhir = $tanggal_akhir;
        $saldo_d_awal = ArusKasModel::whereDate("tgl_transaksi", "<", $tgl_awal)->sum('debet');
        $saldo_k_awal = ArusKasModel::whereDate("tgl_transaksi", "<", $tgl_awal)->sum('kredit');
        $saldo_awal = $saldo_d_awal - $saldo_k_awal;
        if(empty($tgl_akhir)) {
            $query = ArusKasModel::whereDate('tgl_transaksi', '=', $tgl_awal);
        } else {
            $query = ArusKasModel::whereDate('tgl_transaksi', '>=', $tgl_awal)
                        ->whereDate('tgl_transaksi', '<=', $tgl_akhir);
        }
        // $all_data = $query->get();
        $data = [
            'periode' => date('d-m-Y', strtotime($tgl_awal))." s.d ".date('d-m-Y', strtotime($tgl_akhir)),
            'listData' => $query->get(),
            'saldoAwal' => $saldo_awal
        ];
        $pdf = Pdf::loadView('report.keuangan.print', $data)->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    //pembayaran pelanggan
    public function pembayaranPelanggan()
    {
        $data = [
             'list_bulan' => General::getListMonth(),
             "list_wilayah" => WilayahModel::latest()->get(),
             'start_year' => 2025,
             'end_year' => date('Y')
         ];
         return view('report.pelanggan.pembayaran.index', $data);
    }
    public function pembayaranPelangganGetData(Request $request)
     {
         $columns = ['created_at'];
         $totalData = PembayaranPelangganModel::count();
         $search = $request->input('search.value');
         $query = PembayaranPelangganModel::select([
            'pembayaran_pelanggan.*',
            'pelanggan.nama_pelanggan',
            'wilayah.wilayah'
         ])
                    ->leftJoin('pelanggan', 'pembayaran_pelanggan.id_pelanggan', '=', 'pelanggan.id')
                    ->leftJoin('wilayah', 'pelanggan.wilayah', '=', 'wilayah.id');
         if(!empty($search)) {
             $query->where(function($q) use ($search) {
                 $q->Where('pelanggan.nama_pelanggan', 'like', "%{$search}%");
             });
         }
         if(!empty($request->bulan))
        {
            $query->whereMonth('pembayaran_pelanggan.tgl_bayar', $request->bulan);
        }
        if(!empty($request->tahun))
        {
            $query->whereYear('pembayaran_pelanggan.tgl_bayar', $request->tahun);
        }
        if(!empty($request->wilayah))
        {
            $query->where('pelanggan.wilayah', $request->wilayah);
        }

         $totalFiltered = $query->count();
         $query = $query->offset($request->input('start'))
                       ->limit($request->input('length'))
                         ->orderBy('pembayaran_pelanggan.id', 'asc')
                       ->get();

         $data = array();
         if($query){
             $counter = $request->input('start') + 1;
             foreach($query as $r){
                 $Data['id'] =  $r->id;
                 $Data['periode'] =  $r->tgl_bayar; // $r->material;
                 $Data['wilayah'] =  $r->wilayah;
                 $Data['pelanggan'] =  $r->nama_pelanggan;
                 $Data['nominal'] =  number_format($r->nominal, 0);
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
    public function pembayaranPelangganPrint($bulan, $tahun, $wilayah)
    {
        $query = PembayaranPelangganModel::select([
                'pembayaran_pelanggan.*',
                'pelanggan.nama_pelanggan',
                'wilayah.wilayah'
            ])
            ->leftJoin('pelanggan', 'pembayaran_pelanggan.id_pelanggan', '=', 'pelanggan.id')
            ->leftJoin('wilayah', 'pelanggan.wilayah', '=', 'wilayah.id');
        if(!empty($bulan))
        {
            $query->whereMonth('pembayaran_pelanggan.tgl_bayar', $bulan);
        }
        if(!empty($tahun))
        {
            $query->whereYear('pembayaran_pelanggan.tgl_bayar', $tahun);
        }
        if(!empty($wilayah))
        {
            $query->where('pelanggan.wilayah', $wilayah);
        }
        $ket_periode = (empty($bulan)) ? "" : General::get_nama_bulan($bulan)." ".$tahun;
        $data = [
            'periode' => $ket_periode,
            'listData' => $query->get()
        ];
        $pdf = Pdf::loadView('report.pelanggan.pembayaran.print', $data)->setPaper('A4', 'potrait');
        return $pdf->stream();
    }
}

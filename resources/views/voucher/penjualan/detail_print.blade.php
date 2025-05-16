<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Detail Penjualan Voucher</h3>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table style="width: 100%;">
                                <tbody>
                                  <tr style="padding: 28px 0; display: flex; justify-content: space-between;">
                                    <td style="width: 50%"><span style=" font-size: 16px; font-weight: 500; opacity: 0.8;">PERIODE</span>
                                      <h4 style="font-weight:600; margin: 12px 0 5px 0; font-size: 18px; #006666;">{{ $periode }}</h4>
                                    </td>
                                    <td style="width: 50%"><span style="font-size: 16px; font-weight: 500;opacity: 0.8;">AGEN</span>
                                      <h4 style="font-weight:600; margin: 12px 0 5px 0; font-size: 18px; #006666;">{{ $dataH->getAgen->nama_agen }}</h4><span style="display:block; line-height: 1.5;  font-size: 18px; font-weight: 400;opacity: 0.8;">{{ $dataH->getAgen->alamat }}</span><span style="line-height:2;  font-size: 18px; font-weight: 400;opacity: 0.8;">Phone : {{ $dataH->getAgen->no_telepon }}</span>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Voucher</th>
                                        <th rowspan="2" style="width: 10%">Harga&nbsp;Modal</th>
                                        <th rowspan="2" style="width: 10%">Harga&nbsp;Jual</th>
                                        <th colspan="3" class="text-center" style="background-color: rgba(0, 102, 102, 0.9); color:white">Stok Distribusi</th>
                                        <th colspan="3" class="text-center" style="background-color: rgba(254, 106, 73, 0.9); color:white">Stok Realisasi</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 10%; background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">Awal</th>
                                        <th style="width: 10%; background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">Tambahan</th>
                                        <th style="width: 10%; background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">Total</th>
                                        <th style="width: 10%; background-color: rgba(254, 106, 73, 0.9); color:white" class="text-center">Sisa</th>
                                        <th style="width: 10%; background-color: rgba(254, 106, 73, 0.9); color:white" class="text-center">Terjual</th>
                                        <th style="width: 15%; text-align:right; background-color: rgba(254, 106, 73, 0.9); color:white">Sub&nbsp;Total&nbsp;(Rp.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $t_stok_terjual=0; $t_laba=0; $t_sisa=0;
                                    @endphp
                                    @foreach ($dataD as $r)
                                    @php
                                    $total_stok_distribusi = $r->stok_awal + ((empty($r->stok_tambahan)) ? 0 : $r->stok_tambahan);
                                    $total_laba = $r->harga_modal * $r->stok_terjual;
                                    $jumlah_sisa = $total_stok_distribusi - $r->stok_terjual;
                                    @endphp
                                    <tr>
                                        <td>{{ $r->nama_voucher }}</td>
                                        <td>Rp. {{ number_format($r->harga_modal, 0) }}</td>
                                        <td>Rp. {{ number_format($r->harga_jual, 0) }}</td>
                                        <td style="background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">{{ $r->stok_awal }}<input type="hidden" id="tempStokAwal" name="tempStokAwal[]" value="{{ $r->stok_awal }}"></td>
                                        <td style="background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">{{ (empty($r->stok_tambahan)) ? 0 : $r->stok_tambahan }}</td>
                                        <td style="background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">{{ $total_stok_distribusi }}</td>
                                        <td style="background-color: rgba(254, 106, 73, 0.9); color:white; font-size:15pt" class="text-center"><b>{{ $jumlah_sisa }}</b></td>
                                        <td style="background-color: rgba(254, 106, 73, 0.9); color:white; font-size:15pt" class="text-center"><b>{{ $r->stok_terjual }}</b></td>
                                        <td style="background-color: rgba(254, 106, 73, 0.9); color:white; text-align:right;font-size:15pt"><b>{{ number_format($total_laba, 0) }}</b></td>
                                    </tr>
                                    @php
                                    $t_stok_terjual+=$r->stok_terjual;
                                    $t_laba+=$total_laba;
                                    $t_sisa+=$jumlah_sisa;
                                    @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="6" style="background-color: rgba(121, 126, 126, 0.9); color:white; text-align:right"><b>TOTAL</b></td>
                                        <td style="background-color: rgba(254, 106, 73, 0.9); color:white; text-align:center;font-size:15pt"><b>{{ number_format($t_sisa, 0) }}</b></td>
                                        <td style="background-color: rgba(254, 106, 73, 0.9); color:white; text-align:center;font-size:15pt"><b>{{ number_format($t_stok_terjual, 0) }}</b></td>
                                        <td style="background-color: rgba(254, 106, 73, 0.9); color:white; text-align:right;font-size:15pt"><b>{{ number_format($t_laba, 0) }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" type="button" id="tbl_print" value="{{ $dataH->id }}" onclick="showPrint(this)">Cetak Tagihan</button>
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
</div>

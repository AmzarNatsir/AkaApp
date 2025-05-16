<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Detail Penjualan Voucher</h3>
    <div class="modal-body">
        <div class="card">
            <div class="card-body">
                <div class="form theme-form">
                    <div class="row">
                        <div class="col-xxl-6 col-md-6 box-col-6">
                            <div class="card-body pt-2 row important-project">
                                <ul class="pro-services">
                                <li>
                                    <div class="media-body">
                                        <h4>Agent : {{ $resHead->getAgen->nama_agen }}</h4>
                                    </div>
                                </li>
                                <li>
                                    <div class="media-body">
                                        <h5>Alamat : {{ $resHead->getAgen->alamat }}</h5>
                                    </div>
                                </li>
                                <li>
                                    <div class="media-body">
                                        <h5>No. Telepon : {{ $resHead->getAgen->no_telepon }}</h5>
                                    </div>
                                </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-md-6 box-col-6">
                            <div class="card-body pt-2 row important-project">
                                <ul class="pro-services">
                                <li>
                                    <div class="media-body">
                                        <h4>Periode : {{ $periode }}</h4>
                                    </div>
                                </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row table-responsive">
                        <table class="display table table-striped table-bordered" style="width: 100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Voucher</th>
                                    <th rowspan="2" style="width: 10%">Harga&nbsp;Modal</th>
                                    <th rowspan="2" style="width: 10%">Harga&nbsp;Jual</th>
                                    <th colspan="3" class="text-center">Stok Distribusi</th>
                                    <th colspan="3" class="text-center">Stok Realisasi</th>
                                </tr>
                                <tr>
                                    <th style="width: 10%;">Awal</th>
                                    <th style="width: 10%;">Tambahan</th>
                                    <th style="width: 10%;">Total</th>
                                    <th style="width: 10%;">Sisa</th>
                                    <th style="width: 10%;">Terjual</th>
                                    <th style="width: 15%;">Sub&nbsp;Total&nbsp;(Rp.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $t_stok_terjual=0; $t_laba=0; $t_sisa=0;
                                @endphp
                                @foreach ($resDetail as $r)
                                @php
                                $total_stok_distribusi = $r->stok_awal + ((empty($r->stok_tambahan)) ? 0 : $r->stok_tambahan);
                                $total_laba = $r->harga_modal * $r->stok_terjual;
                                $jumlah_sisa = $total_stok_distribusi - $r->stok_terjual;
                                @endphp
                                <tr>
                                    <td>{{ $r->nama_voucher }}</td>
                                    <td>Rp. {{ number_format($r->harga_modal, 0) }}</td>
                                    <td>Rp. {{ number_format($r->harga_jual, 0) }}</td>
                                    <td class="text-center">{{ $r->stok_awal }}<input type="hidden" id="tempStokAwal" name="tempStokAwal[]" value="{{ $r->stok_awal }}"></td>
                                    <td class="text-center">{{ (empty($r->stok_tambahan)) ? 0 : $r->stok_tambahan }}</td>
                                    <td class="text-center">{{ $total_stok_distribusi }}</td>
                                    <td class="text-center"><b>{{ $jumlah_sisa }}</b></td>
                                    <td class="text-center"><b>{{ $r->stok_terjual }}</b></td>
                                    <td style="text-align:right"><b>{{ number_format($total_laba, 0) }}</b></td>
                                </tr>
                                @php
                                $t_stok_terjual+=$r->stok_terjual;
                                $t_laba+=$total_laba;
                                $t_sisa+=$jumlah_sisa;
                                @endphp
                                @endforeach
                                <tr>
                                    <td colspan="6" style="text-align:right"><b>TOTAL</b></td>
                                    <td style="text-align:center"><b>{{ number_format($t_sisa, 0) }}</b></td>
                                    <td style="text-align:center"><b>{{ number_format($t_stok_terjual, 0) }}</b></td>
                                    <td style="text-align:right"><b>{{ number_format($t_laba, 0) }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>

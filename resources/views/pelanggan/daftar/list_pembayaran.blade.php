<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Data Pembayaran Pelanggan</h3>
    <div class="modal-body">
        <div class="card">
            <div class="card-body table-responsive">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="card height-equal">
                            <div class="card-header border-l-secondary border-2 p-3">
                                <h4>Pelanggan</h4>
                                <p class="mt-1 f-m-light txt-primary fw-bold">{{ $pelanggan->nama_pelanggan }}</p>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item txt-primary fw-bold"><h6><i class="fa fa-location-arrow"></i> Alamat : </h6><span>{{ $pelanggan->alamat }}</span><br><span>Wilayah: {{ $pelanggan->getWilayah->wilayah }}</span></li>
                                    <li class="list-group-item txt-primary fw-bold"><h6><i class="fa fa-phone"></i> No. Telepon</h6>
                                        <span>{{ $pelanggan->no_telepon_1 }}{{ (!empty($pelanggan->no_telepon_2)) ? " - ".$pelanggan->no_telepon_2 : "" }}</span></li>
                                    <li class="list-group-item txt-primary fw-bold"><h6><i class="icofont icofont-star-shape"></i> Paket yang dipilih : </h6><span>{{ $pelanggan->getPaket->nama_paket }}</span></li>
                                    <li class="list-group-item txt-primary fw-bold"><h6><i class="fa fa-calendar"></i> Tanggal Aktivasi : </h6><span>{{ $detail->tgl_aktivasi }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="row size-column">
                            <div class="col-xxl-12 box-col-12">
                                <div class="row">
                                    <div class="col-xl-12 col-sm-12">
                                        <div class="card o-hidden small-widget">
                                            <div class="card-body total-Complete border-b-success border-2"><span class="f-light f-w-500 f-14">Total Pembayaran</span>
                                                <div class="project-details">
                                                    <div class="project-counter">
                                                        <h2 class="f-w-600">Rp. {{ number_format($total_pembayaran, 0, ',', '.') }} </span>
                                                    </div>
                                                    <div class="product-sub bg-success-light">
                                                        <svg class="invoice-icon">
                                                        <use href="{{ asset('assets/svg/icon-sprite.svg#add-square') }}"></use>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <ul class="bubbles">
                                                <li class="bubble"> </li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"> </li>
                                                <li class="bubble"></li>
                                                <li class="bubble"> </li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12 project-list">
                                <div class="card">
                                    <div class="card-header border-l-secondary border-2 p-3">
                                        <h4>History Pembayaran</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="display table-order" style="width: 100%">
                                            <thead>
                                                <th>#</th>
                                                <th>Periode</th>
                                                <th>Tanggal</th>
                                                <th style="text-align: right">Nominal</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($list_pembayaran as $r)
                                                <tr>
                                                    <td style="height: 30px">{{ $loop->iteration }}</td>
                                                    <td>{{ date('M-Y', strtotime($r->tgl_bayar)) }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($r->tgl_bayar)) }}</td>
                                                    <td style="text-align: right"><b>Rp. {{ number_format($r->nominal, 0) }}</b></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
    </div>
</div>

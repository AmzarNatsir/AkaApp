<div class="row">
    <div class="col-sm-4">
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
    <div class="col-sm-4">
        <div class="row justify-content-center">
            <div class="col-md-12 project-list">
                <div class="card">
                    <div class="card-header border-l-secondary border-2 p-3">
                        <h4>Form Pembayaran</h4>
                    </div>
                    <div class="card-body">
                        <form id="bayarForm" method="post" class="needs-validation">
                        @csrf
                        <div class="form theme-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Tanggal Bayar</label>
                                    <input class="form-control" name="inpTanggal" id="datetime-local" type="date" value="{{ date('Y-m-d') }}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Nominal</label>
                                    <input type="text" class="form-control angka" name="inpNominal" id="inpNominal" value="0" onblur="changeToNull(this)" style="text-align:right">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="row justify-content-center">
            <div class="col-md-12 project-list">
                <div class="card">
                    <div class="card-header border-l-secondary border-2 p-3">
                        <h4>History Pembayaran</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-order" style="width: 100%">
                            <thead>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Nominal</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Detail Data Pelanggan</h3>
    <div class="modal-body">
        <form id="prosesForm" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate="">
        @csrf
            <div class="col-sm-4">
                <div class="card height-equal">
                    <div class="card-header border-l-secondary border-2 p-3">
                        <h4>Pelanggan</h4>
                        <p class="mt-1 f-m-light txt-primary fw-bold">{{ $res->nama_pelanggan }}</p>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item txt-primary fw-bold"><h6><i class="fa fa-location-arrow"></i> Alamat : </h6><span>{{ $res->alamat }}</span><br><span>Wilayah: {{ $res->getWilayah->wilayah }}</span></li>
                            <li class="list-group-item txt-primary fw-bold"><h6><i class="fa fa-phone"></i> No. Telepon</h6>
                                <span>{{ $res->no_telepon_1 }}{{ (!empty($res->no_telepon_2)) ? " - ".$res->no_telepon_2 : "" }}</span></li>
                            <li class="list-group-item txt-primary fw-bold"><h6><i class="icofont icofont-star-shape"></i> Paket yang dipilih : </h6><span>{{ $res->getPaket->nama_paket }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                @if($res->status == "onCanceled")
                <div class="card">
                    <div class="card-header bg-danger">
                        <h4 class="text-white"><i class="fa fa-info"></i> BATAL PEMASANGAN</h4>
                        <p class="f-m-light mt-1">{{ $res->keterangan_cancel }}</p>
                    </div>
                </div>
                @endif
                <div class="row justify-content-center">
                    <div class="col-md-12 project-list">
                        <div class="card">
                            <div class="card-body">
                                <div class="form theme-form">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Tanggal</label>
                                            <input class="form-control" name="inpTanggal" id="datetime-local" type="date" value="{{ $pemakaian->tanggal }}" disabled>
                                        </div>
                                        <div class="col-md-9">
                                            <label>Kategori</label>
                                            <input type="text" class="form-control" name="inpkategori" id="inpkategori" value="Pemesangan Baru" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label>Petugas</label>
                                                <input type="text" class="form-control" name="inpPetugas" id="inpPetugas" value="{{ $petugas }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <label>Keterangan</label>
                                            <input type="text" class="form-control" name="inpKeterangan" id="inpKeterangan" value="{{ $pemakaian->keterangan }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 project-list">
                        <div class="card">
                            <div class="card-header border-l-info border-2 p-3">
                                <h4>Material yang digunakan</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="form theme-form">
                                    <div class="row">
                                        <div class="card">
                                            <div class="card-body pt-0">
                                                <div class="table-order table-responsive custom-scrollbar">
                                                    <table class="table table-order" style="width: 100%">
                                                        <thead>
                                                            <th style="width: 5%">#</th>
                                                            <th>Material</th>
                                                            <th style="width: 15%">Jumlah</th>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($listPemakaianMaterial as $r)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $r->getMaterial->material }}</td>
                                                                <td style="text-align:center"><badge class="badge badge-danger">{{ $r->jumlah }}</badge></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
</script>

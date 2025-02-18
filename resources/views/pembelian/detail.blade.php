<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Detail Pembeliian Material</h3>
    <div class="modal-body">
        <div class="row">
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="row g-3">
                            <label class="col-md-6 text-start">Nomor</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="inpNomor" id="inpNomor" value="{{ $dataH->nomor }}" readonly>
                            </div>
                            <label class="col-md-6 text-start">Tanggal</label>
                            <div class="col-md-6">
                                <div class="input-group flatpicker-calender">
                                    <input class="form-control" name="inpTanggal" id="inpTanggal" value="{{ $dataH->tanggal }}" readonly>
                                </div>
                            </div>
                            <label class="col-md-6 text-start">Total (Rp.)</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control angka" name="inpTotal" id="inpTotal" value="{{ $dataH->total }}" style="text-align: right" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="row g-3">
                            <div class="col-md-12 position-relative">
                                <label class="form-label" for="inpHargaBeli">Keterangan</label>
                                <textarea class="form-control" name="inpKeterangan" id="inpKeterangan" rows="4" readonly>{{ $dataH->keterangan }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="card-body pt-0">
                        <div class="table-order table-responsive custom-scrollbar">
                            <table class="table" style="width: 100%;border-spacing:0;" id="view_items">
                                <thead>
                                <tr style="background: #006666;">
                                    <th style="padding: 18px 15px;text-align: left"><span style="color: #fff; font-size: 18px; font-weight: 600;">Material</span></th>
                                    <th style="padding: 18px 15px;text-align: center;border-inline: 3px solid #fff; width: 10%"><span style="color: #fff; font-size: 18px; font-weight: 600;">Jumlah</span></th>
                                    <th style="padding: 18px 15px;text-align: center;border-right: 3px solid #fff; width: 15%"><span style="color: #fff; font-size: 18px; font-weight: 600;">Harga</span></th>
                                    <th style="padding: 18px 15px;text-align: center; border-right: 3px solid #fff; width: 15%"><span style="color: #fff; font-size: 18px; font-weight: 600;">Subtotal</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php($nom=1)
                                    @foreach($dataD as $r)
                                    <tr>
                                        <td><div class="product-names">
                                            <div class="light-product-box"><a href="{{ url(Storage::url('material/'.$r->getMaterial->gambar)) }}" data-fancybox data-caption="{{ $r->getMaterial->material }}"><img class="img-fluid" src="{{ url(Storage::url('material/'.$r->getMaterial->gambar)) }}" alt="gambar"></a></div>
                                            <ul style="padding: 0;margin: 0;list-style: none;">
                                                <li class="invoice-title invoice-text">
                                                    <h4 style="font-weight:600; margin:4px 0px; font-size: 18px;">{{ $r->getMaterial->material }}</h4>
                                                    <span style="opacity: 0.8; font-size: 16px;">{{ $r->getMaterial->getMerek->merek }}</span><br>
                                                    <span style="opacity: 0.8; font-size: 16px;">{{ $r->getMaterial->deskripsi }}</span>
                                                </li>
                                            </ul>
                                          </div>
                                        </td>
                                        <td>{{ $r->jumlah }}</td>
                                        <td>{{ number_format($r->harga, 0) }}</td>
                                        <td>{{ number_format($r->sub_total, 0) }}</td>
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
    <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
    </div>
</div>

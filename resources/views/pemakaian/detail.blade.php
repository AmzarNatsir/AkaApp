<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Detail Pemakaian Material</h3>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label style="font-size:16px; font-weight:500; color:#52526C; opacity:0.8; margin:0;line-height: 2;">Tanggal</label>
                                    <p style="font-size: 18px; font-weight: 600;">{{ $dataH->tanggal }}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label style="font-size:16px; font-weight:500; color:#52526C; opacity:0.8; margin:0;line-height: 2;">Kategori</label>
                                    <p style="font-size: 18px; font-weight: 600;">{{ $kategori_pemakaian }}</p>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label style="font-size:16px; font-weight:500; color:#52526C; opacity:0.8; margin:0;line-height: 2;">Petugas</label>
                                    <p style="font-size: 18px; font-weight: 600;">{{ $petugas }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label style="font-size:16px; font-weight:500; color:#52526C; opacity:0.8; margin:0;line-height: 2;">Wilayah</label>
                                    <p style="font-size: 18px; font-weight: 600;">{{ $dataH->getWilayah->wilayah }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label style="font-size:16px; font-weight:500; color:#52526C; opacity:0.8; margin:0;line-height: 2;">Keterangan</label>
                                    <p style="font-size: 18px; font-weight: 600;">{{ $dataH->keterangan }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 project-list">
                            <div class="card">
                                <div class="card-header border-b-info total-revenue">
                                    <h4>Item Pemakaian</h4>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="table-order table-responsive custom-scrollbar">
                                        <table class="table" style="width: 100%">
                                            <thead>
                                                <th style="width: 5%">#</th>
                                                <th>Material</th>
                                                <th style="width: 30%">Merek</th>
                                                <th style="width: 15%">Jumlah</th>
                                            </thead>
                                            <tbody>
                                                @php($nom=1)
                                                @php($total=0)
                                                @foreach ($dataD as $d)
                                                <tr>
                                                    <td>{{ $nom }}</td>
                                                    <td>{{ $d->getMaterial->material }}</td>
                                                    <td>{{ $d->getMaterial->getMerek->merek }}</td>
                                                    <td style="text-align: center">{{ $d->jumlah }}</td>
                                                </tr>
                                                @php($nom++)
                                                @php($total+=$d->jumlah)
                                                @endforeach
                                                <tr>
                                                    <td colspan="3" style="text-align: right">TOTAL</td>
                                                    <td style="text-align: center">{{ $total }}</td>
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
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
</div>

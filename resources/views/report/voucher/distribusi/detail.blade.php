<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Detail Distribusi Voucher</h3>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label style="font-size:16px; font-weight:500; color:#52526C; opacity:0.8; margin:0;line-height: 2;">Periode</label>
                                    <p style="font-size: 18px; font-weight: 600;">{{ $periode }}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label style="font-size:16px; font-weight:500; color:#52526C; opacity:0.8; margin:0;line-height: 2;">Agent</label>
                                    <p style="font-size: 18px; font-weight: 600;">{{ $dataH->getAgen->nama_agen }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 project-list">
                            <div class="card">
                                <div class="card-header border-b-info total-revenue">
                                    <h4>Item Voucher</h4>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="table-order table-responsive custom-scrollbar">
                                        <table class="table" style="width: 100%">
                                            <thead>
                                                <th>Voucher</th>
                                                <th style="width: 20%; text-align: right">Harga&nbsp;Modal</th>
                                                <th style="width: 20%; text-align: right">Harga&nbsp;Jual</th>
                                                <th style="width: 20%; text-align: center">Stok&nbsp;Awal</th>
                                                <th style="width: 20%; text-align: center">Stok&nbsp;Tambahan</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataD as $d)
                                                <tr>
                                                    <td>{{ $d->nama_voucher }}</td>
                                                    <td style="text-align: right">Rp. {{ number_format($d->harga_modal, 0) }}</td>
                                                    <td style="text-align: right">Rp. {{ number_format($d->harga_jual, 0) }}</td>
                                                    <td style="text-align: center">{{ number_format($d->stok_awal, 0) }}</td>
                                                    <td style="text-align: center">{{ number_format($d->stok_tambahan, 0) }}</td>
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
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
</div>

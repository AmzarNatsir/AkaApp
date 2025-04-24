<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">List material yang digunakan</h3>
    <div class="modal-body">
        <div class="row">
            <div class="card">
                <div class="card-body pt-0">
                    <div class="table-order table-responsive custom-scrollbar">
                        <table class="table table-order" style="width: 100%">
                            <thead>
                                <th>Material</th>
                                <th style="width: 15%">Jumlah</th>
                            </thead>
                            <tbody>
                                @foreach ($listPemakaian as $r)
                                <tr>
                                    <td><div class="product-names">
                                        <div class="light-product-box"><a href="{{ url(Storage::url('material/'.$r->getMaterial->gambar)) }}" data-fancybox data-caption="{{ $r->getMaterial->material }}"><img class="img-fluid" src="{{ url(Storage::url('material/'.$r->getMaterial->gambar)) }}" alt="headphones"></a></div>
                                        <p>{{ $r->getMaterial->material }}<br>
                                        {{ $r->getMaterial->getMerek->merek }}<br>
                                        {{ $r->getMaterial->getSatuan->satuan }}<br>
                                        {{ $r->getMaterial->deskripsi }}
                                        </p>
                                      </div></td>
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
    <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
    </div>
</div>

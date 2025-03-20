<div class="tab-pane fade show active" id="bottom-penerimaan" role="tabpanel" aria-labelledby="bottom-penerimaan-tab">
    <div class="card-body pb-0">
        <p>Daftar Penerimaan Material</p>
        <div class="table-responsive">
            <table class="table" id="table_penerimaan">
                <thead>
                    <th style="width: 5%">No</th>
                    <th style="width: 15%">Tanggal</th>
                    <th style="width: 15%">Jumlah</th>
                    <th>Keterangan</th>
                </thead>
                <tbody>
                    @php($nom=1)
                    @foreach ($list_penerimaan as $r)
                    <tr>
                        <td>{{ $nom }}</td>
                        <td>{{ $r->getHeader->tanggal }}</td>
                        <td style="text-align:center"><badge class="badge badge-danger">{{ $r->jumlah }}</badge></td>
                        <td>{{ $r->getHeader->keterangan }}</td>
                    </tr>
                    @php($nom++)
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="bottom-pemakaian" role="tabpanel" aria-labelledby="bottom-pemakaian-tab">
    <div class="card-body pb-0">
        <p>Daftar Pemakaian Material</p>
        <div class="table-responsive">
            <table class="table" id="table_pemakaian">
                <thead>
                    <th style="width: 5%">No</th>
                    <th style="width: 15%">Tanggal</th>
                    <th style="width: 10%; text-align:center">Jumlah</th>
                    <th style="width: 15%">Kategori</th>
                    <th style="width: 15%">Wilayah</th>
                    <th style="width: 15%">Petugas</th>
                    <th>Keterangan</th>
                </thead>
                <tbody>
                    @php($nom=1)
                    @foreach ($list_pemakaian as $r2)
                    <tr>
                        <td>{{ $nom }}</td>
                        <td>{{ $r2->getHeader->tanggal }}</td>
                        <td style="text-align:center"><badge class="badge badge-success">{{ $r2->jumlah }}</badge></td>
                        <td>{{ (empty($r2->getHeader->kategori_id)) ? "" : $getKategori::get_kategori_pemakaian_material($r2->getHeader->kategori_id) }}</td>
                        <td>{{ (empty($r2->getHeader->wilayah_id)) ? "" : $r2->getHeader->getWilayah->wilayah }}</td>
                        <td>{{ (empty($r2->getHeader->petugas_id)) ? "" : $r2->getHeader->getPetugas->nama_petugas }}</td>
                        <td>{{ $r2->getHeader->keterangan }}</td>
                    </tr>
                    @php($nom++)
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="bottom-pengembalian" role="tabpanel" aria-labelledby="bottom-pengembalian-tab">
    <div class="card-body pb-0">
        <p>Daftar Pengembalian Material</p>
        <div class="table-responsive">
            <table class="table" id="table_pengembalian">
                <thead>
                    <th style="width: 5%">No</th>
                    <th style="width: 15%">Tanggal</th>
                    <th style="width: 15%">Jumlah</th>
                    <th>Keterangan</th>
                </thead>
                <tbody>
                    @php($nom=1)
                    @foreach ($list_return as $r3)
                    <tr>
                        <td>{{ $nom }}</td>
                        <td>{{ $r3->getHeader->tanggal }}</td>
                        <td style="text-align:center"><badge class="badge badge-dark">{{ $r3->jumlah }}</badge></td>
                        <td>{{ $r3->getHeader->keterangan }}</td>
                    </tr>
                    @php($nom++)
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

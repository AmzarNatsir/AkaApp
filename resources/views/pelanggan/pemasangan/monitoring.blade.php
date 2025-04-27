@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Monitoring Pemasangan</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg></a></li>
                    <li class="breadcrumb-item active">Daftar</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Pelanggan</h4><span>Daftar pelanggan</span>
                </div>
                <div class="card-body table-responsive">
                        <table class="display" id="table_view">
                          <thead>
                            <tr>
                              <th style="width: 5%">#</th>
                              <th>Pelanggan</th>
                              <th style="width: 25%">Alamat</th>
                              <th style="width: 15%">Paket</th>
                              <th style="width: 10%">Petugas</th>
                              <th style="width: 10%">Status</th>
                              <th style="width: 15%"></th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalgetbootstrap" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="form_view"></div>
    </div>
</div>
<div class="modal fade" id="modalProses" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalProses" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="form_proses"></div>
    </div>
</div>
<div class="modal fade" id="modalAktivasi" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalProses" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="form_aktivasi"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        const forms = document.querySelectorAll(".needs-validation");
        var tableAjax = $("#table_view").DataTable({
            ajax: "{{ route('pelanggan.getDataMonitoring') }}",
            processing: true,
            serverSide: true,
            autoWidth: true,
            columns: [
                { data: 'no' },
                { data: 'nama_pelanggan' },
                { data: 'alamat' },
                { data: 'paket_internet' },
                { data: 'petugas' },
                { data: 'status' },
                { data: 'act' },
            ],
            responsive: true,
        });
        $("#table_view").on('click', '#btn_show', function(){
            $("#form_proses").load("{{ url('pelanggan/showDetail') }}/"+$(this).val());
        });
        $("#table_view").on('click', '#btn_proses_aktivasi', function(){
            $("#form_aktivasi").load("{{ url('pelanggan/showFormAktivasi') }}/"+$(this).val());
        });
        $("#table_view").on('click', '#btn_detail_finished', function(){
            $("#form_aktivasi").load("{{ url('pelanggan/showDetaiPelangganFinished') }}/"+$(this).val());
        });
    });
</script>
@endsection

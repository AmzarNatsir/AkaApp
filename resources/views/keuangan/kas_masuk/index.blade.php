@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6"><h4>Keuangan</h4></div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg></a></li>
                    <li class="breadcrumb-item">Kas Masuk</li>
                    <li class="breadcrumb-item active">Data Kas Masuk</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-header border-b-info total-revenue">
                    <h4>Filter Data</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label>Tanggal Transaksi</label>
                                <div class="input-group flatpicker-calender">
                                    <input class="form-control" id="range-date-filter" type="date" value="{{ date('Y-m-d') }}" placeholder="Pilih Tanggal Transaksi">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 text-center">
                            <hr>
                            <button class="btn btn-primary" type="button" name="btn_filter" id="btn_filter">Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="row justify-content-center">
                <div class="col-md-12 project-list">
                    <div class="card">
                        <div class="card-header border-b-info total-revenue">
                            <h4>Data Kas Masuk</h4>
                            @can("trans_keuangan_kas_masuk_create")
                            <div class="form-group mb-0 me-0"></div>
                            <button class="btn btn-primary" type="button" id="btn_add" data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap" data-whatever="@getbootstrap"><i data-feather="plus-square"> </i> Data Baru</button>
                            @endcan
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-vcenter" id="list_transaksi" style="font-size: 11pt;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 10%;">No.Transaksi</th>
                                    <th style="width: 10%;">Tgl.&nbsp;Transaksi</th>
                                    <th>Keterangan</th>
                                    <th style="width: 13%; text-align:right">Nominal</th>
                                    <th style="width: 10%">Act.</th>
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
</div>
<div class="modal fade" id="exampleModalgetbootstrap" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="form_view"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        flatpickr("#range-date-filter", {
            mode: "range",
        });
        var tableAjax = $("#list_transaksi").DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            ajax: {
                url: "{{ route('keuangan.kasMasuk.getData') }}",
                type: "post",
                headers : {
                        'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                    },
                data: function (d) {
                    const arrDate = $('#range-date-filter').val().split(" to ");
                    const tglStart = arrDate[0]
                    const tglEnd = arrDate[1]
                    d.tglStart = tglStart;
                    d.tglEnd = tglEnd;
                }
            },

            columns: [
                { data: 'no' },
                { data: 'no_transaksi' },
                { data: 'tgl_transaksi' },
                { data: 'keterangan' },
                { data: 'nominal' },
                { data: 'act' }
            ],
            responsive: true,
            columnDefs: [
                {
                    targets: [0, 1, 2],
                    className: "dt-center"
                },
                {
                    targets: [4],
                    className: "dt-right"
                }
            ]
        });
        $("#btn_add").on("click", function(){
            $("#form_view").load("{{ route('keuangan.kasMasuk.baru') }}");
        });
        $("#btn_filter").on("click", function(){
            const arrDate = $('#range-date-filter').val().split(" to ");
            const tglStart = arrDate[0]
            const tglEnd = arrDate[1]
            tableAjax.ajax.reload();
        });
    });
    var editData = function(el)
    {
        var idItem = el;
        // alert(idItem);
        $("#form_view").load("{{ url('keuangan/kasMasukEdit') }}/"+idItem, function(){
            $(".angka").number(true, 0);
        });
    }
    var konfirmDelete = function(el) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Data will be deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('keuangan/kasMasukDelete') }}/"+el,
                    type: "GET",
                    success: function(response) {
                        if (response.success == true) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Data berhasil dihapus!',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.replace("{{ route('keuangan.kasMasuk.daftar') }}");
                            });
                        } else {
                            Swal.fire('Oops!', 'Data gagal dihapus!', 'warning');
                        }
                    }
                });
            } else {
                Swal.fire('Cancelled', 'Penghapusan data dibatalkan', 'info');
            }
        });
    }
</script>
@endsection

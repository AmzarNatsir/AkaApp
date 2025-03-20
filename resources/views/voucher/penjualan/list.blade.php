@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6"><h4>Penjualan Voucher</h4></div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg></a></li>
                    <li class="breadcrumb-item active">Daftar Penjualan Voucher</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form theme-form">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label>Periode Bulan</label>
                                    <select class="form-control select" name="pilBulan" id="pilBulan" required="">
                                        <option selected="" disabled="" value="">Pilihan...</option>
                                        @foreach ($list_bulan as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label>Periode Tahun</label>
                                    <select class="form-control select" name="pilTahun" id="pilTahun">
                                        <option selected="" disabled="" value="">Pilihan...</option>
                                        @for($yr=$start_year; $yr<=$end_year; $yr++)
                                        <option value="{{ $yr }}">{{ $yr }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Agen Voucher</label>
                                    <select class="form-control select" name="pilAgen" id="pilAgen" required="">
                                        <option selected="" disabled="" value="">Pilihan...</option>
                                        @foreach ($list_agen as $agen)
                                        <option value="{{ $agen->id }}">{{ $agen->nama_agen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-4">
                                <button class="btn btn-primary" type="button" id="btnFilter"><i class="fa fa-table"></i> Preview</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="row justify-content-center">
                <div class="col-md-12 project-list">
                    <div class="card">
                        <div class="card-header border-b-info total-revenue">
                            <h4>Daftar Penjualan Voucher</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar" id="view_form">
                                <table class="table" id="table_view">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 15%">Periode</th>
                                            <th>Agen</th>
                                            <th style="width: 15%">Total Voucher</th>
                                            <th style="width: 15%">Total Laba</th>
                                            {{-- <th style="width: 10%">Status</th> --}}
                                            <th style="width: 10%">Act</th>
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
</div>
<div class="modal fade" id="exampleModalgetbootstrap" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="form_view"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#spinner-div').hide();
        $(".select").select2({
            placeholder: "Pilihan",
            allowClear: true
        });
        var tableAjax = $("#table_view").DataTable({
            ajax: {
                url: "{{ route('voucher.penjualan.list.getData') }}",
                type: "post",
                headers : {
                        'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                    },
                data: function (d)
                {
                    d.bulan = $("#pilBulan").val();
                    d.tahun = $('#pilTahun').val();
                    d.agen = $('#pilAgen').val();
                }
            },
            processing: true,
            serverSide: true,
            autoWidth: true,
            columns: [
                { data: 'no' },
                { data: 'periode' },
                { data: 'agen' },
                { data: 'total_voucher' },
                { data: 'total_laba' },
                // { data: 'status' },
                { data: 'act' },
            ],
            responsive: true,
        });
        $("#btnFilter").on("click", function(){
            tableAjax.ajax.reload();
        });
        $("#table_view").on('click', '#btn_preview_print', function(){
            $("#form_view").load("{{ url('voucher/penjualan/detailToPrint') }}/"+$(this).val());
        });
    });
    var showPrint = function(el)
    {
        var id_head = $(el).val();
        window.open('{{ url("voucher/penjualan/print") }}/'+id_head);
    }

    // var showForm = function()
    // {
    //     if($("#pilBulan").val()=="" || $("#pilBulan").val()==null) {
    //         swal("Warning", "Pilihan periode bulan tidak boleh kosong", "error");
    //         return false;
    //     }
    //     if($("#pilTahun").val()=="" || $("#pilTahun").val()==null) {
    //         swal("Warning", "Pilihan periode tahun tidak boleh kosong", "error");
    //         return false;
    //     }
    //     if($("#pilAgen").val()=="" || $("#pilAgen").val()==null) {
    //         swal("Warning", "Pilihan agen tidak boleh kosong", "error");
    //         return false;
    //     }
    //     var pil_bulan = $("#pilBulan").val();
    //     var pil_tahun = $("#pilTahun").val();
    //     var pil_agen = $("#pilAgen").val();
    //     $("#view_form").load("{{ url('report/penjualanVoucher/load_data_penjualan') }}/"+pil_bulan+"/"+pil_tahun+"/"+pil_agen, function(){
    //         $(".angka").number(true, 0);
    //     });
    // }

    // var showPrint = function()
    // {
    //     if($("#pilBulan").val()=="" || $("#pilBulan").val()==null) {
    //         swal("Warning", "Pilihan periode bulan tidak boleh kosong", "error");
    //         return false;
    //     }
    //     if($("#pilTahun").val()=="" || $("#pilTahun").val()==null) {
    //         swal("Warning", "Pilihan periode tahun tidak boleh kosong", "error");
    //         return false;
    //     }
    //     if($("#pilAgen").val()=="" || $("#pilAgen").val()==null) {
    //         swal("Warning", "Pilihan agen tidak boleh kosong", "error");
    //         return false;
    //     }
    //     var pil_bulan = $("#pilBulan").val();
    //     var pil_tahun = $("#pilTahun").val();
    //     var pil_agen = $("#pilAgen").val();
    //     window.open('{{ url("report/penjualanVoucher/print") }}/'+pil_bulan+"/"+pil_tahun+"/"+pil_agen);
    // }

</script>
@endsection

@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6"><h4>Report</h4></div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg></a></li>
                    <li class="breadcrumb-item active">Penjualan Voucher</li>
                </ol>
            </div>
        </div>
    </div>
    <form id="createForm" class="timepicker-wrapper needs-validation" method="post" novalidate="">
        @csrf
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
                                <button class="btn btn-primary" type="button" onclick="showForm()"><i class="fa fa-table"></i> Preview</button>
                                <button class="btn btn-danger" type="button" onclick="showPrint()"><i class="fa fa-print"></i> Print</button>
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
                            <div class="table-responsive custom-scrollbar" id="view_form"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
</div>
<script>
    $(document).ready(function () {
        $('#spinner-div').hide();
        $(".select").select2({
            placeholder: "Pilihan",
            allowClear: true
        });
    });

    var showForm = function()
    {
        if($("#pilBulan").val()=="" || $("#pilBulan").val()==null) {
            swal("Warning", "Pilihan periode bulan tidak boleh kosong", "error");
            return false;
        }
        if($("#pilTahun").val()=="" || $("#pilTahun").val()==null) {
            swal("Warning", "Pilihan periode tahun tidak boleh kosong", "error");
            return false;
        }
        if($("#pilAgen").val()=="" || $("#pilAgen").val()==null) {
            swal("Warning", "Pilihan agen tidak boleh kosong", "error");
            return false;
        }
        var pil_bulan = $("#pilBulan").val();
        var pil_tahun = $("#pilTahun").val();
        var pil_agen = $("#pilAgen").val();

        $("#view_form").load("{{ url('report/penjualanVoucher/load_data_penjualan') }}/"+pil_bulan+"/"+pil_tahun+"/"+pil_agen, function(){
            $(".angka").number(true, 0);
        });
    }

    var showPrint = function()
    {
        if($("#pilBulan").val()=="" || $("#pilBulan").val()==null) {
            swal("Warning", "Pilihan periode bulan tidak boleh kosong", "error");
            return false;
        }
        if($("#pilTahun").val()=="" || $("#pilTahun").val()==null) {
            swal("Warning", "Pilihan periode tahun tidak boleh kosong", "error");
            return false;
        }
        if($("#pilAgen").val()=="" || $("#pilAgen").val()==null) {
            swal("Warning", "Pilihan agen tidak boleh kosong", "error");
            return false;
        }
        var pil_bulan = $("#pilBulan").val();
        var pil_tahun = $("#pilTahun").val();
        var pil_agen = $("#pilAgen").val();
        window.open('{{ url("report/penjualanVoucher/print") }}/'+pil_bulan+"/"+pil_tahun+"/"+pil_agen);
    }

</script>
@endsection

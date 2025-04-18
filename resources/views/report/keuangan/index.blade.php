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
                    <li class="breadcrumb-item active">Keuangan</li>
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
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Periode Transaksi</label>
                                    <div class="input-group flatpicker-calender">
                                        <input class="form-control" id="range-date-filter" type="date" value="{{ date('Y-m-d') }}" placeholder="Pilih Tanggal Transaksi">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-4">
                                <button class="btn btn-primary" type="button" id="btnFilter" onclick="goFilter()"><i class="fa fa-table"></i> Preview</button>
                                <button class="btn btn-primary btn-sm" type="button" id="loaderDiv" style="display: none">
                                    <i class="fa fa-asterisk fa-spin"></i>
                                </button>
                                {{-- <button class="btn btn-danger" type="button" onclick="showPrint()"><i class="fa fa-print"></i> Print</button> --}}
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
                            <h4>Data Keuangan</h4>
                        </div>
                        <div class="card-body">
                            {{-- <div class="table-responsive custom-scrollbar"></div> --}}
                            <div style="width:100%; height:500px; overflow-y: auto; overflow-x: auto;" class="viewList"></div>
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
        flatpickr("#range-date-filter", {
            mode: "range",
        });
    });
    var goFilter = function()
    {
        var arrDate = $('#range-date-filter').val().split(" to ");
        var tglStart = "";
        var tglEnd = "";
        var ket_periode_tanggal = "";
        if(arrDate=="")
        {
            swal('Warning! Kolom pilihan tanggal masih kosong.', {
                icon: 'warning',
            });
            return false;
        }
        if(arrDate.length==1) {
            tglStart = arrDate[0];
            tglEnd = "";
            ket_periode_tanggal = tglStart;
        } else {
            tglStart = arrDate[0];
            tglEnd = arrDate[1];
            ket_periode_tanggal = tglStart+" s/d "+tglEnd;
        }
        var obj = {};
        obj.tgl_1 = tglStart;
        obj.tgl_2 = tglEnd;
        obj.ket_periode_tanggal = ket_periode_tanggal;
        $.ajax(
        {
            headers : {
                'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
            },
            url: "{{ route('report.keuangan.getdata') }}",
            contentType: "application/json",
            method : 'post',
            dataType: "json",
            data: JSON.stringify(obj),
            beforeSend: function()
            {
                $(".viewList").empty();
                $("#loaderDiv").show();
            },
            success: function(response)
            {
                $(".viewList").html(response.all_result);
                // $(".lbl_periode").html(response.periode);
                $("#loaderDiv").hide();
            }
        });
    }

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

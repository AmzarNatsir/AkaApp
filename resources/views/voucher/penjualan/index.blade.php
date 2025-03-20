@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6"><h4>Voucher</h4></div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg></a></li>
                    <li class="breadcrumb-item">Penjualan Voucher</li>
                    <li class="breadcrumb-item active">Data Baru</li>
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
                                    <label>Periode Bulan</label>
                                    <select class="form-control select" name="pilBulan" id="pilBulan" required="">
                                        <option selected="" disabled="" value="">Pilihan...</option>
                                        @foreach ($list_bulan as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
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
                            <div class="col-sm-2">
                                <button class="btn btn-primary" type="button" onclick="showForm()">Klik untuk menampilkan data</button>
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
                            <h4>Input Penjualan Voucher</h4>
                        </div>
                        <div class="card-body">
                            <div id="spinner-div" class="pt-5 justify-content-center spinner-div">
                                <div class="spinner-border text-primary" role="status">
                                </div>
                            </div>
                            <div id="view_form"></div>
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
        $("#view_form").load("{{ url('voucher/penjualan/load_form') }}/"+pil_bulan+"/"+pil_tahun+"/"+pil_agen, function(){
            $(".angka").number(true, 0);
        });
    }

    var changeToNull = function(el)
    {
        if($(el).val()=="")
        {
            $(el).val("0");
        }
        getTerjual(el);
    }

    var getTerjual = function(el)
    {
        var currentRow=$(el).closest("tr");
        var current_stok_sisa = $(el).parent().parent().find('input[name="inpSisaStok[]"]').val();
        var current_stok_awal = $(el).parent().parent().find('input[name="tempStokAwal[]"]').val();
        var current_stok_tambahan = $(el).parent().parent().find('input[name="inpStokTambahan[]"]').val();
        var current_harga_modal = $(el).parent().parent().find('input[name="inphargaModal[]"]').val();
        var current_total_stok = parseFloat(current_stok_awal) + parseFloat(current_stok_tambahan);
        var current_stok_terjual = parseFloat(current_total_stok) - parseFloat(current_stok_sisa);
        var current_total_laba = parseFloat(current_harga_modal) * parseFloat(current_stok_terjual);


        if(parseFloat(current_stok_sisa) > parseFloat(current_total_stok))
        {
            swal("Jumlah stok sisa tidak boleh > "+current_total_stok+" !", { icon: "error" });
            $(el).parent().parent().find('input[name="inpSisaStok[]"]').val("0");
            current_stok_terjual = current_total_stok;
            current_total_laba = parseFloat(current_harga_modal) * parseFloat(current_total_stok);
            // $(el).parent().parent().find('input[name="inpStokTerjual[]"]').val(current_stok_terjual);
            // $(el).parent().parent().find('input[name="inpSubTotal[]"]').val(current_total_laba);
            // return false;
        }

        $(el).parent().parent().find('input[name="inpStokTerjual[]"]').val(current_stok_terjual);
        $(el).parent().parent().find('input[name="inpSubTotal[]"]').val(current_total_laba);
        calculateTotalSisa();
        calculateTotalTerjual();
        calculateTotalLaba();
    }

    var calculateTotalSisa = function()
    {
        var total = 0;
        $.each($('input[name="inpSisaStok[]"]'),function(key, value){
            total += parseFloat($(value).val());
        })
        $("#inpTotalSisa").val(total);
    }

    var calculateTotalTerjual = function()
    {
        var total = 0;
        $.each($('input[name="inpStokTerjual[]"]'),function(key, value){
            total += parseFloat($(value).val());
        })
        $("#inpTotalTerjual").val(total);
    }

    var calculateTotalLaba = function()
    {
        var total = 0;
        $.each($('input[name="inpSubTotal[]"]'),function(key, value){
            total += parseFloat($(value).val());
        })
        $("#inpTotalLaba").val(total);
    }


    document.querySelector('#createForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting
        var pil_bulan = $("#pilBulan").val();
        var pil_tahun = $("#pilTahun").val();
        var pil_agen = $("#pilAgen").val();
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
        // alert($("#pilKategori").val());
        swal({
            title: "Anda yakin menyimpan penjualan voucher ?",
            text: "Realisasi penjualan voucher !",
            type: "warning",
            buttons: {
            confirm: {
                text: "Simpan!",
                className: "btn btn-success",
            },
            cancel: {
                visible: true,
                className: "btn btn-danger",
            },
            },
        }).then((result) => {
            if (result==true) {
                $.ajax({
                    url: "{{ route('voucher.penjualan.store') }}", // Update this with your route
                    type: "POST",
                    data: $(this).serialize(),
                    beforeSend: function()
                    {
                        $(".view_form").empty();
                        $('#spinner-div').show();
                    },
                    success: function (response) {
                        if (response.success==true) {
                            swal('Success! '+response.message, {
                                icon: 'success',
                                buttons: false,
                                timer: 2000
                            }).then(() => {
                                location.replace("{{ route('voucher.penjualan') }}");
                            });

                        } else {
                            swal("Terjadi kesalahan", response.message, "error");
                            return false;
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText); // Debugging errors
                        swal("Terjadi kesalahan", "Ada yang salah!", "error");
                    },
                    complete: function()
                    {
                        $('#spinner-div').hide();
                    }
                });
            } else {
                swal.close();
            }

        });
    });

</script>
@endsection

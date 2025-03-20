@extends('partial.mainApp')
@section('content')
<style>
    /* Simple Spinner Styling */
    .spinner {
        font-size: 14px;
        color: #007bff;
        margin-left: 10px;
    }
</style>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Material</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg></a></li>
                    <li class="breadcrumb-item">Baru</li>
                    <li class="breadcrumb-item">Daftar Material</li>
                    <li class="breadcrumb-item active">Kartu Stok</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row product-page-main p-0">
        <div class="col-xxl-4 col-md-6 box-col-6">
            <div class="card">
                <div class="card-body">
                  <!-- side-bar colleps block stat-->
                  <div class="filter-block">
                    <h4>Pilih Material</h4>
                    <hr>
                    <select class="form-select select" id="selectItem" name="selectItem" required="">
                        <option selected="" disabled="" value="">Pilihan...</option>
                        @foreach ($list_material as $r)
                        <option value="{{ $r->id }}">{{ $r->material }}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                  <!-- side-bar colleps block stat-->
                  <div class="filter-block">
                    <div class="card-body">
                        <ul class="product-costing">
                            <li class="product-cost">
                              <div class="product-icon bg-primary-light">
                                <svg>
                                  <use href="{{ asset('assets/svg/icon-sprite.svg#activity') }}"></use>
                                </svg>
                              </div>
                              <div><span class="f-w-500 f-14 mb-0">Gudang Utama</span>
                                <h5 class="f-w-600" id="stok_awal_utama">Stok Awal : 0</h5>
                                <h5 class="f-w-600" id="stok_akhir_utama">Stok Akhir : 0</h5>
                              </div>
                            </li>
                            <li><button type="button" class="btn btn-sm btn-primary btn-block" name="btn_gudang_utama" id="btn_gudang_utama" value="1" onclick="goDetail(this)">Klik untuk melihat data transaksi</button></li>
                        </ul>
                        <hr>
                        <div id="list_cabang"></div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-8 box-col-6 order-xxl-0 order-1">
            <div class="card">
                <div class="card-body">
                    <div class="product-page-details">
                        <h3 id="nama_material"></h3>
                    </div>
                    <div class="product-price" id="material_merk_satuan"></div>
                    <hr>
                      <p id="keterangan_material"></p>
                    <hr>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Kartu Stok</h4><span>Informasi pergerakan stok</span>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs border-tab mb-0" id="bottom-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link nav-border txt-info tab-info pt-0 active" id="bottom-penerimaan-tab" data-bs-toggle="tab" href="#bottom-penerimaan" role="tab" aria-controls="bottom-penerimaan" aria-selected="true">Penerimaan <span class="badge  badge-p-space badge-secondary" id="total_penerimaan">0</span></a></li>
                        <li class="nav-item"><a class="nav-link nav-border txt-info tab-info" id="bottom-pemakaian-tab" data-bs-toggle="tab" href="#bottom-pemakaian" role="tab" aria-controls="bottom-pemakaian" aria-selected="false">Pemakaian <span class="badge  badge-p-space badge-success" id="total_pemakaian">0</span></a></li>
                        <li class="nav-item"><a class="nav-link nav-border txt-info tab-info" id="bottom-pengembalian-tab" data-bs-toggle="tab" href="#bottom-pengembalian" role="tab" aria-controls="bottom-pengembalian" aria-selected="false">Pengembalian <span class="badge  badge-p-space badge-dark" id="total_pengembalian">0</span></a></li>
                    </ul>
                    <div class="tab-content page_detail" id="bottom-tabContent">
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
        console.log("Spinner disembunyikan...");
        $('#spinner-div').hide();
        $(".select").select2({
            placeholder: "Pilihan",
            allowClear: true
        }).on('change', function(){
            var selectedValue = $(this).val();
            if(selectedValue==null)
            {
                $("#nama_material").html("");
                $("#material_merk_satuan").html("");
                $("#keterangan_material").html("");
                $("#stok_awal_utama").html("Stok Awal: 0");
                $("#stok_akhir_utama").html("Stok Akhir: 0");
                $("#total_penerimaan").html("0");
                $("#total_pemakaian").html("0");
                $("#total_pengembalian").html("0");
                $("#list_cabang").empty();
                $("#list_penerimaan").empty();
                $("#table_penerimaan").DataTable().clear().draw();
                $("#table_pemakaian").DataTable().clear().draw();
                $("#table_pengembalian").DataTable().clear().draw();
                setDefaultTabActive();
            }
            $.ajax({
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                url: "{{ route('material.kontrol.get_data') }}", // Update this with your route
                type: "POST",
                dataType: "json",
                delay: 250,
                data: {
                    itemID: selectedValue
                },
                beforeSend: function () {
                    $("#selectItem").parent().append('<span class="spinner">Loading...</span>');
                    $("#list_cabang").empty();
                    $("#list_penerimaan").empty();
                },
                success: function (data) {
                    setDefaultTabActive();
                    $("#nama_material").html(data.material);
                    $("#material_merk_satuan").html(data.material_merk + " - " + data.material_satuan);
                    $("#keterangan_material").html(data.material_keterangan);
                    $("#stok_awal_utama").html("Stok Awal: "+ data.material_stok_awal);
                    $("#stok_akhir_utama").html("Stok Akhir: "+ data.material_stok_akhir);
                    $("#total_penerimaan").html(data.total_penerimaan);
                    $("#total_pemakaian").html(data.total_pemakaian);
                    $("#total_pengembalian").html(data.total_pengembalian);
                    data.list_cabang.forEach(function(item, index) {
                        console.log("Index: " + item['id'] + ", Value: ", item['nama_cabang']);
                        var ls_cabang = '<ul class="product-costing">' +
                            '<li class="product-cost">' +
                            '<div class="product-icon bg-secondary-light">' +
                            '<svg><use href="{{ asset("assets/svg/icon-sprite.svg") }}"></use></svg>' +
                            '</div>' +
                            '<div><span class="f-w-500 f-14 mb-0">'+ item['nama_cabang'] +'</span>' +
                            '<h2 class="f-w-600">0</h2>' +
                            '</div>' +
                            '</li>' +
                            '<li><button type="button" class="btn btn-sm btn-primary btn-block" name="btn_gudang_utama" id="btn_gudang_utama" value="'+ item['id'] +'" disabled>Klik untuk melihat data transaksi</button></li>' +
                            '</ul><hr>';
                        $("#list_cabang").append(ls_cabang);
                    });
                },
                complete: function () {
                    // Remove loading spinner after request completes
                    $(".spinner").remove();
                }

            });
        });
    });

    var goDetail = function(el)
    {
        // $('#spinner-div').show();
        var idItem = $("#selectItem").val();
        var idCabang = $(el).val();
        $(".page_detail").load("{{ url('material/getDetailTransaksi') }}/"+idCabang+"/"+idItem, function(){
            setDefaultTabActive();
            $("#table_penerimaan").DataTable();
            $("#table_pemakaian").DataTable();
            $("#table_pengembalian").DataTable();
        });
    }

    function setDefaultTabActive()
    {
        $("#bottom-penerimaan-tab").addClass('active');
        $("#bottom-pemakaian-tab").removeClass('active');
        $("#bottom-pengembalian-tab").removeClass('active');
    }
</script>
@endsection

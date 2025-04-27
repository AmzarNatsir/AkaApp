@extends('partial.mainApp')
@section('content')
<style type="text/css">

    input[type=number]
    {
      -moz-appearance: textfield;
    }
</style>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6"><h4>Pengembalian Material</h4></div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pengembalian.material.index') }}">Pilihan Gudang</a></li>
                    <li class="breadcrumb-item active">Data Baru</li>
                </ol>
            </div>
        </div>
    </div>
    <form id="createForm" class="timepicker-wrapper needs-validation" method="post" novalidate="">
    @csrf
    <input type="hidden" name="gudangID" id="gudangID" value="{{ $gudangID }}">
    <input type="hidden" name="totalItem" id="totalItem" value="0">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="form theme-form">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label>Tanggal</label>
                                    <input class="form-control" name="inpTanggal" id="datetime-local" type="date" value="{{ date('Y-m-d') }}" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label>Keterangan</label>
                                    <textarea name="inpKeterangan" id="inpKeterangan" class="form-control" required=""></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <hr>
                                <button class="btn btn-primary" type="submit">Submit form</button>
                                <hr>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="row justify-content-center">
                <div class="col-md-12 project-list">
                    <div class="card">
                        <div class="card-header border-b-info total-revenue">
                            <h4>Pilihan Material</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-8">
                                    <select class="form-control select" name="pilItem" id="pilItem" required="">
                                        <option selected="" disabled="" value="">Pilihan...</option>
                                        @foreach ($list_material as $r)
                                        <option value="{{ $r->id }}">{{ $r->material }} - {{ $r->getMerek->merek }} (Stok : {{ $r->stok_akhir }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <button type="button" class="btn btn-primary btn-square" name="btn_add_item" id="btn_add_item" onclick="addItem(this)"><i class="fa fa-plus"></i> Tambah Item</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-12 project-list">
                    <div class="card">
                        <div class="card-header border-b-info total-revenue">
                            <h4>Item Material</h4>
                        </div>
                        {{-- <div class="row"> --}}
                            <div class="card-body pt-0">
                                <div class="table-order table-responsive custom-scrollbar">
                                    <table class="table" style="width: 100%">
                                        <thead>
                                            <th style="width: 5%"></th>
                                            <th>Material</th>
                                            <th style="width: 15%">Jumlah</th>
                                        </thead>
                                        <tbody class="row_baru"></tbody>
                                    </table>
                                </div>
                            </div>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>

        </div>
    </div>

    </form>
</div>
<script>
    $(document).ready(function () {
        $(".select").select2({
            placeholder: "Pilihan",
            allowClear: true
        });
        calculateTotalItem();
    });
    var addItem = function(el)
    {
        var materialID = $("#pilItem").val();
        $.ajax({
            headers : {
                'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
            },
            url: "{{ route('pengembalian.meterial.getItem') }}", // Update this with your route
            type: "POST",
            data: {
                itemID: materialID
            },
            success: function (response) {
                if (response.success==true) {
                    // alert(response.message);
                    var content_item = '<tr class="rows_item" name="rows_item[]"><td><input type="hidden" name="current_stok[]" value='+response.result.stok_akhir+'><input type="hidden" name="current_harga[]" value='+response.result.harga_beli+'><button type="button" title="Hapus Baris" class="btn btn-danger btn-square btn-sm" onclick="hapus_item(this)"><i class="fa fa-minus"></i></button></td>'+
                        '<td><input type="hidden" name="item_id_material[]" value="'+response.result.id+'"><div class="product-names"><p>'+response.result.material+'</p></div></td>'+
                        '<td align="center"><input type="text" min="1" max="'+response.result.stok_akhir+'" id="item_qty[]" name="item_qty[]" class="form-control angka" value="1" style="text-align:center" onblur="changeToNull(this)"></td>'+'</tr>';
                    $(".row_baru").after(content_item);
                    $(".angka").number(true, 0);
                    calculateTotalItem();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: "It's danger!",
                        text: "Something went wrong! "+response.message
                    });
                    return false;
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText); // Debugging errors
                Swal.fire({
                    icon: 'error',
                    title: "It's danger!",
                    text: "Something went wrong! "+response.message
                });
            }
        });
    }

    var hapus_item = function(el){
        $(el).parent().parent().slideUp(100,function(){
            $(this).remove();
            calculateTotalItem();
        });

    }

    var changeToNull = function(el)
    {
        if($(el).val()=="")
        {
            $(el).val("1");
        }
        calculateTotalItem();
    }

    var calculateTotalItem = function()
    {
        var total = 0;
        $.each($('input[name="item_qty[]"]'),function(key, value){
            total += parseFloat($(value).val());
        });
        $("#totalItem").val(total);
    }

    document.querySelector('#createForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting
        if($("#inpKeterangan").val()=="") {
            Swal.fire({
                icon: 'Warning',
                title: "Warning!",
                text: "Pengisian keterangan transaksi tidak boleh kosong! "
            });
            return false;
        }
        if($("#totalItem").val()==0) {
            Swal.fire({
                icon: 'Warning',
                title: "Warning!",
                text: "Item pemakaian material masih kosong! "
            });
            return false;
        }
        // alert($("#pilKategori").val());

        Swal.fire({
            title: "Are you sure?",
            text: "Submit this item!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, save it!",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('pengembalian.material.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.success == true) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.replace("{{ url('pengembalianMaterial/baru') }}/"+$("#gudangID").val());
                            });
                        } else {
                            Swal.fire("Terjadi kesalahan", response.message, "error");
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        Swal.fire("It's danger", "Something went wrong!", "error");
                    }
                });
            } else {
                Swal.close();
            }
        });
    });
</script>
@endsection

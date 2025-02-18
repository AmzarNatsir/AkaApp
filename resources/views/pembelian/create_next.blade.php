@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Pembelian</h4>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('material.index') }}">Daftar</a></li>
                    <li class="breadcrumb-item active">Pembelian Baru</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Pembelian Material Baru</h4>
                </div>
                <div class="card-body main-flatpickr">
                    <div class="card-wrapper border rounded-3">
                        <form id="updateForm" class="timepicker-wrapper needs-validation" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                            <input type="hidden" class="form-control" name="inpID" id="inpID" value="{{ $dataH->id }}" readonly>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="row g-3">
                                        <label class="col-md-6 text-start">Nomor</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="inpNomor" id="inpNomor" value="{{ $dataH->nomor }}" readonly>
                                        </div>
                                        <label class="col-md-6 text-start">Tanggal</label>
                                        <div class="col-md-6">
                                            <div class="input-group flatpicker-calender">
                                                <input class="form-control" name="inpTanggal" id="inpTanggal" value="{{ $dataH->tanggal }}" readonly>
                                            </div>
                                        </div>
                                        <label class="col-md-6 text-start">Total (Rp.)</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control angka" name="inpTotal" id="inpTotal" value="{{ $dataH->total }}" style="text-align: right" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="row g-3">
                                        <div class="col-md-12 position-relative">
                                            <label class="form-label" for="inpHargaBeli">Keterangan</label>
                                            <textarea class="form-control" name="inpKeterangan" id="inpKeterangan" rows="4" readonly>{{ $dataH->keterangan }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 project-list">
                                <div class="card">
                                    <div class="card-header border-b-info total-revenue">
                                        <h4>Item Pembelian</h4>
                                        @if($dataH->status=="draft")
                                        <button class="btn btn-primary" type="button" id="btn_add" data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap" data-whatever="@getbootstrap"><i data-feather="plus-square"> </i> Add Item Pembelian</button>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="card-body pt-0">
                                            <div class="table-order table-responsive custom-scrollbar">
                                                <table class="table" style="width: 100%;border-spacing:0;" id="view_items">
                                                    <thead>
                                                    <tr style="background: #006666;">
                                                        <th style="padding: 18px 15px;text-align: left"><span style="color: #fff; font-size: 18px; font-weight: 600;">Material</span></th>
                                                        <th style="padding: 18px 15px;text-align: center;border-inline: 3px solid #fff; width: 10%"><span style="color: #fff; font-size: 18px; font-weight: 600;">Jumlah</span></th>
                                                        <th style="padding: 18px 15px;text-align: center;border-right: 3px solid #fff; width: 15%"><span style="color: #fff; font-size: 18px; font-weight: 600;">Harga</span></th>
                                                        <th style="padding: 18px 15px;text-align: center; border-right: 3px solid #fff; width: 15%"><span style="color: #fff; font-size: 18px; font-weight: 600;">Subtotal</span></th>
                                                        <th style="padding: 18px 15px;text-align: center; width: 10%"><span style="color: #fff; font-size: 18px; font-weight: 600;">Act</span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr>
                            <div class="row col-12 justify-content-center">
                                @if($dataH->status=="draft")
                                <button class="btn btn-danger" type="submit">Finish</button>
                                @endif
                            </div>
                            <hr>
                        </form>
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
        const forms = document.querySelectorAll(".needs-validation");
        var tableAjax = $("#view_items").DataTable({
            // ajax: "{{ route('pembelian.getDataItems') }}",
            searching: false,
            ordering: false,
            processing: true,
            serverSide: true,
            autoWidth: true,
            ajax: {
                url: "{{ route('pembelian.getDataItems') }}",
                data: function (d) {
                    d.headID = $('#inpID').val();
                }
            },

            columns: [
                { data: 'material' },
                { data: 'jumlah' },
                { data: 'harga' },
                { data: 'sub_total' },
                { data: 'act' },
            ],
            responsive: true,
            columnDefs: [
                {
                    class: 'dt-center',
                    targets: [ 1, 4]
                },
                {
                    class: 'dt-right',
                    targets: [ 2, 3]
                },
            ]
        });
        Array.from(forms).forEach((form) => {
            form.addEventListener(
            "submit",
            (event) => {
                if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                }

                form.classList.add("was-validated");
            },
            false
            );
        });
        $(".angka").number(true, 0);
        $("#btn_add").on("click", function(){
            var idData = $("#inpID").val();
            $("#form_view").load("{{ url('pembelian/formAddItems') }}/"+idData, function(){
                $(".select").select2({
                    placeholder: "Pilihan",
                    allowClear: true,
                    dropdownParent: $("#exampleModalgetbootstrap")
                });
                $(".angka").number(true, 0);
            });
        });
        $('#updateForm').submit(function (e) {
            var idData = $("#inpID").val();
            let formData = new FormData(document.getElementById('updateForm'));
            e.preventDefault(); // Prevent default form submission
            $.ajax({
                url: "{{ url('pembelian/finishTrans') }}/"+idData, // Update this with your route
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response.success==true) {
                        swal('Success! '+response.message, {
                            icon: 'success',
                            buttons: false,
                            timer: 2000
                        }).then(() => {
                            location.replace("{{ url('pembelian/addDetail') }}/"+idData);
                            // $('#view_items').DataTable().ajax.reload();
                        });
                    } else {
                        swal('Warning! '+response.message, {
                            icon: 'warning',
                        });
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText); // Debugging errors
                    swal("It's danger", "Something went wrong!", "error");
                }
            });
        });

    });
    var editData = function(el)
    {
        var idItem = el;
        $("#form_view").load("{{ url('pembelian/formEditItem') }}/"+idItem, function(){
            $(".angka").number(true, 0);
        });
    }
    var konfirmDelete = function(el)
    {
        var idData = $("#inpID").val();
        swal({
        title: 'Are you sure?',
        text: 'Data has been delete!',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete)
        {
            $.ajax({
                url: "{{ url('pembelian/destroyItem') }}/"+el,
                type: "GET",
                success:function(response){
                    if(response.success==true) {
                        swal('Success! '+response.message, {
                            icon: 'success',
                            buttons: false,
                            timer: 2000
                        }).then(() => {
                            location.replace("{{ url('pembelian/addDetail') }}/"+idData);
                            // $('#view_items').DataTable().ajax.reload();
                        });
                    } else {
                        swal('Warning! '+response.message, {
                            icon: 'warning',
                        });
                    }
                }
            });
        } else {
            swal('Warning! Selected data failed to delete!', {
                icon: 'warning',
            });
        }
        });
    }
</script>
@endsection

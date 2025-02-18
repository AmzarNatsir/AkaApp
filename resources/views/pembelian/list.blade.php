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
                    <li class="breadcrumb-item"><a href="{{ route('pembelian.create') }}">Baru</a></li>
                    <li class="breadcrumb-item active">Daftar</a></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Pembelian Material</h4>
                </div>
                <div class="card-body main-flatpickr">
                    <div class="card-wrapper border rounded-3">
                        <div class="row">
                            <div class="card-body pt-0">
                                <div class="table-order table-responsive custom-scrollbar">
                                    <table class="table" style="width: 100%;border-spacing:0;" id="view_items">
                                        <thead>
                                        <tr style="background: #006666;">
                                            <th style="color: white; width: 5%">#</th>
                                            <th style="color: white; width: 10%">Tanggal</th>
                                            <th style="color: white; width: 10%">Nomor</th>
                                            <th style="color: white; width: 15%">Total</th>
                                            <th style="color: white">Keterangan</th>
                                            <th style="color: white; width: 10%">Act</th>
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
</div>
<div class="modal fade" id="exampleModalgetbootstrap" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="form_view"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        const forms = document.querySelectorAll(".needs-validation");
        var tableAjax = $("#view_items").DataTable({
            // ajax: "{{ route('pembelian.getDataItems') }}",
            processing: true,
            serverSide: true,
            autoWidth: true,
            ajax: {
                url: "{{ route('pembelian.getData') }}",
                // data: function (d) {
                //     d.headID = $('#inpID').val();
                // }
            },

            columns: [
                { data: 'no' },
                { data: 'tanggal' },
                { data: 'nomor' },
                { data: 'total' },
                { data: 'keterangan' },
                { data: 'act' },
            ],
            responsive: true,
            columnDefs: [
                {
                    class: 'dt-center',
                    targets: [ 0, 1, 2]
                },
                {
                    class: 'dt-right',
                    targets: [ 3 ]
                },
            ]
        });
    });
    var editData = function(el)
    {
        var idItem = el;
        location.replace("{{ url('pembelian/addDetail') }}/"+idItem);

    }
    var detailData = function(el)
    {
        var idItem = el;
        $("#form_view").load("{{ url('pembelian/showDetail') }}/"+idItem, function(){
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

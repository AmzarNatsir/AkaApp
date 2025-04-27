@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Asset</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg></a></li>
                    <li class="breadcrumb-item active">Daftar Asset</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        @can('material_create')
        <div class="col-md-12 project-list">
            <div class="card">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group mb-0 me-0"></div>
                  <button class="btn btn-primary" type="button" id="btn_add" data-bs-toggle="modal" data-bs-target="#modalAddAsset" data-whatever="@getbootstrap"><i data-feather="plus-square"> </i> Data Baru</button>
                </div>
              </div>
            </div>
        </div>
        @endcan
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Asset</h4><span>Daftar data asset</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar">
                        <table class="display" id="table_view" style="width: 100%">
                            <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th>Nama Barang</th>
                                <th style="width: 20%">Kategori</th>
                                <th style="width: 15%">Tgl. Perolehan</th>
                                <th style="width: 15%">Harga Perolehan</th>
                                <th style="width: 10%;">Jumlah</th>
                                <th style="width: 10%">Opsi</th>
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
<div class="modal fade" id="modalAddAsset" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="form_view"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        const forms = document.querySelectorAll(".needs-validation");
        // var tableAjax = $("#table_view").DataTable({
        //     ajax: "{{ route('material.getData') }}",
        //     processing: true,
        //     serverSide: true,
        //     autoWidth: true,
        //     columns: [
        //         { data: 'no' },
        //         { data: 'material' },
        //         { data: 'merek' },
        //         { data: 'jumlah' },
        //         { data: 'satuan' },
        //         { data: 'harga' },
        //         { data: 'act' },
        //     ],
        //     responsive: true,
        // });
        $("#btn_add").on("click", function(){
            $("#form_view").load("{{ route('asset.create') }}");
        })
    });
    // var konfirmDelete = function(el)
    // {
    //     swal({
    //     title: 'Yakin akan menghapus data?',
    //     text: 'Data material!',
    //     icon: 'warning',
    //     buttons: true,
    //     dangerMode: true,
    //     })
    //     .then((willDelete) => {
    //     if (willDelete)
    //     {
    //         $.ajax({
    //             url: "{{ url('material/destroy') }}/"+el,
    //             type: "GET",
    //             success:function(response){
    //                 if(response.success==true) {
    //                     swal(response.message, {
    //                         icon: 'success',
    //                         buttons: false,
    //                         timer: 2000
    //                     }).then(() => {
    //                         $('#table_view').DataTable().ajax.reload();
    //                     });
    //                 } else {
    //                     swal(response.message, {
    //                         icon: 'warning',
    //                     });
    //                 }
    //             }
    //         });
    //     } else {
    //         swal('Warning! Selected data failed to delete!', {
    //             icon: 'warning',
    //         });
    //     }
    //     });
    // }
</script>
@endsection

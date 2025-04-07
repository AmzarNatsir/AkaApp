@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Manajemen Data</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg></a></li>
                    <li class="breadcrumb-item">Data Master</li>
                    <li class="breadcrumb-item active">Satuan</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        @can('master_satuan_create')
        <div class="col-md-12 project-list">
            <div class="card">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group mb-0 me-0"></div>
                  <button class="btn btn-primary" type="button" id="btn_add" data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap" data-whatever="@getbootstrap"><i data-feather="plus-square"> </i> Data Baru</button>
                    <div class="table-responsive custom-scrollbar">
                </div>
              </div>
            </div>
        </div>
        @endcan
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Satuan</h4><span>Daftar data satuan</span>
                </div>
                <div class="card-body">

                        <table class="display" id="table_view">
                          <thead>
                            <tr>
                              <th style="width: 5%">#</th>
                              <th>Satuan</th>
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
<div class="modal fade" id="exampleModalgetbootstrap" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="form_view"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        const forms = document.querySelectorAll(".needs-validation");
        var tableAjax = $("#table_view").DataTable({
            ajax: "{{ route('datamaster.satuan.getdata') }}",
            processing: true,
            serverSide: true,
            autoWidth: true,
            columns: [
                { data: 'no' },
                { data: 'satuan' },
                { data: 'act' },
            ],
            responsive: true,
        });
        $("#btn_add").on("click", function(){
            $("#form_view").load("{{ route('datamaster.satuan.create') }}");
        });
        $("#table_view").on('click', '#btn_edit', function(){
            $("#form_view").load("{{ url('dataMaster/satuan/edit') }}/"+$(this).val());
        });
    });
    var konfirmDelete = function(el)
    {
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
                url: "{{ url('dataMaster/satuan/destroy') }}/"+$(el).val(),
                type: "GET",
                success:function(response){
                    if(response.success==true) {
                        swal('Success! The selected data has been successfully deleted!', {
                            icon: 'success',
                            buttons: false,
                            timer: 2000
                        }).then(() => {
                            $('#table_view').DataTable().ajax.reload();
                        });
                    } else {
                        swal('Warning! Selected data failed to delete!', {
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

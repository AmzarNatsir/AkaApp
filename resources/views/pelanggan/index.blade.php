@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Registrasi Pelanggan Baru</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg></a></li>
                    <li class="breadcrumb-item active">Daftar</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        @can("pelanggan_create")
        <div class="col-md-12 project-list">
            <div class="card">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group mb-0 me-0"></div>
                  <button class="btn btn-primary" type="button" id="btn_add" data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap" data-whatever="@getbootstrap"><i data-feather="plus-square"> </i> Registrasi Pelanggan Baru</button>
                    <div class="table-responsive custom-scrollbar">
                </div>
              </div>
            </div>
        </div>
        @endcan
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Pelanggan Baru</h4><span>Daftar pelanggan baru</span>
                </div>
                <div class="card-body table-responsive">
                        <table class="display" id="table_view">
                          <thead>
                            <tr>
                              <th style="width: 5%">#</th>
                              <th>Nama Pelanggan</th>
                              <th style="width: 20%">Alamat</th>
                              <th style="width: 15%">No.Telepon</th>
                              <th style="width: 15%">Wilayah</th>
                              <th style="width: 15%">Paket</th>
                              <th style="width: 15%"></th>
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
<div class="modal fade" id="modalProses" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalProses" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="form_proses"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        const forms = document.querySelectorAll(".needs-validation");
        var tableAjax = $("#table_view").DataTable({
            ajax: "{{ route('pelanggan.getData') }}",
            processing: true,
            serverSide: true,
            autoWidth: true,
            columns: [
                { data: 'no' },
                { data: 'nama_pelanggan' },
                { data: 'alamat' },
                { data: 'no_telepon' },
                { data: 'wilayah' },
                { data: 'paket_internet' },
                { data: 'act' },
            ],
            responsive: true,
        });
        $("#btn_add").on("click", function(){
            $("#form_view").load("{{ route('pelanggan.create') }}");
        });
        $("#table_view").on('click', '#btn_edit', function(){
            $("#form_view").load("{{ url('pelanggan/edit') }}/"+$(this).val());
        });
        $("#table_view").on('click', '#btn_show', function(){
            $("#form_view").load("{{ url('pelanggan/show') }}/"+$(this).val());
        });
        $("#table_view").on('click', '#btn_proses', function(){
            $("#form_proses").load("{{ url('pelanggan/proses') }}/"+$(this).val());
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
                url: "{{ url('pelanggan/destroy') }}/"+$(el).val(),
                type: "GET",
                success:function(response){
                    if(response.success==true) {
                        swal('Data berhasil dihapus!', {
                            icon: 'success',
                            buttons: false,
                            timer: 2000
                        }).then(() => {
                            $('#table_view').DataTable().ajax.reload();
                        });
                    } else {
                        swal('Warning! Data yang dipilih gagal dihapus!', {
                            icon: 'warning',
                        });
                    }
                }
            });
        } else {
            swal('Warning! Data yang dipilih gagal dihapus!', {
                icon: 'warning',
            });
        }
        });
    }
</script>
@endsection

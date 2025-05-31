@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Pelanggan</h4>
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
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Pelanggan</h4>
                </div>
                <div class="card-body table-responsive">
                    <div class="table-responsive custom-scrollbar">
                        <table class="display" id="table_view">
                          <thead>
                            <tr>
                              <th style="width: 5%">#</th>
                              <th>Nama Pelanggan</th>
                              <th style="width: 20%">Alamat</th>
                              <th style="width: 15%">No.Telepon</th>
                              <th style="width: 15%">Wilayah</th>
                              <th style="width: 15%">Paket</th>
                              <th style="width: 15%">Sales</th>
                              <th style="width: 10%">Aktivasi</th>
                              <th style="width: 5%"></th>
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
<div class="modal fade" id="modalProfil" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalProfil" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="form_profil"></div>
    </div>
</div>
<div class="modal fade" id="modalPembayaran" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalPembayaran" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="form_list_pembayaran"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var tableAjax = $("#table_view").DataTable({
            ajax: "{{ route('pelanggan.getDataPelanggan') }}",
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
                { data: 'sales' },
                { data: 'tgl_aktivasi' },
                { data: 'act' },
            ],
            responsive: true,
        });
        $("#table_view").on("click", "#btn_profil", function(){
            $("#form_profil").load("{{ url('pelanggan/profilPelanggan') }}/"+$(this).val());
        });
        $("#table_view").on('click', '#btn_edit', function(){
            window.location.href = "{{ url('pelanggan/editPelanggan') }}/"+$(this).val();
        });
        $("#table_view").on("click", "#btn_pembayaran", function(){
            $("#form_list_pembayaran").load("{{ url('pelanggan/listPembayaranPelanggan') }}/"+$(this).val());
        });
    });
    var konfirmDelete = function(el) {
        Swal.fire({
            title: 'Yakin akan menghapus data pelanggan?',
            text: 'Hapus data pelanggan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('pelanggan/destroyPelangganAktif') }}/" + $(el).val(),
                    type: "GET",
                    success: function(response) {
                        if (response.success == true) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                $('#table_view').DataTable().ajax.reload();
                            });
                        } else {
                            Swal.fire('Oops!', 'Data gagal dihapus!', 'warning');
                        }
                    }
                });
            } else {
                Swal.fire('Cancelled', 'Penghapusan data dibatalkan', 'info');
            }
        });
    }
</script>
@endsection

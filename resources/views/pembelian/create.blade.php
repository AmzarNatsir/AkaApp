@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Penerimaan</h4>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pembelian.list') }}">Daftar</a></li>
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
                        <form id="createForm" action="{{ route('pembelian.storeHead') }}" class="timepicker-wrapper needs-validation" method="post" enctype="multipart/form-data" novalidate="">
                        @csrf
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="row g-3">
                                        <label class="col-md-6 text-start">Tanggal</label>
                                        <div class="col-md-6">
                                            <div class="input-group flatpicker-calender">
                                                <input class="form-control" name="inpTanggal" id="datetime-local" type="date" value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8">
                                    <div class="row g-3">
                                        <label class="col-md-2 text-start">Keterangan</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="inpKeterangan" id="inpKeterangan" maxlength="100" required>
                                            <div class="invalid-tooltip">Anda belum mengisi keterangan transaksi</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 project-list">
                                <div class="card">
                                    <div class="card-header border-b-info total-revenue">
                                        <h4>Item Pembelian</h4><button class="btn btn-primary" type="submit">Submit form</button>
                                    </div>
                                    <div class="row">
                                        <div class="card-body pt-0">
                                            <div class="table-order table-responsive custom-scrollbar">
                                                <table class=" w-100 tranaction-table">
                                                    <thead>
                                                        <th style="width: 5%">No</th>
                                                        <th>Material</th>
                                                        <th style="width: 15%">Merek</th>
                                                        <th style="width: 10%">Jumlah</th>
                                                        <th style="width: 10%">Satuan</th>
                                                        <th style="width: 15%">Harga</th>
                                                        <th style="width: 15%">Sub Total</th>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        const forms = document.querySelectorAll(".needs-validation");
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

        $('#createForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            $.ajax({
                url: "{{ route('pembelian.storeHead') }}", // Update this with your route
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    if (response.success==true) {
                        swal('Success! '+response.message, {
                            icon: 'success',
                            buttons: false,
                            timer: 2000
                        }).then(() => {
                            location.replace("{{ url('pembelian/addDetail') }}/"+response.dataID);
                        });

                    } else {
                        swal("It's danger", response.message, "error");
                        return false;
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText); // Debugging errors
                    swal("It's danger", "Something went wrong!", "error");
                }
            });
        });

    });
</script>
@endsection

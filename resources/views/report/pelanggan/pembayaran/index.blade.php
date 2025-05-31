@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6"><h4>Report</h4></div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg></a></li>
                    <li class="breadcrumb-item active">Pelanggan - Laporan pembayaran</li>
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
                            <div class="col-sm-2">
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
                            <div class="col-sm-2">
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
                                    <label>Wilayah</label>
                                    <select class="form-control select" name="pilWilayah" id="pilWilayah" required="">
                                        <option selected="" disabled="" value="">Pilihan...</option>
                                        @foreach ($list_wilayah as $wil)
                                        <option value="{{ $wil->id }}">{{ $wil->wilayah }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-4">
                                <button class="btn btn-primary" type="button" id="btnFilter"><i class="fa fa-table"></i> Preview</button>
                                <button class="btn btn-danger" type="button" onclick="showPrint()"><i class="fa fa-print"></i> Print</button>
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
                            <h4>Laporan pembayaran pelanggan</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="table_view" style="width: 100%">
                                    <thead>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 15%">Periode</th>
                                        <th style="width: 20%">Wilayah</th>
                                        <th>Pelanggan</th>
                                        <th style="width: 15%">Nominal</th>
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
</form>
</div>
<script>
    $(document).ready(function () {
        $('#spinner-div').hide();
        $(".select").select2({
            placeholder: "Pilihan",
            allowClear: true
        });
        var tableAjax = $("#table_view").DataTable({
            ajax: {
                url: "{{ route('report.pelanggan.pembayaran.getdata') }}",
                type: "post",
                headers : {
                        'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                    },
                data: function (d)
                {
                    d.bulan = $("#pilBulan").val();
                    d.tahun = $('#pilTahun').val();
                    d.wilayah = $('#pilWilayah').val();
                }
            },
            processing: true,
            serverSide: true,
            autoWidth: true,
            columns: [
                { data: 'no' },
                { data: 'periode' },
                { data: 'wilayah' },
                { data: 'pelanggan' },
                { data: 'nominal' },
            ],
            responsive: true,
            columnDefs: [
                {
                    class: 'dt-right',
                    targets: [4]
                }
            ]
        });
        $("#btnFilter").on("click", function(){
            tableAjax.ajax.reload();
        });
    });

    var showPrint = function()
    {
        var pil_bulan = ($("#pilBulan").val()==null) ? 0 : $("#pilBulan").val();
        var pil_tahun = ($("#pilTahun").val()==null) ? 0 : $("#pilTahun").val();
        var pil_wilayah = ($("#pilWilayah").val()==null) ? 0 : $("#pilWilayah").val();
        if(pil_bulan==0)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: "Pilihan bulan tidak boleh kosong"
            });
            return false;
        }
        if(pil_tahun==0)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: "Pilihan tahun tidak boleh kosong"
            });
            return false;
        }

        window.open('{{ url("report/pembayaranPelangganPrint") }}/'+pil_bulan+"/"+pil_tahun+"/"+pil_wilayah);
    }

</script>
@endsection

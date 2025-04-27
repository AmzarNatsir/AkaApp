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
                    <li class="breadcrumb-item active">Pembayaran</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid search-page">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <form class="theme-form">
                        <div class="input-group m-0 flex-nowrap">
                            <select class="form-control select" name="searhPelanggan" id="searhPelanggan">
                                <option value=""></option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div id="areaDetail">
                <div id="loadingBar" class="progress" style="height: 4px; display: none;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".select").select2({
            placeholder: "Cari Pelanggan",
            allowClear: true,
            minimumInputLength: 2,
            ajax: {
                url: '{{ route("pelanggan.getPelanggan") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        }).on('change', function (e) {
            var id = $(this).val();
            if (id) {
                $('#areaDetail').html('<div style="display: flex; justify-content: center; align-items: center; height: 100px;"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
                $("#areaDetail").load("{{ url('pelanggan/detailPelanggan') }}/"+id);
            } else {
                $('#areaDetail').empty();
            }
        });
    });
</script>
@endsection

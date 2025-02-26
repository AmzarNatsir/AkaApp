@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Distribusi Material</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg></a></li>
                    <li class="breadcrumb-item active">Daftar Distribusi</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row size-column">
        <div class="col-xxl-12 box-col-12">
            <div class="row">
                <div class="col-xl-3 col-sm-6">
                    <div class="card o-hidden small-widget">
                        <div class="card-body total-Complete border-b-secondary border-2"><span class="f-light f-w-500 f-14">Gudang Utama</span>
                            <div class="project-details">
                            <div class="project-counter">
                                <h2 class="f-w-600">{{ number_format($gudang_utama, 0) }}</h2><span class="f-12 f-w-400">(Meterial) </span>
                            </div>
                            <div class="product-sub bg-secondary-light">
                                <svg class="invoice-icon">
                                <use href="../assets/svg/icon-sprite.svg#add-square"></use>
                                </svg>
                            </div>
                            </div>
                            <ul class="bubbles">
                            <li class="bubble"> </li>
                            <li class="bubble"></li>
                            <li class="bubble"></li>
                            <li class="bubble"> </li>
                            <li class="bubble"></li>
                            <li class="bubble"> </li>
                            <li class="bubble"></li>
                            <li class="bubble"></li>
                            <li class="bubble"> </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @foreach ($list_cabang as $cabang)
                <div class="col-xl-3 col-sm-6">
                    <div class="card o-hidden small-widget">
                        <div class="card-body total-project border-b-primary border-2"><span class="f-light f-w-500 f-14">{{ $cabang->nama_cabang }}</span>
                            <div class="project-details">
                                <div class="project-counter">
                                  <h2 class="f-w-600">{{ number_format($cabang->stok_akhir, 0) }}</h2><span class="f-12 f-w-400">(Material)</span>
                                </div>
                                <div class="product-sub bg-primary-light">
                                  <svg class="invoice-icon">
                                    <use href="../assets/svg/icon-sprite.svg#color-swatch"></use>
                                  </svg>
                                </div>
                            </div>
                            <ul class="bubbles">
                                <li class="bubble"></li>
                                <li class="bubble"></li>
                                <li class="bubble"></li>
                                <li class="bubble"></li>
                                <li class="bubble"></li>
                                <li class="bubble"></li>
                                <li class="bubble"></li>
                                <li class="bubble"></li>
                                <li class="bubble"></li>
                              </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Distribusi Material</h4><span>Daftar data distribusi material</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="table_view" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 10%">Tanggal</th>
                                        <th style="width: 35%">Cabang</th>
                                        <th>Keterangan</th>
                                        <th style="width: 10%">Total&nbsp;Item</th>
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
    </div>
</div>
<div class="modal fade" id="exampleModalgetbootstrap" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="form_view"></div>
    </div>
</div>
<script>

</script>
@endsection

@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Dashboard</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg></a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row size-column">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-no-border total-revenue">
                    <h4>Keuangan (Periode sampai dengan {{ date('M Y') }} )</h4>
                </div>
                <div class="card-body pt-0 row important-project">
                    <div class="row">
                        <div class="col-xl-4 col-sm-6">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-project border-b-primary border-2"><span class="f-light f-w-500 f-14">Saldo Akhir</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h2 class="f-w-600">Rp. {{ number_format($saldo_akhir, 0) }}</h2>
                                        </div>
                                        <div class="product-sub bg-primary-light">
                                            <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#color-swatch') }}"></use>
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
                        <div class="col-xl-4 col-sm-6">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-Progress border-b-warning border-2"> <span class="f-light f-w-500 f-14">Total Kas Masuk</span>
                                    <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600">Rp. {{ number_format($total_kas_masuk, 0) }}</h2>
                                    </div>
                                    <div class="product-sub bg-warning-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#add-square') }}"></use>
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
                        <div class="col-xl-4 col-sm-6">
                            <div class="card o-hidden small-widget">
                              <div class="card-body total-Complete border-b-secondary border-2"><span class="f-light f-w-500 f-14">Total Kas Keluar</span>
                                <div class="project-details">
                                  <div class="project-counter">
                                    <h2 class="f-w-600">Rp. {{ number_format($total_kas_keluar, 0) }}</h2>
                                  </div>
                                  <div class="product-sub bg-secondary-light">
                                    <svg class="invoice-icon">
                                      <use href="{{ asset('assets/svg/icon-sprite.svg#add-square') }}"></use>
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
                    </div>
                </div>
            </div>
        </div>
        {{-- summary material --}}
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-no-border total-revenue">
                    <h4>Pelanggan</h4>
                </div>
                <div class="card-body pt-0 row important-project">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-project border-b-info border-2"><span class="f-light f-w-500 f-14">On Prospect</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h2 class="f-w-600">{{ $pelanggan_prospek }}</h2>
                                        </div>
                                        <div class="product-sub bg-primary-light">
                                            <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#add-square') }}"></use>
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
                        <div class="col-xl-2 col-sm-6">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-project border-b-danger border-2"><span class="f-light f-w-500 f-14">on Process</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h2 class="f-w-600">{{ $pelanggan_proses }}</h2>
                                        </div>
                                        <div class="product-sub bg-danger-light">
                                            <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#add-square') }}"></use>
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
                        <div class="col-xl-2 col-sm-6">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-project border-b-danger border-2"><span class="f-light f-w-500 f-14">Canceled</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h2 class="f-w-600">{{ $pelanggan_batal }}</h2>
                                        </div>
                                        <div class="product-sub bg-danger-light">
                                            <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#add-square') }}"></use>
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
                        <div class="col-xl-3 col-sm-6">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-project border-b-warning border-2"><span class="f-light f-w-500 f-14">Completed</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h2 class="f-w-600">{{ $pelanggan_completed }}</h2>
                                        </div>
                                        <div class="product-sub bg-warning-light">
                                            <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#add-square') }}"></use>
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

                        <div class="col-xl-2 col-sm-6">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-project border-b-success border-2"><span class="f-light f-w-500 f-14">Aktif</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h2 class="f-w-600">{{ $pelanggan_aktif }}</h2>
                                        </div>
                                        <div class="product-sub bg-success-light">
                                            <svg class="invoice-icon">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#add-square') }}"></use>
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
                    </div>
                </div>
            </div>
        </div>
        {{-- @include('penggunaan_material'); --}}
    </div>
</div>
@endsection

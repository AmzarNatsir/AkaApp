@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Material</h4>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('material.index') }}">Daftar</a></li>
                    @can('material_create')
                    <li class="breadcrumb-item"><a href="{{ route('material.create') }}">Data Baru</a></li>
                    @endcan
                    <li class="breadcrumb-item active">Detail data material</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h4>Detail data material</h4>
                </div>
                <div class="card-body">
                    <div class="row product-page-main p-0">
                        <div class="col-xxl-4 col-md-6 box-col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="item"><img class="img-thumbnail" src="{{ url(Storage::url('material/'.$res->gambar)) }}" id="preview_upload" itemprop="thumbnail" alt="Image description"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8 box-col-6 order-xxl-0 order-1">
                            <div class="card">
                                <div class="card-body">
                                    <div class="product-page-details">
                                        <h3>{{ $res->material }}</h3>
                                    </div>
                                    {{-- <div class="product-price">Rp. {{ number_format($res->harga_beli, 0) }}</div> --}}
                                    <hr>
                                    <p>{{ $res->deskripsi }}</p>
                                    <hr>
                                    <div>
                                        <table class="product-page-width">
                                            <tbody>
                                            <tr>
                                                <td> <b>Merek &nbsp;&nbsp;&nbsp;:</b></td>
                                                <td>{{ $res->getMerek->merek }}</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Satuan &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                                <td>{{ $res->getSatuan->satuan }}</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Stok Awal &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                                <td>{{ $res->stok_awal }}</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Stok Akhir &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                                <td>{{ $res->stok_akhir }}</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Harga Beli &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                                <td>Rp. {{ number_format($res->harga_beli, 0) }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

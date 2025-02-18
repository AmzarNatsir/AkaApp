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
                        <svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg></a></li>
                    <li class="breadcrumb-item">Baru</li>
                    <li class="breadcrumb-item">Daftar Material</li>
                    <li class="breadcrumb-item active">Kartu Stok</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row product-page-main p-0">
        <div class="col-xxl-3 col-md-6 box-col-6">
            <div class="card">
                <div class="card-body">
                  <!-- side-bar colleps block stat-->
                  <div class="filter-block">
                    <h4>Pilih Material</h4>
                    <hr>
                    <select class="form-select select" id="selectItem" name="selectItem" required="">
                        <option selected="" disabled="" value="">Pilihan...</option>
                    </select>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6 box-col-12">
            <div class="card">
                <div class="card-body">
                  {{-- <div class="product-slider owl-carousel owl-theme" id="sync1"> --}}
                    <div class="item"><img src="../assets/images/ecommerce/01.jpg" alt="" style="width: 300px"></div>
                  {{-- </div>
                  <div class="owl-carousel owl-theme" id="sync2">
                    <div class="item"><img src="../assets/images/ecommerce/01.jpg" alt=""></div>
                  </div> --}}
                </div>
            </div>
        </div>
        <div class="col-xxl-5 box-col-6 order-xxl-0 order-1">
            <div class="card">
                <div class="card-body">
                    <div class="product-page-details">
                      <h3>Women Pink shirt.</h3>
                    </div>
                    <div class="product-price">$26.00
                      <del>$350.00 </del>
                    </div>
                    <ul class="product-color">
                      <li class="bg-primary"></li>
                      <li class="bg-secondary"></li>
                      <li class="bg-success"></li>
                      <li class="bg-info"></li>
                      <li class="bg-warning"></li>
                    </ul>
                    <hr>
                      <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that.</p>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Kartu Stok</h4><span>Informasi pergerakan stok</span>
                </div>
                <div class="card-body"></div>
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

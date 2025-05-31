@extends('partial.mainApp')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Manajemen Pengguna</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg></a></li>
                    <li class="breadcrumb-item active">Group Pengguna</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Add New Role
                    </div>
                    <div class="float-end">
                        <a href="{{ route('roles.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xxl-12 col-xl-12">
                                <ul class="nav main-menu">
                                    <li class="nav-item">
                                    <i class="me-2" data-feather="check-circle"></i>Modul Manajemen Data
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xl-4 col-sm-6">
                                <div class="card-wrapper border rounded-3 h-100 checkbox-checked">
                                    <h6 class="sub-title"><i class="me-2" data-feather="check-circle"></i> Dashboard </h6>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="dashboard_one_view" name="menu[]" value="dashboard_one_view" type="checkbox">
                                        <label class="form-check-label" for="dashboard_one_view">Dashboard</label>
                                    </div>
                                    <hr>
                                    <h6 class="sub-title"><i class="me-2" data-feather="check-circle"></i> Reports </h6>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="report_distribusi_voucher_view" name="menu[]" value="report_distribusi_voucher_view" type="checkbox">
                                        <label class="form-check-label" for="report_distribusi_voucher_view">Distribusi Voucher</label>
                                    </div>
                                    <div class="form-check checkbox checkbox-secondary mb-0">
                                        <input class="form-check-input" id="report_penjualan_voucher_view" name="menu[]" value="report_penjualan_voucher_view" type="checkbox">
                                        <label class="form-check-label" for="report_penjualan_voucher_view">Penjualan Voucher </label>
                                    </div>
                                    <div class="form-check checkbox checkbox-secondary mb-0">
                                        <input class="form-check-input" id="report_pembayaran_pelanggan_view" name="menu[]" value="report_pembayaran_pelanggan_view" type="checkbox">
                                        <label class="form-check-label" for="report_pembayaran_pelanggan_view">Pembayaran Pelanggan </label>
                                    </div>
                                    <div class="form-check checkbox checkbox-secondary mb-0">
                                        <input class="form-check-input" id="report_keuangan_view" name="menu[]" value="report_keuangan_view" type="checkbox">
                                        <label class="form-check-label" for="report_keuangan_view">Keuangan </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="card-wrapper border rounded-3 h-100 checkbox-checked">
                                    <h6 class="sub-title"><i class="me-2" data-feather="check-circle"></i> Pengguna </h6>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="roles_view" name="menu[]" value="roles_view" type="checkbox">
                                        <label class="form-check-label" for="roles_view">Roles</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="roles_create" name="menu[]" type="checkbox" value="roles_create">
                                                        <label class="form-check-label" for="roles_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="roles_edit" name="menu[]" type="checkbox" value="roles_edit">
                                                        <label class="form-check-label" for="roles_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="roles_delete" name="menu[]" type="checkbox" value="roles_delete">
                                                        <label class="form-check-label" for="roles_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="users_view" name="menu[]" value="users_view" type="checkbox">
                                        <label class="form-check-label" for="users_view">Users </label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="users_create" name="menu[]" type="checkbox" value="users_create">
                                                        <label class="form-check-label" for="users_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="master_satuan_edit" name="menu[]" type="checkbox" value="master_satuan_edit">
                                                        <label class="form-check-label" for="master_satuan_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="master_satuan_delete" name="menu[]" type="checkbox" value="master_satuan_delete">
                                                        <label class="form-check-label" for="master_satuan_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="card-wrapper border rounded-3 h-100 checkbox-checked">
                                    <h6 class="sub-title"><i class="me-2" data-feather="check-circle"></i> Data Master </h6>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="master_merek_view" name="menu[]" value="master_merek_view" type="checkbox">
                                        <label class="form-check-label" for="master_merek_view">Merek</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="master_merek_create" name="menu[]" type="checkbox" value="master_merek_create">
                                                        <label class="form-check-label" for="master_merek_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="master_merek_edit" name="menu[]" type="checkbox" value="master_merek_edit">
                                                        <label class="form-check-label" for="master_merek_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="master_merek_delete" name="menu[]" type="checkbox" value="master_merek_delete">
                                                        <label class="form-check-label" for="master_merek_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="master_satuan_view" name="menu[]" value="master_satuan_view" type="checkbox">
                                        <label class="form-check-label" for="master_satuan_view">Satuan </label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="master_satuan_create" name="menu[]" type="checkbox" value="master_satuan_create">
                                                        <label class="form-check-label" for="master_satuan_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="users_edit" name="menu[]" type="checkbox" value="users_edit">
                                                        <label class="form-check-label" for="users_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="users_delete" name="menu[]" type="checkbox" value="users_delete">
                                                        <label class="form-check-label" for="users_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Menu Material -->
                            <div class="col-xl-4 col-sm-6">
                                <div class="card-wrapper border rounded-3 h-100 checkbox-checked">
                                    <h6 class="sub-title"><i class="me-2" data-feather="check-circle"></i> Material </h6>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="material_view" name="menu[]" value="material_view" type="checkbox">
                                        <label class="form-check-label" for="material_view">Material</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="material_create" name="menu[]" type="checkbox" value="material_create">
                                                        <label class="form-check-label" for="material_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="material_edit" name="menu[]" type="checkbox" value="material_edit">
                                                        <label class="form-check-label" for="material_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="material_delete" name="menu[]" type="checkbox" value="material_delete">
                                                        <label class="form-check-label" for="material_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="material_kartu_stok_view" name="menu[]" value="material_kartu_stok_view" type="checkbox">
                                        <label class="form-check-label" for="material_kartu_stok_view">Karu Stok </label>
                                    </div>
                                    <hr>
                                    <h6 class="sub-title"><i class="me-2" data-feather="check-circle"></i> Cabang </h6>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="cabang_view" name="menu[]" value="cabang_view" type="checkbox">
                                        <label class="form-check-label" for="cabang_view">Cabang</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="cabang_create" name="menu[]" type="checkbox" value="cabang_create">
                                                        <label class="form-check-label" for="cabang_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="cabang_edit" name="menu[]" type="checkbox" value="cabang_edit">
                                                        <label class="form-check-label" for="cabang_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="cabang_delete" name="menu[]" type="checkbox" value="cabang_delete">
                                                        <label class="form-check-label" for="cabang_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Menu Cabang - wilayah -->
                            <div class="col-xl-4 col-sm-6">
                                <div class="card-wrapper border rounded-3 h-100 checkbox-checked">
                                    <h6 class="sub-title"><i class="me-2" data-feather="check-circle"></i> Wilayah </h6>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="wilayah_view" name="menu[]" value="wilayah_view" type="checkbox">
                                        <label class="form-check-label" for="wilayah_view">Wilayah</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="wilayah_create" name="menu[]" type="checkbox" value="wilayah_create">
                                                        <label class="form-check-label" for="wilayah_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="wilayah_edit" name="menu[]" type="checkbox" value="wilayah_edit">
                                                        <label class="form-check-label" for="wilayah_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="wilayah_delete" name="menu[]" type="checkbox" value="wilayah_delete">
                                                        <label class="form-check-label" for="wilayah_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <hr>
                                    <h6 class="sub-title"><i class="me-2" data-feather="check-circle"></i> Petugas </h6>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="petugas_view" name="menu[]" value="petugas_view" type="checkbox">
                                        <label class="form-check-label" for="petugas_view">Petugas</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="petugas_create" name="menu[]" type="checkbox" value="petugas_create">
                                                        <label class="form-check-label" for="petugas_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="petugas_edit" name="menu[]" type="checkbox" value="petugas_edit">
                                                        <label class="form-check-label" for="petugas_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="petugas_delete" name="menu[]" type="checkbox" value="petugas_delete">
                                                        <label class="form-check-label" for="petugas_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Menu petugas -->
                            <div class="col-xl-4 col-sm-6">
                                <div class="card-wrapper border rounded-3 h-100 checkbox-checked">
                                    {{-- menu paket internet --}}
                                    <h6 class="sub-title"><i class="me-2" data-feather="check-circle"></i> Paket Internet </h6>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="paket_internet_view" name="menu[]" value="paket_internet_view" type="checkbox">
                                        <label class="form-check-label" for="paket_internet_view">Paket Internet</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="paket_internet_create" name="menu[]" type="checkbox" value="paket_internet_create">
                                                        <label class="form-check-label" for="paket_internet_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="paket_internet_edit" name="menu[]" type="checkbox" value="paket_internet_edit">
                                                        <label class="form-check-label" for="paket_internet_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="paket_internet_delete" name="menu[]" type="checkbox" value="paket_internet_delete">
                                                        <label class="form-check-label" for="paket_internet_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    {{-- end menu paket internet --}}
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xxl-12 col-xl-12">
                                <ul class="nav main-menu">
                                    <li class="nav-item ">
                                        <i class="me-2" data-feather="check-circle"></i>Modul Transaksi
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <!-- transaksi material -->
                        <div class="row">
                            <div class="col-xl-6 col-sm-6">
                                <div class="card-wrapper border rounded-3 h-100 checkbox-checked">
                                    <h6 class="sub-title"><i class="me-2" data-feather="check-circle"></i> Material </h6>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="trans_pembelian_view" name="menu[]" type="checkbox" value="trans_pembelian_view">
                                        <label class="form-check-label" for="trans_pembelian_view">Pembelian</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_pembelian_create" name="menu[]" type="checkbox" value="trans_pembelian_create">
                                                        <label class="form-check-label" for="trans_pembelian_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_pembelian_edit" name="menu[]" type="checkbox" value="trans_pembelian_edit">
                                                        <label class="form-check-label" for="trans_pembelian_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_pembelian_delete" name="menu[]" type="checkbox" value="trans_pembelian_delete">
                                                        <label class="form-check-label" for="trans_pembelian_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="trans_distribusi_view" name="menu[]" type="checkbox" value="trans_distribusi_view">
                                        <label class="form-check-label" for="trans_distribusi_view">Distribusi</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_distribusi_create" name="menu[]" type="checkbox" value="trans_distribusi_create">
                                                        <label class="form-check-label" for="trans_distribusi_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_distribusi_edit" name="menu[]" type="checkbox" value="trans_distribusi_edit">
                                                        <label class="form-check-label" for="trans_distribusi_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_distribusi_delete" name="menu[]" type="checkbox" value="trans_distribusi_delete">
                                                        <label class="form-check-label" for="trans_distribusi_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="trans_pemakaian_view" name="menu[]" type="checkbox" value="trans_pemakaian_view">
                                        <label class="form-check-label" for="trans_pemakaian_view">Pemakaian</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_pemakaian_create" name="menu[]" type="checkbox" value="trans_pemakaian_create">
                                                        <label class="form-check-label" for="trans_pemakaian_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_pemakaian_edit" name="menu[]" type="checkbox" value="trans_pemakaian_edit">
                                                        <label class="form-check-label" for="trans_pemakaian_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_pemakaian_delete" name="menu[]" type="checkbox" value="trans_pemakaian_delete">
                                                        <label class="form-check-label" for="trans_pemakaian_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="trans_pengembalian_view" name="menu[]" type="checkbox" value="trans_pengembalian_view">
                                        <label class="form-check-label" for="trans_pengembalian_view">Pengembalian</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_pengembalian_create" name="menu[]" type="checkbox" value="trans_pengembalian_create">
                                                        <label class="form-check-label" for="trans_pengembalian_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_pengembalian_edit" name="menu[]" type="checkbox" value="trans_pengembalian_edit">
                                                        <label class="form-check-label" for="trans_pengembalian_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_pengembalian_delete" name="menu[]" type="checkbox" value="trans_pengembalian_delete">
                                                        <label class="form-check-label" for="trans_pengembalian_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-6">
                                <div class="card-wrapper border rounded-3 h-100 checkbox-checked">
                                    <h6 class="sub-title"><i class="me-2" data-feather="check-circle"></i> Voucher </h6>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="trans_voucher_view" name="menu[]" type="checkbox" value="trans_voucher_view">
                                        <label class="form-check-label" for="trans_voucher_view">Voucher</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_voucher_create" name="menu[]" type="checkbox" value="trans_voucher_create">
                                                        <label class="form-check-label" for="trans_voucher_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_voucher_edit" name="menu[]" type="checkbox" value="trans_voucher_edit">
                                                        <label class="form-check-label" for="trans_voucher_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_voucher_delete" name="menu[]" type="checkbox" value="trans_voucher_delete">
                                                        <label class="form-check-label" for="trans_voucher_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="trans_agen_view" name="menu[]" type="checkbox" value="trans_agen_view">
                                        <label class="form-check-label" for="trans_agen_view">Agen</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_agen_create" name="menu[]" type="checkbox" value="trans_agen_create">
                                                        <label class="form-check-label" for="trans_agen_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_agen_edit" name="menu[]" type="checkbox" value="trans_agen_edit">
                                                        <label class="form-check-label" for="trans_agen_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_agen_delete" name="menu[]" type="checkbox" value="trans_agen_delete">
                                                        <label class="form-check-label" for="trans_agen_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="trans_distribusi_voucher_view" name="menu[]" type="checkbox" value="trans_distribusi_voucher_view">
                                        <label class="form-check-label" for="trans_distribusi_voucher_view">Distribusi</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_distribusi_voucher_create" name="menu[]" type="checkbox" value="trans_distribusi_voucher_create">
                                                        <label class="form-check-label" for="trans_distribusi_voucher_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_distribusi_voucher_edit" name="menu[]" type="checkbox" value="trans_distribusi_voucher_edit">
                                                        <label class="form-check-label" for="trans_distribusi_voucher_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_distribusi_voucher_delete" name="menu[]" type="checkbox" value="trans_distribusi_voucher_delete">
                                                        <label class="form-check-label" for="trans_distribusi_voucher_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="trans_penjualan_voucher_view" name="menu[]" type="checkbox" value="trans_penjualan_voucher_view">
                                        <label class="form-check-label" for="trans_penjualan_voucher_view">Penjualan</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_penjualan_voucher_create" name="menu[]" type="checkbox" value="trans_penjualan_voucher_create">
                                                        <label class="form-check-label" for="trans_penjualan_voucher_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_penjualan_voucher_edit" name="menu[]" type="checkbox" value="trans_penjualan_voucher_edit">
                                                        <label class="form-check-label" for="trans_penjualan_voucher_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_penjualan_voucher_delete" name="menu[]" type="checkbox" value="trans_penjualan_voucher_delete">
                                                        <label class="form-check-label" for="trans_penjualan_voucher_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- transaksi voucher -->
                        <hr>
                        <div class="row">
                            <div class="col-xl-6 col-sm-6">
                                <div class="card-wrapper border rounded-3 h-100 checkbox-checked">
                                    <h6 class="sub-title"><i class="me-2" data-feather="check-circle"></i> Keuangan </h6>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="trans_keuangan_kas_masuk_view" name="menu[]" type="checkbox" value="trans_keuangan_kas_masuk_view">
                                        <label class="form-check-label" for="trans_keuangan_kas_masuk_view">Kas Masuk</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_keuangan_kas_masuk_create" name="menu[]" type="checkbox" value="trans_keuangan_kas_masuk_create">
                                                        <label class="form-check-label" for="trans_keuangan_kas_masuk_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_keuangan_kas_masuk_edit" name="menu[]" type="checkbox" value="trans_keuangan_kas_masuk_edit">
                                                        <label class="form-check-label" for="trans_keuangan_kas_masuk_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_keuangan_kas_masuk_delete" name="menu[]" type="checkbox" value="trans_keuangan_kas_masuk_delete">
                                                        <label class="form-check-label" for="trans_keuangan_kas_masuk_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="trans_keuangan_kas_keluar_view" name="menu[]" type="checkbox" value="trans_keuangan_kas_keluar_view">
                                        <label class="form-check-label" for="trans_keuangan_kas_keluar_view">Kas Keluar</label>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_keuangan_kas_keluar_create" name="menu[]" type="checkbox" value="trans_keuangan_kas_keluar_create">
                                                        <label class="form-check-label" for="trans_keuangan_kas_keluar_create">Create</label>
                                                    </div>
                                                </td>
                                                <td style="width: 30%">
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_keuangan_kas_keluar_edit" name="menu[]" type="checkbox" value="trans_keuangan_kas_keluar_edit">
                                                        <label class="form-check-label" for="trans_keuangan_kas_keluar_edit">Edit</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check checkbox checkbox-secondary">
                                                        <input class="form-check-input" id="trans_keuangan_kas_keluar_delete" name="menu[]" type="checkbox" value="trans_keuangan_kas_keluar_delete">
                                                        <label class="form-check-label" for="trans_keuangan_kas_keluar_delete">Delete</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-6">
                                <div class="card-wrapper border rounded-3 h-100 checkbox-checked">
                                    <h6 class="sub-title"><i class="me-2" data-feather="check-circle"></i> Pelanggan </h6>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="pelanggan_registrasi_view" name="menu[]" type="checkbox" value="pelanggan_registrasi_view">
                                        <label class="form-check-label" for="pelanggan_registrasi_view">Registrasi</label>
                                    </div>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="pelanggan_monitoring_view" name="menu[]" type="checkbox" value="pelanggan_monitoring_view">
                                        <label class="form-check-label" for="pelanggan_monitoring_view">Monitoring</label>
                                    </div>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="pelanggan_view" name="menu[]" value="pelanggan_view" type="checkbox">
                                        <label class="form-check-label" for="pelanggan_view">Daftar Pelanggan</label>
                                    </div>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="pelanggan_pembayaran_view" name="menu[]" type="checkbox" value="pelanggan_pembayaran_view">
                                        <label class="form-check-label" for="pelanggan_pembayaran_view">Pembayaran</label>
                                    </div>
                                    <hr>
                                    <h6 class="sub-title"><i class="me-2" data-feather="check-circle"></i> Others </h6>
                                    <div class="form-check checkbox checkbox-primary">
                                        <input class="form-check-input" id="others_petugas_view" name="menu[]" type="checkbox" value="others_petugas_view">
                                        <label class="form-check-label" for="others_petugas_view">Akses Petugas</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Role">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

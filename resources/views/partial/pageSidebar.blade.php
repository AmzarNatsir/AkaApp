@php
$canDashboard = auth()->user()->can('dashboard_one_view');
//Report
$canReportDistribusiVoucher = auth()->user()->can('report_distribusi_voucher_view');
$canReportPenjualanVoucher = auth()->user()->can('report_penjualan_voucher_view');
$canReportKeuangan = auth()->user()->can('report_keuangan_view');
//Pengguna
$canPenggunaRole = auth()->user()->can('roles_view');
$canPenggunaUsers = auth()->user()->can('users_view');
//data master
$canMasterMerek = auth()->user()->can('master_merek_view');
$canMasterSatuan = auth()->user()->can('master_satuan_view');
//master material
$canMasterMaterialCreate = auth()->user()->can('material_create');
$canMasterMaterial = auth()->user()->can('material_view');
$canMaterialKartuStok = auth()->user()->can('material_kartu_stok_view');
//Master cabang
$canMasterCabang = auth()->user()->can('cabang_view');
$canMasterWilayah = auth()->user()->can('wilayah_view');
$canMasterPetugas = auth()->user()->can('petugas_view');
$canMasterPaketInternet = auth()->user()->can('paket_internet_view');
$canMasterPalanggan = auth()->user()->can('pelanggan_view');
//transaksi
//material
$canTransMaterialPembelian = auth()->user()->can('trans_pembelian_view');
$canTransMaterialPembelianCreate = auth()->user()->can('trans_pembelian_create');
$canTransMaterialDistribusi = auth()->user()->can('trans_distribusi_view');
$canTransMaterialPemakaian = auth()->user()->can('trans_pemakaian_view');
$canTransMaterialPemakaianCreate = auth()->user()->can('trans_pemakaian_create');
$canTransMaterialPengembalian = auth()->user()->can('trans_pengembalian_view');
$canTransMaterialPengembalianCreate = auth()->user()->can('trans_pengembalian_create');
//voucher
$canTransVoucher = auth()->user()->can('trans_voucher_view');
$canTransAgenVoucher = auth()->user()->can('trans_agen_view');
$canTransDistribusiVoucher = auth()->user()->can('trans_distribusi_voucher_view');
$canTransDistribusiVoucherCreate = auth()->user()->can('trans_distribusi_voucher_create');
$canTransPenjualanVoucher = auth()->user()->can('trans_penjualan_voucher_view');
$canTransPenjualanVoucherCreate = auth()->user()->can('trans_penjualan_voucher_create');
//keuangan
$canTransKasMasuk = auth()->user()->can('trans_keuangan_kas_masuk_view');
$canTransKasKeluar = auth()->user()->can('trans_keuangan_kas_keluar_view');
//pelanggan
$canRegistrasiPelangan = auth()->user()->can('pelanggan_registrasi_view');
$canMonitoringPelangan = auth()->user()->can('pelanggan_monitoring_view');
$canPembayaranPelangan = auth()->user()->can('pelanggan_pembayaran_view');
$canDaftarPelangan = auth()->user()->can('pelanggan_view');
@endphp
<div class="logo-wrapper"><a href="{{ route('home') }}"><img class="img-fluid" src="{{ asset('assets/images/logo/akagroup.png') }}" style="width: 85%" alt=""></a>
    <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
    <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
</div>
<div class="logo-icon-wrapper"><a href="{{ route('home') }}"><img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a></div>
<nav class="sidebar-main">
    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
    <div id="sidebar-menu">
        <ul class="sidebar-links" id="simple-bar">
            <li class="back-btn"><a href="{{ route('home') }}"><img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a>
                <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
            </li>
            <li class="pin-title sidebar-main-title">
                <div>
                <h6>Pinned</h6>
                </div>
            </li>
            {{-- <li class="sidebar-main-title">
                <div><h6 class="lan-1">General</h6>g</div>
            </li> --}}
            @if($canDashboard)
            <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                </svg><span>Dashboard</span></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('dashboard.all') }}">Dashboard</a></li>
                </ul>
            </li>
            @endif
            @if($canReportDistribusiVoucher || $canReportPenjualanVoucher || $canReportKeuangan)
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-widget') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-widget') }}"></use></svg><span>Reports</span></a>
                <ul class="sidebar-submenu">
                    @if($canReportDistribusiVoucher)
                    <li><a href="{{ route('report.distribusiVoucher') }}">Distribusi Voucher</a></li>
                    @endif
                    @if($canReportPenjualanVoucher)
                    <li><a href="{{ route('report.penjualanVoucher') }}">Penjualan Voucher</a></li>
                    @endif
                    @if($canReportKeuangan)
                    <li><a href="{{ route('report.keuangan') }}">Keuangan</a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if($canPenggunaRole || $canPenggunaUsers || $canMasterMerek || $canMasterSatuan || $canMasterMaterial || $canMasterMaterialCreate || $canMaterialKartuStok || $canMasterCabang || $canMasterWilayah || $canMasterPetugas)
            <li class="sidebar-main-title"><div><h6>Manajemen Data</h6></div></li>
            @endif
            @if($canPenggunaRole || $canPenggunaUsers)
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use></svg><span>Pengguna</span></a>
                <ul class="sidebar-submenu">
                    @if($canPenggunaRole)
                    <li><a href="{{ route('roles.index') }}">Roles</a></li>
                    @endif
                    @if($canPenggunaUsers)
                    <li><a href="{{ route('users.index') }}">Users</a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if($canMasterMerek || $canMasterSatuan)
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use></svg><span>Data Master</span></a>
                <ul class="sidebar-submenu">
                    @if($canMasterMerek)
                    <li><a href="{{ route('datamaster.merek') }}">Merek</a></li>
                    @endif
                    @if($canMasterSatuan)
                    <li><a href="{{ route('datamaster.satuan') }}">Satuan</a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if($canMasterMaterial || $canMasterMaterialCreate || $canMaterialKartuStok)
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-form') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-form') }}"> </use>
                </svg><span>Material</span></a>
                <ul class="sidebar-submenu">
                    @if($canMasterMaterialCreate)
                    <li><a href="{{ route('material.create') }}">Baru</a></li>
                    @endif
                    @if($canMasterMaterial)
                    <li><a href="{{ route('material.index') }}">Daftar</a></li>
                    @endif
                    @if($canMaterialKartuStok)
                    <li><a href="{{ route('material.kontrol') }}">Kartu Stok</a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if($canMasterCabang)
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{ route('cabang.list') }}">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"> </use></svg><span>Cabang</span></a>
            </li>
            @endif
            @if($canMasterWilayah)
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{ route('wilayah.list') }}">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"> </use></svg><span>Wilayah</span></a>
            </li>
            @endif
            @if($canMasterPetugas)
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{ route('petugas.list') }}">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"> </use></svg><span>Petugas</span></a>
            </li>
            @endif
            @if($canMasterPaketInternet)
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{ route('paket_internet.index') }}">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-form') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-form') }}"> </use></svg><span>Paket Internet</span></a>
            </li>
            @endif
            @if($canTransMaterialPembelian || $canTransMaterialPembelianCreate || $canTransMaterialDistribusi || $canTransMaterialPemakaian || $canTransMaterialPemakaianCreate || $canTransMaterialPengembalian || $canTransVoucher || $canTransAgenVoucher || $canTransDistribusiVoucher || $canTransDistribusiVoucherCreate || $canTransPenjualanVoucher || $canTransPenjualanVoucherCreate || $canTransKasMasuk || $canTransKasKeluar)
            <li class="sidebar-main-title">
                <div><h6>Transaksi</h6></div>
            </li>
            @endif
            @if($canTransMaterialPembelian || $canTransMaterialPembelianCreate || $canTransMaterialDistribusi || $canTransMaterialPemakaian || $canTransMaterialPemakaianCreate || $canTransMaterialPengembalian)
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ui-kits') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-form') }}"> </use></svg><span>Material</span></a>
                <ul class="sidebar-submenu">
                    @if($canTransMaterialPembelian)
                    <li>
                        <a class="submenu-title" href="#">Pembelian <span class="sub-arrow"> <i class="fa fa-angle-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                            @if($canTransMaterialPembelianCreate)
                            <li><a href="{{ route('pembelian.create') }}">Baru</a></li>
                            @endif
                            <li><a href="{{ route('pembelian.list') }}">Daftar</a></li>
                        </ul>
                    </li>
                    @endif
                    @if($canTransMaterialDistribusi)
                    <li>
                        <a class="submenu-title" href="#">Distribusi<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                            <li><a href="{{ route('distribusiMaterial.list') }}">Daftar</a></li>
                        </ul>
                    </li>
                    @endif
                    @if($canTransMaterialPemakaian)
                    <li>
                        <a class="submenu-title" href="#">Pemakaian<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                            @if($canTransMaterialPemakaianCreate)
                            <li><a href="{{ route('pemakaianMaterial.index') }}">Baru</a></li>
                            @endif
                            <li><a href="{{ route('pemakaianMaterial.list') }}">Daftar</a></li>
                        </ul>
                    </li>
                    @endif
                    @if($canTransMaterialPengembalian)
                    <li>
                        <a class="submenu-title" href="#">Pengembalian<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                            @if($canTransMaterialPengembalianCreate)
                            <li><a href="{{ route('pengembalian.material.index') }}">Baru</a></li>
                            @endif
                            <li><a href="{{ route('pengembalian.material.list') }}">Daftar</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if($canRegistrasiPelangan || $canMonitoringPelangan || $canDaftarPelangan)
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use></svg><span>Pelanggan</span></a>
                <ul class="sidebar-submenu">
                    @if($canRegistrasiPelangan)
                    <li><a href="{{ route('pelanggan.index') }}">Prospek</a></li>
                    @endif
                    @if($canMonitoringPelangan)
                    <li><a href="{{ route('pelanggan.monitoring') }}">Monitoring</a></li>
                    @endif
                    @if($canDaftarPelangan)
                    <li><a href="{{ route('pelanggan.daftar') }}">Pelanggan</a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if($canTransVoucher || $canTransAgenVoucher || $canTransDistribusiVoucher || $canTransDistribusiVoucherCreate || $canTransPenjualanVoucher || $canTransPenjualanVoucherCreate)
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-bonus-kit') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-bonus-kit') }}"></use></svg><span>Voucher</span></a>
                <ul class="sidebar-submenu">
                    @if($canTransVoucher)
                    <li><a href="{{ route('voucher.list') }}">Voucher</a></li>
                    @endif
                    @if($canTransAgenVoucher)
                    <li><a href="{{ route('agen.list') }}">Agent</a></li>
                    @endif
                    @if($canTransDistribusiVoucher)
                    <li>
                        <a class="submenu-title" href="#">Distribusi<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                            @if($canTransDistribusiVoucherCreate)
                            <li><a href="{{ route('voucher.distribusi') }}">Baru</a></li>
                            @endif
                            <li><a href="{{ route('voucher.distribusi.list') }}">Daftar</a></li>
                        </ul>
                    </li>
                    @endif
                    @if($canTransPenjualanVoucher)
                    <li>
                        <a class="submenu-title" href="#">Penjualan<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                            @if($canTransPenjualanVoucherCreate)
                            <li><a href="{{ route('voucher.penjualan') }}">Baru</a></li>
                            @endif
                            <li><a href="{{ route('voucher.penjualan.list') }}">Daftar</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if($canTransKasMasuk || $canTransKasKeluar || $canPembayaranPelangan)
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-bonus-kit') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-bonus-kit') }}"></use></svg><span>Keuangan</span></a>
                <ul class="sidebar-submenu">
                    @if($canTransKasMasuk)
                    <li><a href="{{ route('keuangan.kasMasuk.daftar') }}">Kas Masuk</a></li>
                    @endif
                    @if($canTransKasKeluar)
                    <li><a href="{{ route('keuangan.kasKeluar.daftar') }}">Kas Keluar</a></li>
                    @endif
                    @if($canPembayaranPelangan)
                    <li><a href="{{ route('pelanggan.pembayaran') }}">Pembayaran Pelanggan</a></li>
                    @endif
                </ul>
            </li>
            @endif

            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-bonus-kit') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-bonus-kit') }}"></use></svg><span>Asset</span></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('asset.list') }}">Daftar</a></li>
                </ul>
            </li>

            <li class="sidebar-main-title"></li>
        </ul>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </div>
</nav>

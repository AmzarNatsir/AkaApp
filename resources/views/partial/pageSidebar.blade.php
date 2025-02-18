<div class="logo-wrapper"><a href="{{ route('home') }}"><img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt=""></a>
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
            <li class="sidebar-main-title">
                <div><h6 class="lan-1">General</h6>g</div>
            </li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                </svg><span>Dashboard</span></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('home') }}">Coming Soon</a></li>
                </ul>
            </li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-widget') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-widget') }}"></use></svg><span>Reports</span></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('home') }}">Coming Soon</a></li>
                </ul>
            </li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-layout') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-layout') }}"></use></svg><span>Summary</span></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('home') }}">Coming Soon</a></li>
                </ul>
            </li>

            <li class="sidebar-main-title"><div><h6>Manajemen Data</h6></div></li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use></svg><span>Authentication</span></a>
                <ul class="sidebar-submenu">
                <li><a href="{{ route('roles.index') }}">Roles</a></li>
                <li><a href="{{ route('users.index') }}">Users</a></li>
                </ul>
            </li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use></svg><span>Data Master</span></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('datamaster.merek') }}">Merek</a></li>
                    <li><a href="{{ route('datamaster.satuan') }}">Satuan</a></li>
                </ul>
            </li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-form') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-form') }}"> </use>
                </svg><span>Material</span></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('material.create') }}">Baru</a></li>
                    <li><a href="{{ route('material.index') }}">Daftar</a></li>
                    <li><a href="{{ route('material.kontrol') }}">Kartu Stok</a></li>
                </ul>
            </li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{ route('cabang.list') }}">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"> </use></svg><span>Cabang</span></a>
            </li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{ route('wilayah.list') }}">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"> </use></svg><span>Wilayah</span></a>
            </li>
            <li class="sidebar-main-title">
                <div><h6>Transaction</h6></div>
            </li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ui-kits') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-form') }}"> </use></svg><span>Material</span></a>
                <ul class="sidebar-submenu">
                    <li>
                        <a class="submenu-title" href="#">Pembelian <span class="sub-arrow"> <i class="fa fa-angle-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                            <li><a href="{{ route('pembelian.create') }}">Baru</a></li>
                            <li><a href="{{ route('pembelian.list') }}">Daftar</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="submenu-title" href="#">Distribusi<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                            <li><a href="avatars.html">Baru</a></li>
                            <li><a href="avatars.html">Daftar</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="submenu-title" href="#">Pemakaian<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                            <li><a href="avatars.html">Baru</a></li>
                            <li><a href="avatars.html">Daftar</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="sidebar-main-title">
                <div><h6>AKANET</h6></div>
            </li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-bonus-kit') }}"></use></svg>
                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-bonus-kit') }}"></use></svg><span>Voucher</span></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('voucher.list') }}">Voucher</a></li>
                    <li><a href="{{ route('agen.list') }}">Agent</a></li>
                    <li><a href="scrollable.html">Distribusi</a></li>
                    <li><a href="scrollable.html">Penjualan</a></li>
                </ul>
            </li>
        </ul>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </div>
</nav>

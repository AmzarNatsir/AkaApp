<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>@include('partial.head')</head>
<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader"><div class="loader4"></div></div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper default-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-header">
            @include('partial.pageHeader')
        </div>
        <div class="page-body-wrapper">
            <div class="sidebar-wrapper" data-layout="stroke-svg">
                @include('partial.pageSidebar')
            </div>
            <div class="page-body mb-5">
                @yield('content')
            </div>
            @include('partial.footer')
        </div>
    </div>
    @include('partial.js')
</body>
</html>

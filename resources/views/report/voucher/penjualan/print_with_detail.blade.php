<!DOCTYPE html>
<html>
<head>
	<title>AKAGroup - Application</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        @page {
            margin: 10px;
        }
        body {
            margin : 70px 50px 30px 50px;
            font-size: 12px;
            font-family: 'Poppins', sans-serif;
        }
        a {
            color: #fff;
            text-decoration: none;
        }
        table {
            font-size: 11px;
            font-family: 'Poppins', sans-serif;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
        .page-break {
            page-break-after: always;
        }
        .information {
            background-color: #ffffff;
            color: #020202;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 0px;
        }
        header { position: fixed; top: -10px; left: 20px; right: 20px; height: 30px; }
        /*
        footer { position: fixed; bottom: -60px; left: 0px; right: 0px; background-color: #03a9f4; height: 25px; }
        */
        .page-break:last-child { page-break-after: never; }
        </style>
</head>
<header>
    <div class="information">
        <table width="100%">
            <tr>
                <td align="left" style="width: 50%;">
                <img src="{{ public_path('assets/images/logo/akagroup_baru.jpg') }}" alt="Logo" width="200px" height="auto" class="logo"/>
                </td>
                <td align="right" style="width: 50%;"></td>
            </tr>
            <tr><td colspan="2"><hr style="border: 1px solid black; border-collapse: collapse;"></td></tr>
        </table>
    </div>
</header>
<body>
<main>
    <table style="width: 100%">
        <tr>
            <td style="text-align: center"><h2>Laporan Penjualan Voucher</h2></td>
        </tr>
        <tr>
            <td style="text-align: left">Dicetak pada : {{ date('d-m-Y') }} (Dicetak oleh: {{ auth()->user()->name }})</td>
        </tr>
    </table>

    <table style="border-collapse: collapse; width: 100%;" cellpadding="3" border="1">
        <thead>
            <tr>
                <th rowspan="2" style="width: 10%">Periode</th>
                <th rowspan="2">Agen</th>
                <th rowspan="2" style="width: 15%">Voucher</th>
                <th rowspan="2" style="width: 8%">Harga&nbsp;Modal</th>
                <th rowspan="2" style="width: 8%">Harga&nbsp;Jual</th>
                <th colspan="3" class="text-center">Stok Distribusi</th>
                <th colspan="3" class="text-center">Stok Realisasi</th>
            </tr>
            <tr>
                <th style="width: 6%;" class="text-center">Awal</th>
                <th style="width: 6%;" class="text-center">Tambahan</th>
                <th style="width: 6%;" class="text-center">Total</th>
                <th style="width: 6%;" class="text-center">Sisa</th>
                <th style="width: 6%;" class="text-center">Terjual</th>
                <th style="width: 8%; text-align:right">Sub&nbsp;Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grand_total_sisa = 0;
                $grand_total_terjual = 0;
                $grand_sub_total = 0;
            @endphp
            @foreach ($list_penjualan as $r)
                @php
                    $sub_total_sisa = 0;
                    $sub_total_terjual = 0;
                    $sub_total_total = 0;
                    $rowspan = max(1, $r['detail']->count());
                @endphp
            <tr>
                <td><b>{{ $getGeneral::get_nama_bulan($r['bulan']) }} {{ $r['tahun'] }}</b></td>
                <td><b>{{ $r['get_agen']['nama_agen'] }}</b></td>
                @if($r['detail']->count()==0)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"><b></b></td>
                    <td style="text-align:right;"><b></b></td>
                @else
                    @php($sub_total_sisa=0)
                    @php($sub_total_terjual=0)
                    @php($sub_total_total=0)
                    @php($nom=1)
                    @foreach ($r['detail'] as $d)
                        @php($total = $d['stok_awal'] + $d['stok_tambahan'])
                        @php($sisa = $total - $d['stok_terjual'])
                        @php($sub_total = $d['harga_modal'] * $d['stok_terjual'])
                        @if($nom==1)
                            <td><b>{{ $d['nama_voucher'] }}</b></td>
                            <td style="text-align:right;">{{ number_format($d['harga_modal'], 0) }}</td>
                            <td style="text-align:right;">{{ number_format($d['harga_jual'], 0) }}</td>
                            <td style="text-align:center">{{ number_format($d['stok_awal'], 0) }}</td>
                            <td style="text-align:center">{{ number_format($d['stok_tambahan'], 0) }}</td>
                            <td style="text-align:center"><b>{{ number_format($total, 0) }}</b></td>
                            <td style="text-align:center">{{ number_format($sisa, 0) }}</td>
                            <td style="text-align:center">{{ number_format($d['stok_terjual'], 0) }}</td>
                            <td style="text-align:right;">{{ number_format($sub_total, 0) }}</td>
                        @endif
                        <tr>
                            <td></td>
                            <td></td>
                            <td><b>{{ $d['nama_voucher'] }}</b></td>
                            <td style="text-align:right;">{{ number_format($d['harga_modal'], 0) }}</td>
                            <td style="text-align:right;">{{ number_format($d['harga_jual'], 0) }}</td>
                            <td style="text-align:center">{{ number_format($d['stok_awal'], 0) }}</td>
                            <td style="text-align:center">{{ number_format($d['stok_tambahan'], 0) }}</td>
                            <td style="text-align:center"><b>{{ number_format($total, 0) }}</b></td>
                            <td style="text-align:center">{{ number_format($sisa, 0) }}</td>
                            <td style="text-align:center">{{ number_format($d['stok_terjual'], 0) }}</td>
                            <td style="text-align:right;">{{ number_format($sub_total, 0) }}</td>
                        </tr>
                        @php($sub_total_sisa+=$sisa)
                        @php($sub_total_terjual+=$d['stok_terjual'])
                        @php($sub_total_total+=$sub_total)
                        @php($nom++)
                    @endforeach
                    <tr style="background-color: #d2cfcf">
                        <td colspan="8" style="text-align:right"><b>SUB TOTAL</b></td>
                        <td style="text-align:center;"><b>{{ number_format($sub_total_sisa, 0) }}</b></td>
                        <td style="text-align:center;"><b>{{ number_format($sub_total_terjual, 0) }}</b></td>
                        <td style="text-align:right;"><b>{{ number_format($sub_total_total, 0) }}</b></td>
                    </tr>
                @endif
            </tr>
            @php($grand_total_sisa+=$sub_total_sisa)
            @php($grand_total_terjual+=$sub_total_terjual)
            @php($grand_sub_total+=$sub_total_total)
            @endforeach
            <tr style="background-color: #b7b5b5">
                <td colspan="8" style="text-align:right"><b>GRAND TOTAL</b></td>
                <td style="text-align:center;font-size:10pt"><b>{{ number_format($grand_total_sisa, 0) }}</b></td>
                <td style="text-align:center;font-size:10pt"><b>{{ number_format($grand_total_terjual, 0) }}</b></td>
                <td style="text-align:right;font-size:10pt"><b>{{ number_format($grand_sub_total, 0) }}</b></td>
            </tr>
        </tbody>
    </table>
</main>
</body>
</html>

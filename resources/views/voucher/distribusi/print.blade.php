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
            margin : 100px 70px;
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
    <table width="100%" style="color: #7e8d9f;font-size: 15px;">
        <tr>
            <td style="width: 50%">Periode : <strong>{{ $periode }}</strong></td>
            <td>Agen : <strong>{{ (empty($data_head->getAgen->nama_agen)) ? "" : $data_head->getAgen->nama_agen }}</strong></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>{{ (empty($data_head->getAgen->alamat)) ? "" : $data_head->getAgen->alamat }} {{ (empty($data_head->getAgen->no_telepon)) ? "" : ",".$data_head->getAgen->no_telepon }}</strong></td>
        </tr>
    </table>
    <br>
    <table style="border-collapse: collapse; width: 100%;" cellpadding="3" border="1">
        <thead>
            <tr>
                <th rowspan="2">Voucher</th>
                <th rowspan="2" style="width: 15%">Harga Modal</th>
                <th colspan="3" class="text-center">Stok Distribusi</th>
                <th colspan="3" class="text-center">Stok Realisasi</th>
            </tr>
            <tr>
                <th style="width: 10%;" class="text-center">Awal</th>
                <th style="width: 10%;" class="text-center">Tambahan</th>
                <th style="width: 10%;" class="text-center">Total</th>
                <th style="width: 10%;" class="text-center">Sisa</th>
                <th style="width: 10%;" class="text-center">Terjual</th>
                <th style="width: 15%; text-align:right">Sub&nbsp;Total&nbsp;(Rp.)</th>
            </tr>
        </thead>
        <tbody>
            @php
            $t_stok_terjual=0; $t_laba=0; $total=0; $sisa=0; $t_stok_sisa=0; $sub_total=0;
            @endphp
            @foreach ($list_penjualan as $r)
            @php
                $total = $r->stok_awal + ((empty($r->stok_tambahan)) ? 0 : $r->stok_tambahan);
                $sisa = (empty($r->stok_terjual)) ? "0" : $total - $r->stok_terjual;
                $sub_total = $r->harga_modal * $r->stok_terjual;
            @endphp
            <tr>
                <td style="height: 25px">{{ $r->nama_voucher }}</td>
                <td style="text-align:right">Rp. {{ number_format($r->harga_modal, 0) }}</td>
                <td style="text-align:center">{{ $r->stok_awal }}</td>
                <td style="text-align:center">{{ (empty($r->stok_tambahan)) ? "" : $r->stok_tambahan }}</td>
                <td style="text-align:center">{{ $total }}</td>
                <td style="text-align:center">{{ ($sisa==0) ? "" : $sisa }}</td>
                <td style="text-align:center">{{ (empty($r->stok_terjual)) ? "" : $r->stok_terjual }}</td>
                <td style="text-align:right">{{ ($sub_total==0) ? "" : "Rp. ".number_format(($sub_total), 0) }}</td>
            </tr>
            @php
                $t_stok_sisa+=$sisa;
                $t_stok_terjual+=$r->stok_terjual;
                $t_laba+=$sub_total;
            @endphp
            @endforeach
            <tr>
                <td colspan="5" style="text-align:right; height: 25px"><b>TOTAL</b></td>
                <td style="text-align:center">{{ (empty($t_stok_sisa)) ? "" : $t_stok_sisa }}</td>
                <td style="text-align:center">{{ (empty($t_stok_terjual)) ? "" : $t_stok_terjual }}</td>
                <td style="text-align:right">{{ (empty($t_laba)) ? "" : "Rp. ".number_format(($t_laba), 0) }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table style="width: 100%">
        <tr>
            <td style="width: 60%"></td>
            <td style="text-align: right">Makassar, {{ date('d-m-Y') }}</td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right">Dicetak oleh : {{ auth()->user()->name }}</td>
        </tr>
    </table>
</main>
</body>
</html>

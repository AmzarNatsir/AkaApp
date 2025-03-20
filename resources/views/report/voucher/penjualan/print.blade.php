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
                <img src="{{ public_path('assets/images/akagroup/akagroup.png') }}" alt="Logo" width="200px" height="auto" class="logo"/>
                </td>
                <td align="right" style="width: 50%;"></td>
            </tr>
            <tr><td colspan="2"><hr style="border: 1px solid black; border-collapse: collapse;"></td></tr>
        </table>
    </div>
</header>
<body>
<main>
    <p style="color: #7e8d9f;font-size: 20px;">Agen <strong>#{{ (empty($data_head->getAgen->nama_agen)) ? "" : $data_head->getAgen->nama_agen }}</strong> | Periode : <strong>{{ $periode }}</strong></p>
    <table style="border-collapse: collapse; width: 100%;" cellpadding="3" border="1">
        <thead>
            <tr>
                <th rowspan="2">Voucher</th>
                <th rowspan="2" style="width: 10%">Harga&nbsp;Modal</th>
                <th rowspan="2" style="width: 10%">Harga&nbsp;Jual</th>
                <th colspan="3" class="text-center">Stok Distribusi</th>
                <th colspan="2" class="text-center">Stok Realisasi</th>
            </tr>
            <tr>
                <th style="width: 10%;" class="text-center">Awal</th>
                <th style="width: 10%;" class="text-center">Tambahan</th>
                <th style="width: 10%;" class="text-center">Akhir</th>
                <th style="width: 10%;" class="text-center">Terjual</th>
                <th style="width: 15%; text-align:right">Sub&nbsp;Total&nbsp;(Rp.)</th>
            </tr>
        </thead>
        <tbody>
            @php
            $t_stok_terjual=0; $t_laba=0;
            @endphp
            @foreach ($list_penjualan as $r)
            @php
            $total_stok_distribusi = $r->stok_awal + ((empty($r->stok_tambahan)) ? 0 : $r->stok_tambahan);
            $total_laba = $r->harga_modal * $r->stok_terjual;
            @endphp
            <tr>
                <td>{{ $r->nama_voucher }}</td>
                <td>Rp. {{ number_format($r->harga_modal, 0) }}</td>
                <td>Rp. {{ number_format($r->harga_jual, 0) }}</td>
                <td style="text-align:center">{{ $r->stok_awal }}<input type="hidden" id="tempStokAwal" name="tempStokAwal[]" value="{{ $r->stok_awal }}"></td>
                <td style="text-align:center">{{ (empty($r->stok_tambahan)) ? 0 : $r->stok_tambahan }}</td>
                <td style="text-align:center">{{ $total_stok_distribusi }}</td>
                <td style="font-size:15pt; text-align:center"><b>{{ $r->stok_terjual }}</b></td>
                <td style="text-align:right;font-size:15pt"><b>{{ number_format($total_laba, 0) }}</b></td>
            </tr>
            @php
            $t_stok_terjual+=$r->stok_terjual;
            $t_laba+=$total_laba;
            @endphp
            @endforeach
            <tr>
                <td colspan="6" style="text-align:right"><b>TOTAL</b></td>
                <td style="text-align:center;font-size:15pt"><b>{{ number_format($t_stok_terjual, 0) }}</b></td>
                <td style="text-align:right;font-size:15pt"><b>{{ number_format($t_laba, 0) }}</b></td>
            </tr>
        </tbody>
    </table>
</main>
</body>
</html>

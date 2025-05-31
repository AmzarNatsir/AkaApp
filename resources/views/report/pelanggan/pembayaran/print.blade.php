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
            <td style='text-align: center; font-size: 15pt'><b>LAPORAN PEMBAYARAN PELANGGAN</b></td>
        </tr>
        <tr>
            <td style='text-align: center; font-size: 9pt'>Periode : {{ $periode }}
            </td>
        </tr>
    </table>
    <table style='border-collapse: collapse; width: 100%; margin-top: 10px' border="1">
        <thead>
            <tr>
                <th style='width: 5%; height: 25px'>#</th>
                <th style='width: 12%;'>Tanggal</th>
                <th style='width: 15%;'>Wilayah</th>
                <th>Pelanggan</th>
                <th style='text-align: right; width: 13%;'>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; $nom=1; @endphp
            @foreach($listData as $list)
                <tr>
                <td style="height: 20px; text-align: center">{{ $nom }}</td>
                <td style='text-align: center'>{{ date_format(date_create($list->tgl_bayar), 'd-m-Y') }}</td>
                <td style='text-align: left'>{{ $list->wilayah }}</td>
                <td style='text-align: left'>{{ $list->nama_pelanggan }}</td>
                <td style='text-align: right'>{{ number_format($list->nominal, 0, ",", ".") }}</td>
                </tr>
                @php $nom++; $total+=$list->nominal @endphp
            @endforeach
            <tr style="background-color: #eaedf1">
                <td colspan="4" style="text-align: right; height: 25px"><b>TOTAL</b></td>
                <td style="text-align: right;"><b>{{ number_format($total, 0, ",", ".") }}</b></td>
            </tr>
        </tbody>
    </table>
</main>
</body>
</html>

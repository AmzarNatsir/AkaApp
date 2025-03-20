<div class="alert alert-info dark" role="alert">
    <p>Realisasi penjualan voucher telah disimpan.</p>
</div>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th rowspan="2">Voucher</th>
                <th rowspan="2" style="width: 10%">Harga&nbsp;Modal</th>
                <th rowspan="2" style="width: 10%">Harga&nbsp;Jual</th>
                <th colspan="3" class="text-center" style="background-color: rgba(0, 102, 102, 0.9); color:white">Stok Distribusi</th>
                <th colspan="2" class="text-center" style="background-color: rgba(254, 106, 73, 0.9); color:white">Stok Realisasi</th>
            </tr>
            <tr>
                <th style="width: 10%; background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">Awal</th>
                <th style="width: 10%; background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">Tambahan</th>
                <th style="width: 10%; background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">Akhir</th>
                <th style="width: 10%; background-color: rgba(254, 106, 73, 0.9); color:white" class="text-center">Terjual</th>
                <th style="width: 15%; text-align:right; background-color: rgba(254, 106, 73, 0.9); color:white">Sub&nbsp;Total&nbsp;(Rp.)</th>
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
                <td style="background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">{{ $r->stok_awal }}<input type="hidden" id="tempStokAwal" name="tempStokAwal[]" value="{{ $r->stok_awal }}"></td>
                <td style="background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">{{ (empty($r->stok_tambahan)) ? 0 : $r->stok_tambahan }}</td>
                <td style="background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">{{ $total_stok_distribusi }}</td>
                <td style="background-color: rgba(254, 106, 73, 0.9); color:white; font-size:15pt" class="text-center"><b>{{ $r->stok_terjual }}</b></td>
                <td style="background-color: rgba(254, 106, 73, 0.9); color:white; text-align:right;font-size:15pt"><b>{{ number_format($total_laba, 0) }}</b></td>
            </tr>
            @php
            $t_stok_terjual+=$r->stok_terjual;
            $t_laba+=$total_laba;
            @endphp
            @endforeach
            <tr>
                <td colspan="6" style="background-color: rgba(121, 126, 126, 0.9); color:white; text-align:right"><b>TOTAL</b></td>
                <td style="background-color: rgba(254, 106, 73, 0.9); color:white; text-align:center;font-size:15pt"><b>{{ number_format($t_stok_terjual, 0) }}</b></td>
                <td style="background-color: rgba(254, 106, 73, 0.9); color:white; text-align:right;font-size:15pt"><b>{{ number_format($t_laba, 0) }}</b></td>
            </tr>
        </tbody>
    </table>
</div>


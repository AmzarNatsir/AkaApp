<input type="hidden" name="postHeadID" value="{{ $head_id }}">
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th rowspan="2">Voucher</th>
                <th rowspan="2" style="width: 10%">Harga&nbsp;Modal</th>
                <th rowspan="2" style="width: 10%">Harga&nbsp;Jual</th>
                <th colspan="3" class="text-center" style="background-color: rgba(0, 102, 102, 0.9); color:white">Stok Distribusi</th>
                <th colspan="3" class="text-center" style="background-color: rgba(254, 106, 73, 0.9); color:white">Stok Realisasi</th>
            </tr>
            <tr>
                <th style="width: 8%; background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">Awal</th>
                <th style="width: 8%; background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">Tambahan</th>
                <th style="width: 8%; background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">Akhir</th>
                <th style="width: 12%; background-color: rgba(254, 106, 73, 0.9); color:white" class="text-center">Sisa</th>
                <th style="width: 12%; background-color: rgba(254, 106, 73, 0.9); color:white" class="text-center">Terjual</th>
                <th style="width: 12%; text-align:right; background-color: rgba(254, 106, 73, 0.9); color:white">Sub&nbsp;Total&nbsp;(Rp.)</th>
            </tr>
        </thead>
        <tbody>
            @php
            $t_sisa_stok = 0; $t_stok_terjual=0; $t_laba=0;
            @endphp
            @foreach ($list_distribusi as $r)
            @php
            $total_stok_distribusi = $r->stok_awal + ((empty($r->stok_tambahan)) ? 0 : $r->stok_tambahan);
            $total_laba = $r->harga_modal * $total_stok_distribusi;
            @endphp
            <tr>
                <td>{{ $r->nama_voucher }}<input type="hidden" name="idDetail[]" id="idDetail[]" value="{{ $r->id }}"></td>
                <td>Rp. {{ number_format($r->harga_modal, 0) }}<input type="hidden" name="inphargaModal[]" id="inphargaModal[]" value="{{ $r->harga_modal }}"></td>
                <td>Rp. {{ number_format($r->harga_jual, 0) }}<input type="hidden" name="inphargaJual[]" id="inphargaJual[]" value="{{ $r->harga_jual }}"></td>
                <td style="background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">{{ $r->stok_awal }}<input type="hidden" id="tempStokAwal" name="tempStokAwal[]" value="{{ $r->stok_awal }}"></td>
                <td style="background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">{{ (empty($r->stok_tambahan)) ? 0 : $r->stok_tambahan }}<input type="hidden"  name="inpStokTambahan[]" id="inpStokTambahan[]" value="{{ (empty($r->stok_tambahan)) ? 0 : $r->stok_tambahan }}"></td>
                <td style="background-color: rgba(0, 102, 102, 0.9); color:white" class="text-center">{{ $total_stok_distribusi }}<input type="hidden"  name="inpTotalStok[]" id="inpTotalStok[]" value="{{ $total_stok_distribusi }}"></td>
                <td ><input type="text" class="form-control angka" name="inpSisaStok[]" value="0" onblur="changeToNull(this)" oninput="getTerjual(this)" style="text-align:center"></td>
                <td><input type="text" class="form-control angka" name="inpStokTerjual[]" value="{{ $total_stok_distribusi }}" style="text-align:center" readonly></td>
                <td><input type="text" class="form-control angka" name="inpSubTotal[]" value="{{ $total_laba }}" style="text-align:right" readonly></td>
            </tr>
            @php
            $t_stok_terjual+=$total_stok_distribusi;
            $t_laba+=$total_laba;
            @endphp
            @endforeach
            <tr>
                <td colspan="6" style="background-color: rgba(121, 126, 126, 0.9); color:white; text-align:right"><b>TOTAL</b></td>
                <td><input type="text" class="form-control angka" name="inpTotalSisa" id="inpTotalSisa" value="0" style="text-align:center" readonly></td>
                <td><input type="text" class="form-control angka" name="inpTotalTerjual" id="inpTotalTerjual" value="{{ $t_stok_terjual }}" style="text-align:center" readonly></td>
                <td><input type="text" class="form-control angka" name="inpTotalLaba" id="inpTotalLaba" value="{{ $t_laba }}" style="text-align:right" readonly></td>
            </tr>
        </tbody>
    </table>
</div>
<br>
<div class="col-12 text-end">
    <button type="submit" class="btn btn-danger" id="tbl_submit_finish" name="tbl_submit_finish" value="finish">Finish</button>
</div>


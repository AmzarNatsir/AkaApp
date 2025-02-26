<input type="hidden" name="postBulan" value="{{ $bulan }}">
<input type="hidden" name="postTahun" value="{{ $tahun }}">
<input type="hidden" name="postAgen" value="{{ $agen }}">
<input type="hidden" name="postHeadID" value="{{ $head_id }}">
<input type="hidden" name="postAction" value="update">
<table class="table" style="width: 100%">
    <thead>
        <th style="width: 20%">Voucher</th>
        <th style="width: 20%">Harga Modal</th>
        <th style="width: 20%">Harga Jual</th>
        <th style="width: 20%">Stok Awal</th>
        <th style="width: 20%">Stok Tambahan</th>
        <th style="width: 20%">Sisa Stok</th>
    </thead>
    <tbody>
        @foreach ($list_distribusi as $r)
        <tr>
            <td>{{ $r->nama_voucher }}<input type="hidden" name="idDetail[]" id="idDetail[]" value="{{ $r->id }}"></td>
            <td>Rp. {{ number_format($r->harga_modal, 0) }}<input type="hidden" name="inphargaModal[]" id="inphargaModal[]" value="{{ $r->harga_modal }}"></td>
            <td>Rp. {{ number_format($r->harga_jual, 0) }}<input type="hidden" name="inphargaJual[]" id="inphargaJual[]" value="{{ $r->harga_jual }}"></td>
            <td><input type="text" class="form-control angka" name="inpStokAwal[]" value="{{ $r->stok_awal }}" onblur="changeToNull(this)" readonly></td>
            <td><input type="text" class="form-control angka" name="inpStokTambahan[]" value="{{ (empty($r->stok_tambahan)) ? 0 : $r->stok_tambahan }}" onblur="changeToNull(this)" readonly></td>
            <td><input type="text" class="form-control angka" name="inpSisaStok]" value="0" onblur="changeToNull(this)"></td>
        </tr>
        @endforeach
        <tr>
            <td colspan="6">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary" id="tbl_submit" name="tbl_submit">Close</button>
                </div>
            </td>
        </tr>
    </tbody>
</table>


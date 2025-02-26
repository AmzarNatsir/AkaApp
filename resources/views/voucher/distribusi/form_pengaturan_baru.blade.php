<input type="hidden" name="postBulan" value="{{ $bulan }}">
<input type="hidden" name="postTahun" value="{{ $tahun }}">
<input type="hidden" name="postAgen" value="{{ $agen }}">
<input type="hidden" name="postAction" value="store">
<table class="table" style="width: 100%">
    <thead>
        <th style="width: 30%">Voucher</th>
        <th style="width: 25%">Harga Modal</th>
        <th style="width: 25%">Harga Jual</th>
        <th style="width: 20%">Stok Awal</th>
    </thead>
    <tbody>
        @foreach ($list_voucher as $r)
        <tr>
            <td>{{ $r->nama_voucher }}<input type="hidden" name="inpVoucher[]" id="inpVoucher[]" value="{{ $r->nama_voucher }}"><input type="hidden" name="inpVoucherID[]" id="inpVoucherID[]" value="{{ $r->id }}"></td>
            <td>Rp. {{ number_format($r->harga_modal, 0) }}<input type="hidden" name="inphargaModal[]" id="inphargaModal[]" value="{{ $r->harga_modal }}"></td>
            <td>Rp. {{ number_format($r->harga_jual, 0) }}<input type="hidden" name="inphargaJual[]" id="inphargaJual[]" value="{{ $r->harga_jual }}"></td>
            <td><input type="text" class="form-control angka" name="inpStokAwal[]" value="0" onblur="changeToNull(this)"></td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4">
                <div class="alert alert-success dark" role="alert">
                    <p>Masukkan pengaturan awal distribusi voucher ke agen periode yang anda pilih</p>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary" id="tbl_submit_pengaturan" name="tbl_submit_pengaturan">Simpan Pengaturan</button>
                </div>
            </td>
        </tr>
    </tbody>
</table>


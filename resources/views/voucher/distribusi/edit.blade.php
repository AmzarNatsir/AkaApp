<form id="updateForm" class="timepicker-wrapper needs-validation" method="post" novalidate="">
@csrf
<input type="hidden" name="postAction" value="update">
<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Detail Distribusi Voucher</h3>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table style="width: 100%;">
                                <tbody>
                                  <tr style="padding: 28px 0; display: flex; justify-content: space-between;">
                                    <td style="width: 50%"><span style=" font-size: 16px; font-weight: 500; opacity: 0.8;">PERIODE</span>
                                      <h4 style="font-weight:600; margin: 12px 0 5px 0; font-size: 18px; #006666;">{{ $periode }}</h4>
                                    </td>
                                    <td style="width: 50%"><span style="font-size: 16px; font-weight: 500;opacity: 0.8;">AGEN</span>
                                      <h4 style="font-weight:600; margin: 12px 0 5px 0; font-size: 18px; #006666;">{{ $dataH->getAgen->nama_agen }}</h4><span style="display:block; line-height: 1.5;  font-size: 18px; font-weight: 400;opacity: 0.8;">{{ $dataH->getAgen->alamat }}</span><span style="line-height:2;  font-size: 18px; font-weight: 400;opacity: 0.8;">No. Telepon : {{ $dataH->getAgen->no_telepon }}</span>
                                    </td>
                                  </tr>
                                </tbody>
                            </table>
                            <table class="table" style="width: 100%">
                                <thead>
                                    <th style="width: 20%">Voucher</th>
                                    <th style="width: 20%">Harga Modal</th>
                                    <th style="width: 20%">Harga Jual</th>
                                    <th style="width: 20%">Stok Awal</th>
                                    <th style="width: 20%">Stok Tambahan</th>
                                </thead>
                                <tbody>
                                    @foreach ($dataD as $r)
                                    <tr>
                                        <td>{{ $r->nama_voucher }}<input type="hidden" name="idDetail[]" id="idDetail[]" value="{{ $r->id }}"></td>
                                        <td>Rp. {{ number_format($r->harga_modal, 0) }}<input type="hidden" name="inphargaModal[]" id="inphargaModal[]" value="{{ $r->harga_modal }}"></td>
                                        <td>Rp. {{ number_format($r->harga_jual, 0) }}<input type="hidden" name="inphargaJual[]" id="inphargaJual[]" value="{{ $r->harga_jual }}"></td>
                                        <td><input type="text" class="form-control angka" name="inpStokAwal[]" value="{{ $r->stok_awal }}" onblur="changeToNull(this)"></td>
                                        <td><input type="text" class="form-control angka" name="inpStokTambahan[]" value="{{ (empty($r->stok_tambahan)) ? 0 : $r->stok_tambahan }}" onblur="changeToNull(this)"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" type="submit" id="tbl_submit_pengaturan">Simpan Perubahan</button>
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
</div>
</form>
<script>
    document.querySelector('#updateForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting

        Swal.fire({
            title: "Anda yakin menyimpan perubahan pengaturan?",
            text: "Pengaturan distribusi voucher!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Simpan!",
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('voucher.distribusi.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.success == true) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.replace("{{ route('voucher.distribusi.list') }}");
                            });
                        } else {
                            Swal.fire("Terjadi kesalahan", response.message, "error");
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        Swal.fire("Terjadi kesalahan", "Ada yang salah!", "error");
                    }
                });
            }
        });
    });
</script>


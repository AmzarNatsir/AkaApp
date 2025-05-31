<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Edit Data Pelanggan</h3>
    <div class="modal-body">
        <form id="updateForm" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate="">
        @csrf
        {{ method_field('PUT') }}
        <input type="hidden" name="idData" id="idData" value="{{ $res->id }}">
            <div class="col-md-12">
                <label class="form-label" for="inpNama">Nama Pelanggan</label>
                <input class="form-control" id="inpNama" name="inpNama" type="text" maxlength="100" value="{{ $res->nama_pelanggan }}"  required="">
                <div class="valid-feedback">Looks good!</div>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="inpAlamat">Alamat</label>
                <input class="form-control" id="inpAlamat" name="inpAlamat" type="text" value="{{ $res->alamat }}" maxlength="100">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpNotel_1">No.Telepon 1</label>
                <input class="form-control" id="inpNotel_1" name="inpNotel_1" type="text" value="{{ $res->no_telepon_1 }}" maxlength="20" required="">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpNotel_2">No.Telepon</label>
                <input class="form-control" id="inpNotel_2" name="inpNotel_2" type="text" value="{{ $res->no_telepon_2 }}" maxlength="20">
            </div>
            <div class="col-md-6 position-relative">
                <label class="form-label" for="selectWilayah">Wilayah</label>
                <select class="form-select select" id="selectWilayah" name="selectWilayah" required="">
                    <option selected="" disabled="" value="">Pilihan...</option>
                    @foreach ($listWilayah as $wilayah)
                    @if($wilayah['id'] == $res->wilayah)
                    <option value="{{ $wilayah['id'] }}" selected="">{{ $wilayah['wilayah'] }}</option>
                    @else
                    <option value="{{ $wilayah['id'] }}">{{ $wilayah['wilayah'] }}</option>
                    @endif
                    @endforeach
                </select>
                <div class="invalid-tooltip">Wilayah belum dipilih</div>
            </div>
            <div class="col-md-6 position-relative">
                <label class="form-label" for="selectpaket">Paket Internet</label>
                <select class="form-select select" id="selectpaket" name="selectpaket" required="">
                    <option selected="" disabled="" value="">Pilihan...</option>
                    @foreach ($listPaket as $paket)
                    @if($paket['id'] == $res->paket_internet)
                    <option value="{{ $paket['id'] }}" selected="">{{ $paket['nama_paket'] }}</option>
                    @else
                    <option value="{{ $paket['id'] }}">{{ $paket['nama_paket'] }}</option>
                    @endif
                    @endforeach
                </select>
                <div class="invalid-tooltip">Paket internet belum dipilih</div>
            </div>
            <hr>
            <div class="col-md-12">
                <label class="form-label" for="inpNamaSales">Nama Sales</label>
                <input class="form-control" id="inpNamaSales" name="inpNamaSales" type="text" maxlength="100" value="{{ $res->nama_sales }}">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpNotelSales">No. Telepon Sales</label>
                <input class="form-control" id="inpNotelSales" name="inpNotelSales" type="text" maxlength="100" value="{{ $res->no_telepon_sales }}">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpNorekSales">No. Rekening Bank</label>
                <input class="form-control" id="inpNorekSales" name="inpNorekSales" type="text" maxlength="100" value="{{ $res->no_rekening_sales }}">
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpNamaBankSales">Nama Bank Sales</label>
                <input class="form-control" id="inpNamaBankSales" name="inpNamaBankSales" type="text" maxlength="100" value="{{ $res->nama_bank }}">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Save changes</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        // const forms = document.querySelectorAll(".needs-validation");
        $(".select").select2({
            placeholder: "Pilihan",
            allowClear: true
        });
        $("#updateForm").validate({
            rules: {
                inpNama: {
                    required: true,
                },
                inpAlamat: {
                    required: true,
                },
                inpNotel_1: {
                    required: true,
                },
                selectWilayah: {
                    required: true,
                },
                selectpaket: {
                    required: true,
                },
            },
            messages: {
                inpNama: {
                    required: "Nama pelanggan tidak boleh kosong",
                },
                inpNama: {
                    required: "Alamat pelanggan tidak boleh kosong",
                },
                inpNotel_1: {
                    required: "Nomor Telepon pelanggan tidak boleh kosong",
                },
            },
            errorClass: "text-danger",
            errorElement: "small",
            highlight: function(element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            }
        });
        $('#updateForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            if (!$(this).valid()) {
                return false;
            }
            let formData = new FormData(document.getElementById('updateForm'));
            $.ajax({
                url: "{{ url('pelanggan/update') }}/"+$("#idData").val(), // Update this with your route
                type: "POST",
                data: formData, //$(this).serialize(),
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success==true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Good Job!',
                            text: response.message
                        });
                        // $('#updateForm')[0].reset();
                        location.reload();
                    } else {
                        return false;
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText); // Debugging errors
                    Swal.fire({
                        icon: 'error',
                        title: "It's danger!",
                        text: "Something went wrong! "+response.message
                    });
                }
            });
        });
    });
</script>

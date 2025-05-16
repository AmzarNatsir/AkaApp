<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Input Data Pelanggan Baru</h3>
    <div class="modal-body">
        <form id="createForm" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate="">
        @csrf
            <div class="col-md-12">
                <label class="form-label" for="inpNama">Nama Pelanggan</label>
                <input class="form-control" id="inpNama" name="inpNama" type="text" maxlength="100" required="">
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpAlamat">Alamat</label>
                <input class="form-control" id="inpAlamat" name="inpAlamat" type="text" maxlength="100" required="">
            </div>
            <div class="col-md-6 position-relative">
                <label class="form-label" for="inpNotel_1">No.Telepon 1</label>
                <input class="form-control" id="inpNotel_1" name="inpNotel_1" type="text" maxlength="20" required="">
            </div>
            <div class="col-md-6 position-relative">
                <label class="form-label" for="inpNotel_2">No.Telepon 2 (Optional)</label>
                <input class="form-control" id="inpNotel_2" name="inpNotel_2" type="text" maxlength="20">
            </div>
            <div class="col-md-6 position-relative">
                <label class="form-label" for="selectWilayah">Wilayah</label>
                <select class="form-select select" id="selectWilayah" name="selectWilayah" required="">
                    {{-- <option selected="" disabled="" value="">Pilihan...</option> --}}
                    @foreach ($listWilayah as $wilayah)
                    <option value="{{ $wilayah['id'] }}">{{ $wilayah['wilayah'] }}</option>
                    @endforeach
                </select>
                <div class="invalid-tooltip">Wilayah belum dipilih</div>
            </div>
            <div class="col-md-6 position-relative">
                <label class="form-label" for="selectpaket">Paket Internet</label>
                <select class="form-select select" id="selectpaket" name="selectpaket" required="">
                    {{-- <option selected="" disabled="" value="">Pilihan...</option> --}}
                    @foreach ($listPaket as $paket)
                    <option value="{{ $paket['id'] }}">{{ $paket['nama_paket'] }}</option>
                    @endforeach
                </select>
                <div class="invalid-tooltip">Paket internet belum dipilih</div>
            </div>
            <hr>
            <div class="col-md-12">
                <label class="form-label" for="inpNamaSales">Nama Sales</label>
                <input class="form-control" id="inpNamaSales" name="inpNamaSales" type="text" maxlength="100">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpNotelSales">No. Telepon Sales</label>
                <input class="form-control" id="inpNotelSales" name="inpNotelSales" type="text" maxlength="100">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpNorekSales">No. Rekening Bank</label>
                <input class="form-control" id="inpNorekSales" name="inpNorekSales" type="text" maxlength="100">
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpNamaBankSales">Nama Bank Sales</label>
                <input class="form-control" id="inpNamaBankSales" name="inpNamaBankSales" type="text" maxlength="100">
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
        // Array.from(forms).forEach((form) => {
        //     form.addEventListener(
        //     "submit",
        //     (event) => {
        //         if (!form.checkValidity()) {
        //         event.preventDefault();
        //         event.stopPropagation();
        //         }
        //         form.classList.add("was-validated");
        //     },
        //     false
        //     );
        // });
        $("#createForm").validate({
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
                selectWilayah: {
                    required: "Pilihan wilayah pelanggan tidak boleh kosong",
                },
                selectpaket: {
                    required: "Pilihan paket internet pelanggan tidak boleh kosong",
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

        $('#createForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            if (!$(this).valid()) {
                return false;
            }

            let formData = new FormData(document.getElementById('createForm'));
            $.ajax({
                url: "{{ route('pelanggan.store') }}", // Update this with your route
                type: "POST",
                data: formData, //$(this).serialize(),
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success==true) {
                        // swal("Good job!", response.message, "success");
                        Swal.fire({
                            icon: 'success',
                            title: 'Good Job!',
                            text: response.message
                        });
                        $('#createForm')[0].reset();
                        $('#table_view').DataTable().ajax.reload(); // Refresh DataTable
                        // location.reload();
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

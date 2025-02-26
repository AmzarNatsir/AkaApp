<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Input Data Petugas</h3>
    <div class="modal-body">
        <form id="createForm" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate="">
        @csrf
            <div class="col-md-12">
                <label class="form-label" for="inpNama">Nama Petugas</label>
                <input class="form-control" id="inpNama" name="inpNama" type="text" maxlength="100" required="">
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="col-md-8">
                <label class="form-label" for="inpTempatLahir">Tempat Lahir</label>
                <input class="form-control" id="inpTempatLahir" name="inpTempatLahir" type="text" maxlength="100" required="">
            </div>
            <div class="col-md-4">
                <label class="form-label" for="inpTanggalLahir">Tanggal Lahir</label>
                <div class="input-group flatpicker-calender">
                    <input class="form-control" name="inpTanggalLahir" id="datetime-local" type="date" value="{{ date('Y-m-d') }}" required="">
                </div>
            </div>
            <div class="col-md-12">
                <div class="card-wrapper border rounded-3 checkbox-checked">
                    <label class="form-label" for="inpTanggalLahir">Jenis Kelamin</label>
                    <div class="form-check-size rtl-input">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input me-2" id="jenkel_1" type="radio" name="pilihanJenkel" value="Laki-Laki" checked="">
                            <label class="form-check-label" for="jenkel_1">Laki-Laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input me-2" id="jenkel_2" type="radio" name="pilihanJenkel" value="Perempuan">
                            <label class="form-check-label" for="jenkel_2">Perempuan</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpAlamat">Alamat</label>
                <input class="form-control" id="inpAlamat" name="inpAlamat" type="text" maxlength="100">
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpNotel">No.Telepon</label>
                <input class="form-control" id="inpNotel" name="inpNotel" type="text" maxlength="20">
            </div>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <img class="img-thumbnail" src="{{ asset('assets/images/ecommerce/product-table-7.png') }}" id="preview_upload" itemprop="thumbnail" alt="Empty">
                </div>
                <div class="col-md-8 position-relative">
                    <label class="form-label" for="inpFile">Upload Photo (* jpg, png, jpeg)</label>
                    <input class="form-control" id="inpFile" name="inpFile" type="file" onchange="loadFile(this)">
                </div>
            </div>
            <hr>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Save changes</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        const forms = document.querySelectorAll(".needs-validation");
        Array.from(forms).forEach((form) => {
            form.addEventListener(
            "submit",
            (event) => {
                if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                }

                form.classList.add("was-validated");
            },
            false
            );
        });
        $('#createForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            let formData = new FormData(document.getElementById('createForm'));
            $.ajax({
                url: "{{ route('petugas.store') }}", // Update this with your route
                type: "POST",
                data: formData, //$(this).serialize(),
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success==true) {
                        swal("Good job!", response.message, "success");
                        $('#createForm')[0].reset();
                        // location.reload();
                    } else {
                        return false;
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText); // Debugging errors
                    swal("It's danger", "Something went wrong!", "error");
                }
            });
        });
    });
    var _validFileExtensions = [".jpg", ".jpeg", ".png"];
    var loadFile = function(oInput) {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            var sSizeFile = oInput.files[0].size;
            var output = document.getElementById('preview_upload');
            //alert(sSizeFile);
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }

                if (!blnValid) {
                    swal("Maaf, " + sFileName + " tidak valid, jenis file yang boleh di upload adalah : " + _validFileExtensions.join(", "), {
                        icon: 'warning',
                    });
                    oInput.value = "";
                    return false;
                }

                output.src = URL.createObjectURL(oInput.files[0]);
            }

        }
        return true;

    };
</script>

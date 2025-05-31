<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Edit Data Petugas</h3>
    <div class="modal-body">
        <form id="updateForm" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate="">
        @csrf
        {{ method_field('PUT') }}
        <input type="hidden" name="idData" id="idData" value="{{ $res->id }}">
            <div class="col-md-12">
                <label class="form-label" for="inpNama">Nama Petugas</label>
                <input class="form-control" id="inpNama" name="inpNama" type="text" maxlength="100" value="{{ $res->nama_petugas }}"  required="">
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="col-md-8">
                <label class="form-label" for="inpTempatLahir">Tempat Lahir</label>
                <input class="form-control" id="inpTempatLahir" name="inpTempatLahir" type="text" maxlength="100" value="{{ $res->tempat_lahir }}" required="">
            </div>
            <div class="col-md-4">
                <label class="form-label" for="inpTanggalLahir">Tanggal Lahir</label>
                <div class="input-group flatpicker-calender">
                    <input class="form-control" name="inpTanggalLahir" id="datetime-local" type="date" value="{{ $res->tanggal_lahir }}" required="">
                </div>
            </div>
            <div class="col-md-12">
                <div class="card-wrapper border rounded-3 checkbox-checked">
                    <label class="form-label" for="inpTanggalLahir">Jenis Kelamin</label>
                    <div class="form-check-size rtl-input">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input me-2" id="jenkel_1" type="radio" name="pilihanJenkel" value="Laki-Laki" {{ ($res->jenkel=="Laki-Laki") ? "checked" : "" }}>
                            <label class="form-check-label" for="jenkel_1">Laki-Laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input me-2" id="jenkel_2" type="radio" name="pilihanJenkel" value="Perempuan" {{ ($res->jenkel=="Perempuan") ? "checked" : "" }}>
                            <label class="form-check-label" for="jenkel_2">Perempuan</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpAlamat">Alamat</label>
                <input class="form-control" id="inpAlamat" name="inpAlamat" type="text" value="{{ $res->alamat }}" maxlength="100">
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpNotel">No.Telepon</label>
                <input class="form-control" id="inpNotel" name="inpNotel" type="text" value="{{ $res->no_telepon }}" maxlength="20">
            </div>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <img class="img-thumbnail" src="{{ url(Storage::url('petugas/'.$res->photo)) }}" id="preview_upload" itemprop="thumbnail" alt="Image description">
                </div>
                <div class="col-md-8 position-relative">
                    <label class="form-label" for="inpFile">Upload photo untuk mengganti photo (* jpg, png, jpeg) - (Maksimal 2MB)</label>
                    <input class="form-control" id="inpFile" name="inpFile" type="file" onchange="loadFile(this)">
                    <input type="hidden" name="tmpFile" id="tmpFile" value="{{ $res->photo }}">
                    <input type="hidden" name="tmpFilePath" id="tmpFilePath" value="{{ $res->photo_path }}">
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
        $('#updateForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            let formData = new FormData(document.getElementById('updateForm'));
            $.ajax({
                url: "{{ url('petugas/update') }}/"+$("#idData").val(), // Update this with your route
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
                        window.location.href = "{{ url('petugas/list') }}";
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
    var _validFileExtensions = [".jpg", ".jpeg", ".png"];
    var _maxFileSize = 2 * 1024 * 1024; // 2 MB in bytes
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
                    Swal.fire({
                        icon: 'error',
                        title: "It's danger!",
                        text: "Maaf, " + sFileName + " tidak valid, jenis file yang boleh di upload adalah : " + _validFileExtensions.join(", ")
                    });
                    oInput.value = "";
                    return false;
                }

                // ✅ Max file size check
                 if (sSizeFile > _maxFileSize) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'File Terlalu Besar!',
                        text: "Ukuran maksimum file adalah 2 MB."
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

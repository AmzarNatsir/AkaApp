<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Import Data Pelanggan</h3>
    <div class="modal-body">
        <form id="importForm" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate="">
        @csrf
            <div class="col-md-12">
                <label class="form-label" for="inpFile">Upload File</label>
                <input class="form-control" id="inpFile" name="inpFile" type="file" accept=".csv" required="" onchange="loadFile(this)">
                <label class="form-check-label mt-3 " for="inpFile" style="color: red">* CSV File Only</label>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Import</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#importForm").validate({
            rules: {
                inpFile: {
                    required: true,
                },
            },
            messages: {
                inpFile: {
                    required: "Anda belum memilih file yang akan di import",
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
        $('#importForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            if (!$(this).valid()) {
                return false;
            }
            let formData = new FormData(this);
            // let formData = new FormData(document.getElementById('importForm'));
            // Show SweetAlert2 Loading Spinner
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while saving your data.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            try {
                $.ajax({
                    url: "{{ route('pelanggan.doImportPelanggan') }}", // Update this with your route
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
                            location.reload();
                        } else {
                            Swal.fire({
                            icon: 'error',
                            title: "It's danger!",
                            text: response.message
                        });
                            return false;
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText); // Debugging errors
                        Swal.fire({
                            icon: 'error',
                            title: "It's danger!",
                            text: response.message
                        });
                    }
                });
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong! '.error
                });
            }
        });
    });
    var _validFileExtensions = [".csv"];
    var loadFile = function(oInput) {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            var sSizeFile = oInput.files[0].size;
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
                    // alert("Maaf, " + sFileName + " tidak valid, jenis file yang boleh di upload adalah : " + _validFileExtensions.join(", "));
                    oInput.value = "";
                    return false;
                }
            }

        }
        return true;

    };
</script>

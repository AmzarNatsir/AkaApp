<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Input Data Asset</h3>
    <div class="modal-body">
        <form id="createForm" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate="">
        @csrf
            <div class="col-md-12">
                <label class="form-label" for="inpNama">Nama Asset</label>
                <input class="form-control" id="inpNama" name="inpNama" type="text" maxlength="100" required="">
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpKategori">Kategori</label>
                <select class="form-select" id="inpKategori" name="inpKategori" required="">
                    <option selected="" disabled="" value="">Pilih Kategori</option>
                    <option value="1">Laptop</option>
                    <option value="2">PC</option>
                    <option value="3">Printer</option>
                    <option value="4">Monitor</option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpTanggalPerolehan">Tanggal Perolehan</label>
                <div class="input-group flatpicker-calender">
                    <input class="form-control" name="inpTanggalPerolehan" id="inpTanggalPerolehan" type="date" value="{{ date('Y-m-d') }}" required="">
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpHargaPerolehan">Harga Perolehan (Rp.)</label>
                <input class="form-control" id="inpHargaPerolehan" name="inpHargaPerolehan" type="text" value="0">
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpJumlah">Jumlah</label>
                <input class="form-control" id="inpJumlah" name="inpJumlah" type="text" value="0">
            </div>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <img class="img-thumbnail" src="{{ asset('assets/images/ecommerce/product-table-7.png') }}" id="preview_upload" itemprop="thumbnail" alt="Empty">
                </div>
                <div class="col-md-8 position-relative">
                    <label class="form-label" for="inpFile">Upload Gambar (* jpg, png, jpeg)</label>
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

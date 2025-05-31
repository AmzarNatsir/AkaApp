@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Material</h4>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('material.index') }}">Daftar</a></li>
                    <li class="breadcrumb-item active">Tambah data baru</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah data material</h4>
                </div>
                <div class="card-body">
                    <form id="createForm" class="row g-3 needs-validation custom-input" method="post" enctype="multipart/form-data" novalidate="">
                    @csrf
                        <div class="col-md-12 position-relative">
                            <label class="form-label" for="inpMaterial">Nama material</label>
                            <input class="form-control" id="inpMaterial" name="inpMaterial" type="text" required="">
                            <div class="invalid-tooltip">Anda belum mengisi nama material</div>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label class="form-label" for="selectMerek">Merek</label>
                            <select class="form-select select" id="selectMerek" name="selectMerek" required="">
                                <option selected="" disabled="" value="">Pilihan...</option>
                                @foreach ($listMerek as $merek)
                                <option value="{{ $merek['id'] }}">{{ $merek['merek'] }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-tooltip">Anda belum memilih merek</div>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label class="form-label" for="selectSatuan">Satuan</label>
                            <select class="form-select select" id="selectSatuan" name="selectSatuan" required="">
                                <option selected="" disabled="" value="">Pilihan...</option>
                                @foreach ($listSatuan as $satuan)
                                <option value="{{ $satuan['id'] }}">{{ $satuan['satuan'] }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-tooltip">Anda belum memilih satuan</div>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label class="form-label" for="inpHargaBeli">Harga Beli (Rp.)</label>
                            <input class="form-control angka" id="inpHargaBeli" name="inpHargaBeli" value="0" type="text" required="">
                        </div>
                        <div class="col-md-3 position-relative">
                            <label class="form-label" for="inpStokAwal">Stok Awal</label>
                            <input class="form-control angka" id="inpStokAwal" name="inpStokAwal" value="0" type="text" maxlength="4" oninput="toStockAkhir(this)" onblur="toStockAkhir(this)" required="">
                        </div>
                        <div class="col-md-3 position-relative">
                            <label class="form-label" for="inpStokAkhir">Stok Akhir</label>
                            <input class="form-control angka" id="inpStokAkhir" name="inpStokAkhir" value="0" type="text" maxlength="4" readonly>
                        </div>
                        <div class="col-md-12 position-relative">
                            <label class="form-label" for="inpDeskripsi">Deskripsi</label>
                            <textarea class="form-control" name="inpDeskripsi" id="inpDeskripsi"></textarea>
                        </div>
                        <hr>
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <img class="img-thumbnail" src="{{ asset('assets/images/ecommerce/product-table-7.png') }}" id="preview_upload" itemprop="thumbnail" alt="Empty">
                            </div>
                            <div class="col-md-8 position-relative">
                                <label class="form-label" for="inpFile">Upload file (* jpg, png, jpeg) - (Maksimal 2MB)</label>
                                <input class="form-control" id="inpFile" name="inpFile" type="file" onchange="loadFile(this)">
                            </div>
                        </div>
                        <hr>
                        <div class="row col-12 justify-content-center">
                            <button class="btn btn-primary" type="submit">Submit form</button>
                        </div>
                        <hr>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".select").select2({
            placeholder: "Pilihan",
            allowClear: true
        });
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
        $(".angka").number(true, 0);
        $('#createForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            let formData = new FormData(document.getElementById('createForm'));
            $.ajax({
                url: "{{ route('material.store') }}", // Update this with your route
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
                        window.location.href = "{{ url('material/list') }}";
                    } else {
                        return false;
                        // Swal.fire({
                        //     icon: 'error',
                        //     title: "It's danger!",
                        //     text: response.message
                        // });
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText); // Debugging errors
                    Swal.fire({
                        icon: 'error',
                        title: "It's danger!",
                        text: xhr.responseText
                    });
                }
            });
        });
    });
    var toStockAkhir = function(el)
    {
        $("#inpStokAkhir").val($(el).val());
    }
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
                    // alert("Maaf, " + sFileName + " tidak valid, jenis file yang boleh di upload adalah : " + _validFileExtensions.join(", "));
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
@endsection

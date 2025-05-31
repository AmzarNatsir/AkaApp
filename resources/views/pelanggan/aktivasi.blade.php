@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Pelanggan</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg></a></li>
                    <li class="breadcrumb-item active">Daftar</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <form id="aktivasiForm" method="post" enctype="multipart/form-data" class="theme-form needs-validation" novalidate="">
        @csrf
        <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="{{ $pelanggan->id }}">
        <input type="hidden" name="id_wilayah" id="id_wilayah" value="{{ $pelanggan->wilayah }}">
        {{-- <input type="hidden" name="id_pemakaian" id="id_pemakaian" value=""> --}}
        <input type="hidden" name="gudangID" id="gudangID" value="1">
        <input type="hidden" name="totalItem" id="totalItem" value="0">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Aktivasi Pelanggan</span>
                </div>
                <div class="card-body table-responsive">
                    <div class="row">
                        <div class="col-xxl-6 col-md-6 box-col-6">
                            <div class="card-body pt-2 row important-project">
                                <ul class="pro-services">
                                <li>
                                    <div class="media-body">
                                        <h4>Pelanggan : {{ $pelanggan->nama_pelanggan }}</h4>
                                    </div>
                                </li>
                                <li>
                                    <div class="media-body">
                                        <h5>Alamat : {{ $pelanggan->alamat }} - {{ $pelanggan->getWilayah->wilayah }}</h5>
                                    </div>
                                </li>
                                <li>
                                    <div class="media-body">
                                        <h5>No. Telepon : {{ $pelanggan->no_telepon_1 }}{{ (!empty($pelanggan->no_telepon_2)) ? " - ".$pelanggan->no_telepon_2 : "" }}</h5>
                                    </div>
                                </li>
                                <li>
                                    <div class="media-body">
                                        <h5>Paket : {{ $pelanggan->getPaket->nama_paket }}</h5>
                                    </div>
                                </li>
                                </ul>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Data Pemasangan</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label>Petugas (Multiple) <span class="font-danger">*</span></label>
                                                <select class="form-control select" name="pilPetugas[]" id="pilPetugas" required multiple>
                                                    @foreach ($listPetugas as $petugas)
                                                    <option value="{{ $petugas->id }}">{{ $petugas->nama_petugas }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="inpTanggalAktivasi">Tanggal Aktivasi:<span class="font-danger">*</span></label>
                                                <input class="form-control" name="inpTanggalAktivasi" id="inpTanggalAktivasi" type="date" value="{{ date('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="inpSN_ONT">Serial Number ONT:<span class="font-danger">*</span></label>
                                                <input class="form-control" id="inpSN_ONT" name="inpSN_ONT" type="text" maxlength="100" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="inpModel_ONT">Model ONT:<span class="font-danger">*</span></label>
                                                <input class="form-control" id="inpModel_ONT" name="inpModel_ONT" type="text" maxlength="100" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="inpODP">ODP:<span class="font-danger">*</span></label>
                                                <input class="form-control" id="inpODP" name="inpODP" type="text" maxlength="100" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="inpTikorODP">Titik Kordinat ODP:<span class="font-danger">*</span></label>
                                                <input class="form-control" id="inpTikorODP" name="inpTikorODP" type="text" maxlength="100" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="inpTikorPelanggan">Titik Kordinat Pelanggan:<span class="font-danger">*</span></label>
                                                <input class="form-control" id="inpTikorPelanggan" name="inpTikorPelanggan" type="text" maxlength="100" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="inpPort">Port:<span class="font-danger">*</span></label>
                                                <input class="form-control" id="inpPort" name="inpPort" type="text" maxlength="50" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="inpPortIfle">Port Ifle:<span class="font-danger">*</span></label>
                                                <input class="form-control" id="inpPortIfle" name="inpPortIfle" type="text" maxlength="50" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="inpSplitter">Splitter:<span class="font-danger">*</span></label>
                                                <input class="form-control" id="inpSplitter" name="inpSplitter" type="text" maxlength="50" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="inpKabelDC">Kabel DC:<span class="font-danger">*</span></label>
                                                <input class="form-control" id="inpKabelDC" name="inpKabelDC" type="text" maxlength="50" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-md-6 box-col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Lampiran Gambar (Maks. 2MB)</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0">Upload Gambar Rumah:</label>
                                            <input class="form-control" name="fileRumah" id="fileRumah" type="file" onchange="loadFile(this)">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0">Upload ODP:</label>
                                            <input class="form-control" name="fileODP" id="fileODP" type="file" onchange="loadFile(this)">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0">Upload ONT Terpasang:</label>
                                            <input class="form-control" name="fileOntTerpasang" id="fileOntTerpasang" onchange="loadFile(this)" type="file">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0">Upload ONT Belakang:</label>
                                            <input class="form-control" name="fileOntBelakang" id="fileOntBelakang" onchange="loadFile(this)" type="file">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0">Upload Redaman di ODP:</label>
                                            <input class="form-control" name="fileRedamanDiOdp" id="fileRedamanDiOdp" onchange="loadFile(this)" type="file">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0">Upload Redaman Rumah Pelanggan:</label>
                                            <input class="form-control" name="fileRedamanRumahPelanggan" id="fileRedamanRumahPelanggan" type="file" onchange="loadFile(this)">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0">Upload Gambar Lainnya:</label>
                                            <input class="form-control" name="fileLainnya" id="fileLainnya" type="file" onchange="loadFile(this)">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Material yang digunakan</span>
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid search-page">
                                        <div class="row">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="col-sm-12">
                                                        <select class="form-control selectMaterial" name="searhMaterial" id="searhMaterial">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="card">
                                                <div class="card-body pt-0">
                                                    <div class="table-order table-responsive custom-scrollbar">
                                                        <table class="display table-order" style="width: 100%">
                                                            <thead>
                                                                <th style="width: 10%; height: 30px"></th>
                                                                <th>Material</th>
                                                                <th style="width: 15%">Jumlah</th>
                                                            </thead>
                                                            <tbody class="row_baru"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="flex; justify-content: center; align-items: center;">
                                <button class="btn btn-primary" type="submit">Finished</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".select").select2({
            // dropdownParent: $('#modalAktivasi'),
            placeholder: "Pilihan",
            allowClear: true
        });
        flatpickr("#inpTanggalAktivasi", {
            enableTime: false,
            dateFormat: "Y-m-d",
        });
        $(".selectMaterial").select2({
            placeholder: "Cari Material",
            allowClear: true,
            minimumInputLength: 2,
            ajax: {
                url: '{{ route("material.searchMaterial") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        })
        .on('change', function (e) {
            var materialID = $(this).val();
            if (materialID) {
                var duplicate = false;
                $('input[name="item_id_material[]"]').each(function () {
                    if ($(this).val() == materialID) {
                        duplicate = true;
                        return false; // break loop
                    }
                });
                if (duplicate) {
                    Swal.fire({
                        icon: 'warning',
                        title: "Duplicate Material",
                        text: "Material yang anda pilih sudah ada!"
                    });
                    // Clear and reopen Select2
                    $('.selectMaterial').val(null).trigger('change');
                    setTimeout(function () {
                        $('.selectMaterial').select2('open');
                    }, 100);
                    return;
                }
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                    },
                    url: "{{ route('pemakaianMaterial.getItem') }}", // Update this with your route
                    type: "POST",
                    data: {
                        itemID: materialID
                    },
                    success: function (response) {
                        if (response.success==true) {
                            // alert(response.message);
                            var content_item = '<tr class="rows_item" name="rows_item[]" style="height: 30px"><td class="text-center"><input type="hidden" name="current_stok[]" value='+response.result.stok_akhir+'><input type="hidden" name="current_harga[]" value='+response.result.harga_beli+'><button type="button" class="btn-warning" title="Hapus Baris" onclick="hapus_item(this)"><i class="fa fa-minus"></i></button></td>'+
                                '<td><input type="hidden" name="item_id_material[]" value="'+response.result.id+'"><div class="product-names"><p>'+response.result.material+'</p></div></td>'+
                                '<td align="center"><input type="text" min="1" max="'+response.result.stok_akhir+'" id="item_qty[]" name="item_qty[]" class="form-control angka" value="1" style="text-align:center" onInput="checkStokAkhir(this)" onblur="checkStokAkhir(this)"></td>'+'</tr>';
                            $(".row_baru").after(content_item);
                            $(".angka").number(true, 0);
                            calculateTotalItem();

                             // Clear and reopen Select2
                            $('.selectMaterial').val(null).trigger('change');
                            setTimeout(function () {
                                $('.selectMaterial').select2('open');
                            }, 100);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: "It's danger!",
                                text: "Something went wrong! "+response.message
                            });
                            return false;
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText); // Debugging errors
                        Swal.fire({
                            icon: 'error',
                            title: "It's danger!",
                            text: "Something went wrong! "+xhr.responseText
                        });
                    }
                });
            } else {
                $('#row_baru').empty();
            }
        });

        $("#aktivasiForm").validate({
            rules: {
                'pilPetugas[]': {
                    required: true,
                },
                inpTanggalAktivasi: {
                    required: true,
                },
                inpSN_ONT: {
                    required: true,
                },
                inpModel_ONT: {
                    required: true,
                },
                inpODP: {
                    required: true,
                },
                inpTikorODP: {
                    required: true,
                },
                inpTikorPelanggan: {
                    required: true,
                },
                inpPort: {
                    required: true,
                },
                inpPortIfle: {
                    required: true,
                },
                inpSplitter: {
                    required: true,
                },
                inpKabelDC: {
                    required: true,
                },
            },
            messages: {
                'pilPetugas[]': {
                    required: "Pilihan petugas tidak boleh kosong",
                },
                inpTanggalAktivasi: {
                    required: "Inputan tanggal aktivasi tidak boleh kosong",
                },
                inpSN_ONT: {
                    required: "Inputan Serial Number ONT tidak boleh kosong",
                },
                inpModel_ONT: {
                    required: "Inputan Model ONT tidak boleh kosong",
                },
                inpODP: {
                    required: "Inputan ODP tidak boleh kosong",
                },
                inpTikorODP: {
                    required: "Inputan Titik Kordinat ODP tidak boleh kosong",
                },
                inpTikorPelanggan: {
                    required: "Inputan Titik Kordinat Pelanggan tidak boleh kosong",
                },
                inpPort: {
                    required: "Inputan Port tidak boleh kosong",
                },
                inpPortIfle: {
                    required: "Inputan Port Ifle tidak boleh kosong",
                },
                inpSplitter: {
                    required: "Inputan Splitter tidak boleh kosong",
                },
                inpKabelDC: {
                    required: "Inputan Kabel DC tidak boleh kosong",
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
        $('#aktivasiForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            let formData = new FormData(document.getElementById('aktivasiForm'));
            $.ajax({
                url: "{{ route('pelanggan.simpanAktivasi') }}", // Update this with your route
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
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
                        window.location.href = "{{ url('pelanggan/daftar') }}";
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
                        text: "Something went wrong! "+xhr.responseText
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
            // var output = document.getElementById('preview_upload');
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
                        icon: 'warning',
                        title: 'Warning!',
                        text: sFileName + " tidak valid. Jenis file yang boleh diupload adalah: " + _validFileExtensions.join(", ")
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

                // output.src = URL.createObjectURL(oInput.files[0]);
            }

        }
        return true;

    };
    var hapus_item = function(el){
        $(el).parent().parent().slideUp(100,function(){
            $(this).remove();
            calculateTotalItem();
        });
    }
    var checkStokAkhir = function(el){
        var currentRow=$(el).closest("tr");
        var current_stok = $(el).parent().parent().find('input[name="current_stok[]"]').val();
        var current_harga_modal = $(el).parent().parent().find('input[name="current_stok[]"]').val();
        var jumlah = $(el).parent().parent().find('input[name="item_qty[]"]').val();
        if(parseFloat(jumlah) > parseFloat(current_stok)) {
            swal("Warning", "Stok tidak cukup! Stok akhir : "+current_stok, "error");
            currentRow.find('td:eq(2) input[name="item_qty[]"]').val("0");
            currentRow.find('td:eq(2) input[name="item_qty[]"]').focus();
        }
        currentRow.find('td:eq(2) input[name="item_qty[]"]').focus();

        // total();
        // hitung_total_net();
    }

    var calculateTotalItem = function()
    {
        var total = 0;
        $.each($('input[name="item_qty[]"]'),function(key, value){
            total += parseFloat($(value).val());
        })
        $("#totalItem").val(total);
    }
</script>
@endsection


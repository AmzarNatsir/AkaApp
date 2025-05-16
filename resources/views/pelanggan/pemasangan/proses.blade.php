<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Proses pengaturan</h3>
    <div class="modal-body">
        <form id="prosesForm" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate="">
        @csrf
        <input type="hidden" name="idPelanggan" id="idPelanggan" value="{{ $res->id }}">
        <input type="hidden" name="idWilayahPelanggan" id="idWilayahPelanggan" value="{{ $res->wilayah }}">
        <input type="hidden" name="gudangID" id="gudangID" value="1">
        <input type="hidden" name="totalItem" id="totalItem" value="0">
            <div class="col-sm-4">
                <div class="card height-equal">
                    <div class="card-header border-l-secondary border-2 p-3">
                        <h4>Pelanggan</h4>
                        <p class="mt-1 f-m-light txt-primary fw-bold">{{ $res->nama_pelanggan }}</p>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item txt-primary fw-bold"><h6><i class="fa fa-location-arrow"></i> Alamat : </h6><span>{{ $res->alamat }}</span><br><span>Wilayah: {{ $res->getWilayah->wilayah }}</span></li>
                            <li class="list-group-item txt-primary fw-bold"><h6><i class="fa fa-phone"></i> No. Telepon</h6>
                                <span>{{ $res->no_telepon_1 }}{{ (!empty($res->no_telepon_2)) ? " - ".$res->no_telepon_2 : "" }}</span></li>
                            <li class="list-group-item txt-primary fw-bold"><h6><i class="icofont icofont-star-shape"></i> Paket yang dipilih : </h6><span>{{ $res->getPaket->nama_paket }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="row justify-content-center">
                    <div class="col-md-12 project-list">
                        <div class="card">
                            <div class="card-body">
                                <div class="form theme-form">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Tanggal</label>
                                            <input class="form-control" name="inpTanggal" id="datetime-local" type="date" value="{{ date('Y-m-d') }}" readonly>
                                        </div>
                                        <div class="col-md-9">
                                            <label>Kategori</label>
                                            <select class="form-control select" name="pilKategori" id="pilKategori" required>
                                                <option value="1" selected>Pemesangan Baru</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label>Petugas (Multiple)</label>
                                                <select class="form-control select" name="pilPetugas[]" id="pilPetugas" required="" multiple>
                                                    @foreach ($listPetugas as $petugas)
                                                    <option value="{{ $petugas->id }}">{{ $petugas->nama_petugas }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <label>Keterangan</label>
                                            <input type="text" class="form-control" name="inpKeterangan" id="inpKeterangan" maxlength="100" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 project-list">
                        <div class="card">
                            <div class="card-header border-l-info border-2 p-3">
                                <h4>Material yang digunakan</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="form theme-form">
                                    <div class="row mb-4">
                                        <div class="col-sm-8">
                                            <select class="form-control form-control-sm select" name="pilItem" id="pilItem" required="">
                                                <option selected="" disabled="" value="">Pilihan...</option>
                                                @foreach ($listMaterial as $r)
                                                <option value="{{ $r->id }}" {{ ($r->stok_akhir==0) ? "disabled" : "" }}>{{ $r->material }} - {{ (empty($r->getMerek->merek)) ? "" : $r->getMerek->merek }} (Stok : {{ $r->stok_akhir }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4 d-flex align-items-end">
                                            <button type="button" class="btn btn-primary btn-square" name="btn_add_item" id="btn_add_item" onclick="addItem(this)"><i class="fa fa-plus"></i> Tambah Item</button>
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
                    </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        const forms = document.querySelectorAll(".needs-validation");
        $(".select").select2({
            placeholder: "Pilihan",
            allowClear: true
        });
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

    });
    var addItem = function(el)
    {
        var materialID = $("#pilItem").val();
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
                        var content_item = '<tr class="rows_item" name="rows_item[]"><td><input type="hidden" name="current_stok[]" value='+response.result.stok_akhir+'><input type="hidden" name="current_harga[]" value='+response.result.harga_beli+'><button type="button" title="Hapus Baris" class="btn btn-secondary btn-sm" onclick="hapus_item(this)"><i class="fa fa-minus"></i></button></td>'+
                            '<td><input type="hidden" name="item_id_material[]" value="'+response.result.id+'"><div class="product-names"><p>'+response.result.material+'</p></div></td>'+
                            '<td align="center"><input type="text" min="1" max="'+response.result.stok_akhir+'" id="item_qty[]" name="item_qty[]" class="form-control angka" value="1" style="text-align:center" onInput="checkStokAkhir(this)" onblur="checkStokAkhir(this)"></td>'+'</tr>';
                        $(".row_baru").after(content_item);
                        $(".angka").number(true, 0);
                        calculateTotalItem();
                    } else {
                        swal("It's danger", response.message, "error");
                        return false;
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText); // Debugging errors
                    swal("It's danger", "Something went wrong!", "error");
                }
            });
        } else {
            $('#row_baru').empty();
        }
    }
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

    document.querySelector('#prosesForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting
        if($("#pilKategori").val()=="" || $("#pilKategori").val()==null) {
            swal("Warning", "Pilihan kategori tidak boleh kosong", "error");
            return false;
        }
        if($("#pilPetugas").val()=="" || $("#pilPetugas").val()==null) {
            swal("Warning", "Pilihan petugas tidak boleh kosong", "error");
            return false;
        }
        if($("#inpKeterangan").val()=="") {
            swal("Warning", "Pengisian keterangan transaksi tidak boleh kosong", "error");
            return false;
        }
        if($("#totalItem").val()==0) {
            swal("Warning", "Item pemakaian material masih kosong", "error");
            return false;
        }
        // alert($("#pilKategori").val());
        Swal.fire({
            title: "Are you sure?",
            text: "Submit this item!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, save it!",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-primary"
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('pelanggan.storeProses') }}", // Update this with your route
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
                                window.location.href = "{{ route('pelanggan.index') }}";
                            });
                        } else {
                            Swal.fire("Terjadi kesalahan", response.message, "error");
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        Swal.fire("It's danger", "Something went wrong!", "error");
                    }
                });
            }
        });
        // swal({
        //     title: "Are you sure?",
        //     text: "Submit this item!",
        //     icon: "warning",
        //     buttons: {
        //         cancel: {
        //             text: "Cancel",
        //             visible: true,
        //             className: "btn btn-primary",
        //         },
        //         confirm: {
        //             text: "Yes, save it!",
        //             className: "btn btn-success",
        //         }
        //     }
        // }).then((result) => {
        //     if (result==true) {
            //     $.ajax({
            //         url: "{{ route('pelanggan.storeProses') }}", // Update this with your route
            //         type: "POST",
            //         data: $(this).serialize(),
            //         success: function (response) {
            //             if (response.success==true) {
            //                 swal('Success! '+response.message, {
            //                     icon: 'success',
            //                     buttons: false,
            //                     timer: 2000
            //                 }).then(() => {
            //                     location.replace("{{ route('pelanggan.index') }}");
            //                 });

            //             } else {
            //                 swal("Terjadi kesalahan", response.message, "error");
            //                 return false;
            //             }
            //         },
            //         error: function (xhr) {
            //             console.log(xhr.responseText); // Debugging errors
            //             swal("It's danger", "Something went wrong!", "error");
            //         }
            //     });
            // } else {
            //     swal.close();
            // }

        // });
    });
</script>

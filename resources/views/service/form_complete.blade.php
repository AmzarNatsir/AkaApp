<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Form Complete Task</h3>
    <form id="completeForm" method="post" enctype="multipart/form-data" class="theme-form needs-validation" novalidate="">
    @csrf
    <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="{{ $pelanggan->id }}">
    <input type="hidden" name="id_pemakaian" id="id_pemakaian" value="{{ $pemakaian->id }}">
    <div class="modal-body">
        <div class="todo-list-wrapper theme-scrollbar">
            <div class="todo-list-container">
                <div class="todo-list-body">
                    <ul id="todo-list">
                        <li class="task">
                            <div class="card">
                                <div class="job-search">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <h6 class="f-w-600"> <a href="#">Pelanggan : {{ $pelanggan->nama_pelanggan }}</a></h6>
                                                <p>
                                                    <i class="fa fa-location-arrow"></i> {{ $pelanggan->alamat }} - {{ $pelanggan->getWilayah->wilayah }}<br>
                                                    <i class="fa fa-phone"></i> {{ $pelanggan->no_telepon_1 }}{{ (!empty($pelanggan->no_telepon_2)) ? " - ".$pelanggan->no_telepon_2 : "" }}<br>
                                                    <span><i class="fa fa-star font-warning"></i> Paket: {{ $pelanggan->getPaket->nama_paket }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="inpMetode_Bayar">Metode Pembayaran:<span class="font-danger">*</span></label>
                                <select class="form-select select" id="inpMetode_Bayar" name="inpMetode_Bayar" required>
                                    <option value="">Pilih Metode Pembayaran</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Transfer">Transfer</option>
                                </select>
                            </div>
                        </div>
                    </div>
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
                    <hr>
                    <div class="row">
                        <div class="col">
                          <div class="mb-3">
                            <label class="col-form-label pt-0">Upload Gambar Rumah:<span class="font-danger">*</span></label>
                            <input class="form-control" name="fileRumah" id="fileRumah" type="file" onchange="loadFile(this)" required>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                          <div class="mb-3">
                            <label class="col-form-label pt-0">Upload ODP:<span class="font-danger">*</span></label>
                            <input class="form-control" name="fileODP" id="fileODP" type="file" onchange="loadFile(this)" required>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                          <div class="mb-3">
                            <label class="col-form-label pt-0">Upload ONT Terpasang:<span class="font-danger">*</span></label>
                            <input class="form-control" name="fileOntTerpasang" id="fileOntTerpasang" onchange="loadFile(this)" type="file" required>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                          <div class="mb-3">
                            <label class="col-form-label pt-0">Upload ONT Belakang:<span class="font-danger">*</span></label>
                            <input class="form-control" name="fileOntBelakang" id="fileOntBelakang" onchange="loadFile(this)" type="file" required>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                          <div class="mb-3">
                            <label class="col-form-label pt-0">Upload Redaman di ODP:<span class="font-danger">*</span></label>
                            <input class="form-control" name="fileRedamanDiOdp" id="fileRedamanDiOdp" onchange="loadFile(this)" type="file" required>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                          <div class="mb-3">
                            <label class="col-form-label pt-0">Upload Redaman Rumah Pelanggan:<span class="font-danger">*</span></label>
                            <input class="form-control" name="fileRedamanRumahPelanggan" id="fileRedamanRumahPelanggan" type="file" onchange="loadFile(this)" required>
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
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="submit">Completed</button>
    </div>
</form>
</div>
<script>
    $(document).ready(function () {
        $("#completeForm").validate({
            rules: {
                inpMetode_Bayar: {
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
                fileRumah: {
                    required: true,
                },
                fileODP: {
                    required: true,
                },
                fileOntTerpasang: {
                    required: true,
                },
                fileOntBelakang: {
                    required: true,
                },
                fileRedamanDiOdp: {
                    required: true,
                },
                fileRedamanRumahPelanggan: {
                    required: true,
                },
            },
            messages: {
                inpMetode_Bayar: {
                    required: "Pilihan metode pembayaran tidak boleh kosong",
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
                fileRumah: {
                    required: "Upload Gambar Rumah tidak boleh kosong",
                },
                fileODP: {
                    required: "Upload Gambar ODP tidak boleh kosong",
                },
                fileOntTerpasang: {
                    required: "Upload Gambar ONT Terpasang tidak boleh kosong",
                },
                fileOntBelakang: {
                    required: "Upload Gambar ONT Bagian Belakang tidak boleh kosong",
                },
                fileRedamanDiOdp: {
                    required: "Upload Gambar Redaman ODP tidak boleh kosong",
                },
                fileRedamanRumahPelanggan: {
                    required: "Upload Gambar Redaman Rumah tidak boleh kosong",
                }
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
        $('#completeForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            if (!$(this).valid()) {
                return false;
            }
            let formData = new FormData(document.getElementById('completeForm'));
            $.ajax({
                url: "{{ route('service.storeFormComplete') }}", // Update this with your route
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
                        text: "Something went wrong! "+xhr.responseText
                    });
                }
            });
        });
    });
</script>

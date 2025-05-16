<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Form Aktivasi Pelanggan</h3>
    <form id="aktivasiForm" method="post" class="row g-3 needs-validation" novalidate="">
    @csrf
    <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="{{ $pelanggan->id }}">
    <input type="hidden" name="id_pemasangan" id="id_pemasangan" value="{{ $pemasangan_detail->id }}">
    <input type="hidden" name="id_nama_pelanggan" id="id_nama_pelanggan" value="{{ $pelanggan->nama_pelanggan }}">
    <input type="hidden" name="id_nama_sales" id="id_nama_sales" value="{{ $pelanggan->nama_sales }}">
    <input type="hidden" name="id_norek_sales" id="id_norek_sales" value="{{ $pelanggan->no_rekening_sales }}">
    <input type="hidden" name="id_bank_sales" id="id_bank_sales" value="{{ $pelanggan->nama_bank }}">
    <div class="modal-body">
        <div class="todo">
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
                                                    <h6 class="f-w-600">
                                                        <span class="pull-right"><i class="fa fa-calendar"></i> Post at : {{ $pemakaian_material->tanggal }}</span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xxl-6 col-md-6 box-col-6">
                                                    <div class="card">
                                                        <div class="card-body pt-2 row important-project">
                                                            <ul class="pro-services">
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>Pelanggan : {{ $pelanggan->nama_pelanggan }}</h5>
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
                                                    </div>
                                                </div>
                                                <div class="col-xxl-6 col-md-6 box-col-6">
                                                    <div class="card">
                                                        <div class="card-body pt-2 row important-project">
                                                            <ul class="pro-services">
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>Sales : {{ $pelanggan->nama_sales }}</h5>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>No. Telepon : {{ $pelanggan->no_telepon_sales }}</h5>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>No. Rekening : {{ $pelanggan->no_rekening_sales }}</h5>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>Nama Bank : Paket: {{ $pelanggan->nama_bank }}</h5>
                                                                </div>
                                                            </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h6 class="f-w-600"> <a href="#">Pelanggan : {{ $pelanggan->nama_pelanggan }}</a>
                                                        <span class="pull-right"><i class="fa fa-calendar"></i> Post at : {{ $pemakaian_material->tanggal }}</span>
                                                    </h6>
                                                    <p><i class="fa fa-location-arrow"></i> {{ $pelanggan->alamat }} - {{ $pelanggan->getWilayah->wilayah }}<br>
                                                    <i class="fa fa-phone"></i> {{ $pelanggan->no_telepon_1 }}{{ (!empty($pelanggan->no_telepon_2)) ? " - ".$pelanggan->no_telepon_2 : "" }}<br>
                                                    <span><i class="fa fa-star font-warning"></i> Paket: {{ $pelanggan->getPaket->nama_paket }}</span></p>
                                                    <span><i class="fa fa-user font-warning"></i> Sales: {{ $pelanggan->nama_sales }}</span></p>
                                                </div>
                                            </div> --}}
                                            <div class="row">
                                                <div class="col-xxl-12 col-md-6 box-col-6">
                                                    <div class="card">
                                                        <div class="card-body pt-2 row important-project">
                                                            <ul class="pro-services">
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>Deskripsi : {{ $pemakaian_material->keterangan }}</h5>
                                                                </div>
                                                            </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <p>Deskripsi : {{ $pemakaian_material->keterangan }}</p> --}}
                                            <div class="project-meeting-details">
                                                <div class="project-meeting">
                                                    <span class="f-light f-12 f-w-500">Completed at</span>
                                                    <span class="f-light f-12 f-w-500 badge badge-danger text-white">Waiting Task Finished</span>
                                                </div>
                                                <div class="project-meeting-time">
                                                    <a class="f-14 f-w-500 " href="javascript:void(0)"><i class="fa fa-calendar"></i> {{ $pelanggan->tgl_completed }}</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xxl-6 col-md-6 box-col-6">
                                                    <div class="card">
                                                        <div class="card-body pt-2 row important-project">
                                                            {{-- <div class="collection-filter-block"> --}}
                                                                <ul class="pro-services">
                                                                <li>
                                                                    <div class="media-body">
                                                                        <h5>Serian Number ONT : {{ $pemasangan_detail->sn_ont }}</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="media-body">
                                                                        <h5>Model ONT : {{ $pemasangan_detail->model_ont }}</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="media-body">
                                                                        <h5>ODP : {{ $pemasangan_detail->odp }}</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="media-body">
                                                                        <h5>Titik Kordinat ODP : {{ $pemasangan_detail->tikor_odp }}</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="media-body">
                                                                        <h5>Titik Kordinat Pelanggan : {{ $pemasangan_detail->tikor_pelanggan }}</h5>
                                                                    </div>
                                                                </li>
                                                                </ul>
                                                            {{-- </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-6 col-md-6 box-col-6">
                                                    <div class="card">
                                                        <div class="card-body pt-1 row important-project">
                                                            {{-- <div class="collection-filter-block"> --}}
                                                                <ul class="pro-services">
                                                                <li>
                                                                    <div class="media-body">
                                                                        <h5>Port : {{ $pemasangan_detail->port }}</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="media-body">
                                                                        <h5>Port Ifle : {{ $pemasangan_detail->port_ifle }}</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="media-body">
                                                                        <h5>Splitter : {{ $pemasangan_detail->splitter }}</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="media-body">
                                                                        <h5>Kabel DC : {{ $pemasangan_detail->kabel_dc }}</h5>
                                                                    </div>
                                                                </li>
                                                                </ul>
                                                            {{-- </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xxl-6 col-md-6 box-col-6">
                                                    <div class="card">
                                                        <div class="card-body pt-1 row important-project">
                                                            <div class="col-xl-12 col-md-12 box-col-12">
                                                                <div class="projectlist-card">
                                                                    <div class="projectlist">
                                                                        <div class="project-data">
                                                                            <a href="{{ url(Storage::url('gambar_rumah/'.$pemasangan_detail->gambar_rumah)) }}" data-fancybox data-caption="Gambar Rumah">
                                                                            <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_rumah/'.$pemasangan_detail->gambar_rumah)) }}" alt="nft" style="width: 100px; height: auto;"></a>
                                                                            <div>
                                                                            <a class="f-14 f-w-500 d-block" href="javascript:void(0)">Gambar Rumah</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12 col-md-12 box-col-12">
                                                                <div class="projectlist-card">
                                                                    <div class="projectlist">
                                                                        <div class="project-data">
                                                                            <a href="{{ url(Storage::url('gambar_odp/'.$pemasangan_detail->gambar_odp)) }}" data-fancybox data-caption="Gambar ODP">
                                                                            <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_odp/'.$pemasangan_detail->gambar_odp)) }}" alt="nft" style="width: 100px; height: auto;"></a>
                                                                            <div>
                                                                            <a class="f-14 f-w-500 d-block" href="javascript:void(0)">Gambar ODP</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12 col-md-12 box-col-12">
                                                                <div class="projectlist-card">
                                                                    <div class="projectlist">
                                                                        <div class="project-data">
                                                                            <a href="{{ url(Storage::url('gambar_ont_terpasang/'.$pemasangan_detail->gambar_ont_terpasang)) }}" data-fancybox data-caption="Gambar ODP">
                                                                            <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_ont_terpasang/'.$pemasangan_detail->gambar_ont_terpasang)) }}" alt="nft" style="width: 100px; height: auto;"></a>
                                                                            <div>
                                                                            <a class="f-14 f-w-500 d-block" href="javascript:void(0)">Gambar ONT Terpasang</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-6 col-md-6 box-col-6">
                                                    <div class="card">
                                                        <div class="card-body pt-1 row important-project">
                                                            <div class="col-xl-12 col-md-12 box-col-12">
                                                                <div class="projectlist-card">
                                                                    <div class="projectlist">
                                                                        <div class="project-data">
                                                                            <a href="{{ url(Storage::url('gambar_redaman_odp/'.$pemasangan_detail->gambar_redaman_odp)) }}" data-fancybox data-caption="Gambar Redaman di ODP">
                                                                            <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_redaman_odp/'.$pemasangan_detail->gambar_redaman_odp)) }}" alt="nft" style="width: 100px; height: auto;"></a>
                                                                            <div>
                                                                            <a class="f-14 f-w-500 d-block" href="javascript:void(0)">Gambar Redaman di ODP</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12 col-md-12 box-col-12">
                                                                <div class="projectlist-card">
                                                                    <div class="projectlist">
                                                                        <div class="project-data">
                                                                            <a href="{{ url(Storage::url('gambar_redaman_rumah_pelanggan/'.$pemasangan_detail->gambar_redaman_rumah_pelanggan)) }}" data-fancybox data-caption="Gambar Redaman Rumah Pelanggan">
                                                                            <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_redaman_rumah_pelanggan/'.$pemasangan_detail->gambar_redaman_rumah_pelanggan)) }}" alt="nft" style="width: 100px; height: auto;"></a>
                                                                            <div>
                                                                            <a class="f-14 f-w-500 d-block" href="javascript:void(0)">Gambar Redaman Rumah Pelanggan</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if(!empty($pemasangan_detail->gambar_lainnya))
                                                            <div class="col-xl-12 col-md-12 box-col-12">
                                                                <div class="projectlist-card">
                                                                    <div class="projectlist">
                                                                        <div class="project-data">
                                                                            <a href="{{ url(Storage::url('gambar_lainnya/'.$pemasangan_detail->gambar_lainnya)) }}" data-fancybox data-caption="Gambar Gambar Lainnya">
                                                                            <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_lainnya/'.$pemasangan_detail->gambar_lainnya)) }}" alt="nft" style="width: 100px; height: auto;"></a>
                                                                            <div>
                                                                            <a class="f-14 f-w-500 d-block" href="javascript:void(0)">Gambar Gambar Lainnya</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form theme-form">
                                                        <div class="row form-row align-items-end">
                                                            <div class="col-md-4">
                                                                <label>Tanggal Aktivasi</label>
                                                                <input class="form-control" name="inpTanggalAktivasi" id="inpTanggalAktivasi" type="date" value="{{ date('Y-m-d') }}" required>

                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Pembayaran Awal (Rp.)</label>
                                                                <input class="form-control angka" name="inpPembayaranAwal" id="inpPembayaranAwal" type="text" value="0" style="text-align: right" required>

                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Fee Sales (Rp.)</label>
                                                                <input class="form-control angka" name="inpFeeSales" id="inpFeeSales" type="text" value="0" style="text-align: right" {{ (empty($pelanggan->nama_sales)) ? "readonly" : "" }}>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Finished</button>
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
    </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $(".angka").number(true, 0);
        $("#aktivasiForm").validate({
            rules: {
                inpTanggalAktivasi: {
                    required: true,
                },
                inpPembayaranAwal: {
                    required: true,
                    number: true,
                    min: 1 // must be at least 1 (greater than 0)
                },
            },
            messages: {
                inpTanggalAktivasi: {
                    required: "Inputan tanggal aktivasi tidak boleh kosong",
                },
                inpPembayaranAwal: {
                    required: "Nominal pembayaran awal tidak boleh kosong",
                    number: "Nominal pembayaran awal harus berupa angka",
                    min: "Nominal pembayaran pembayaran awal harus lebih besar dari 0"
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

            if (!$(this).valid()) {
                return false;
            }

            let formData = new FormData(document.getElementById('aktivasiForm'));
            $.ajax({
                url: "{{ route('pelanggan.storeAktivasi') }}", // Update this with your route
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
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
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
</script>

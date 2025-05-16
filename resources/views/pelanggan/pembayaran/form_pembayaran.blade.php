<div class="row">
    <div class="col-sm-4">
        <div class="card height-equal">
            <div class="card-header border-l-secondary border-2 p-3">
                <h4>Pelanggan</h4>
                <p class="mt-1 f-m-light txt-primary fw-bold">{{ $pelanggan->nama_pelanggan }}</p>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item txt-primary fw-bold"><h6><i class="fa fa-location-arrow"></i> Alamat : </h6><span>{{ $pelanggan->alamat }}</span><br><span>Wilayah: {{ $pelanggan->getWilayah->wilayah }}</span></li>
                    <li class="list-group-item txt-primary fw-bold"><h6><i class="fa fa-phone"></i> No. Telepon</h6>
                        <span>{{ $pelanggan->no_telepon_1 }}{{ (!empty($pelanggan->no_telepon_2)) ? " - ".$pelanggan->no_telepon_2 : "" }}</span></li>
                    <li class="list-group-item txt-primary fw-bold"><h6><i class="icofont icofont-star-shape"></i> Paket yang dipilih : </h6><span>{{ $pelanggan->getPaket->nama_paket }}</span></li>
                    <li class="list-group-item txt-primary fw-bold"><h6><i class="fa fa-calendar"></i> Tanggal Aktivasi : </h6><span>{{ $detail->tgl_aktivasi }}</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="row justify-content-center">
            <div class="col-md-12 project-list">
                <div class="card">
                    <div class="card-header border-l-secondary border-2 p-3">
                        <h4>Form Pembayaran</h4>
                    </div>
                    <div class="card-body">
                        <form id="bayarForm" method="post" class="needs-validation">
                        @csrf
                        <input type="hidden" name="idPelanggan" id="idPelanggan" value="{{ $pelanggan->id }}">
                        <input type="hidden" name="idPemasangan" id="idPemasangan" value="{{ $detail->id }}">
                        <div class="form theme-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Tanggal Bayar</label>
                                    <input class="form-control" name="inpTanggal" id="datetime-local" type="date" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Nominal</label>
                                    <input type="text" class="form-control angka" name="inpNominal" id="inpNominal" value="0" onblur="changeToNull(this)" style="text-align:right" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="row size-column">
            <div class="col-xxl-12 box-col-12">
                <div class="row">
                    <div class="col-xl-12 col-sm-12">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Complete border-b-success border-2"><span class="f-light f-w-500 f-14">Total Pembayaran</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600">Rp. {{ number_format($total_pembayaran, 0, ',', '.') }} </span>
                                    </div>
                                    <div class="product-sub bg-success-light">
                                        <svg class="invoice-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#add-square') }}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                <li class="bubble"> </li>
                                <li class="bubble"></li>
                                <li class="bubble"></li>
                                <li class="bubble"> </li>
                                <li class="bubble"></li>
                                <li class="bubble"> </li>
                                <li class="bubble"></li>
                                <li class="bubble"></li>
                                <li class="bubble"> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 project-list">
                <div class="card">
                    <div class="card-header border-l-secondary border-2 p-3">
                        <h4>History Pembayaran</h4>
                    </div>
                    <div class="card-body">
                        <table class="display table-order" style="width: 100%">
                            <thead>
                                <th>#</th>
                                <th>Periode</th>
                                <th>Tanggal</th>
                                <th style="text-align: right">Nominal</th>
                            </thead>
                            <tbody>
                                @foreach ($list_pembayaran as $r)
                                <tr>
                                    <td style="height: 30px">{{ $loop->iteration }}</td>
                                    <td>{{ date('M-Y', strtotime($r->tgl_bayar)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($r->tgl_bayar)) }}</td>
                                    <td style="text-align: right"><b>Rp. {{ number_format($r->nominal, 0) }}</b></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".angka").number(true, 0);
        $("#bayarForm").validate({
            rules: {
                inpTanggal: {
                    required: true,
                },
                inpNominal: {
                    required: true,
                    number: true,
                    min: 1 // must be at least 1 (greater than 0)
                },
            },
            messages: {
                inpTanggal: {
                    required: "Inputan tanggal pembayaran tidak boleh kosong",
                },
                inpNominal: {
                    required: "Inputan nominal pembayaran tidak boleh kosong",
                    number: "Inputan nominal harus berupa angka",
                    min: "Nominal pembayaran harus lebih besar dari 0"
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
        // Then async submit
        $('#bayarForm').submit(async function (e) {
            e.preventDefault();

            if (!$(this).valid()) {
                return false;
            }

            let formData = new FormData(this);

            try {
                // Show SweetAlert2 Loading Spinner
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while saving your data.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                // Submit using fetch + await
                let response = await fetch("{{ route('pelanggan.storePembayaran') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: formData
                });

                let data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Good Job!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: data.message
                    });
                }

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
</script>

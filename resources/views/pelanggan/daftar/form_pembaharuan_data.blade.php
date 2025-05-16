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
                        <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pelanggan.daftar') }}">Daftar Pelanggan</a></li>
                    <li class="breadcrumb-item active">Pembaharuan Data</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <form id="pembaharuanForm" method="post" enctype="multipart/form-data" class="theme-form needs-validation" novalidate="">
        @csrf
        {{ method_field('PUT') }}
        <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="{{ $pelanggan->id }}">
        <input type="hidden" name="id_pemasangan" id="id_pemasangan" value="{{ $pemasangan_detail->id }}">
        <input type="hidden" name="id_pemakaian" id="id_pemakaian" value="{{ $pemakaian->id }}">
        <input type="hidden" name="gudangID" id="gudangID" value="1">
        <input type="hidden" name="totalItem" id="totalItem" value="0">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Pembaharuan Data Pelanggan</span>
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
                                <li>
                                    <div class="media-body">
                                        <h5>Deskripsi : {{ $pemakaian->keterangan }}</h5>
                                    </div>
                                </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-md-6 box-col-6">
                            <div class="card">
                                <div class="card-body pt-2 row important-project">
                                    <ul class="pro-services">
                                    <li>
                                        <div class="media-body">
                                            <h4>Sales : {{ $pelanggan->nama_sales }}</h4>
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
                    <div class="project-meeting-details">
                        <div class="project-meeting">
                            <span class="f-light f-12 f-w-500">Completed at</span>
                            <span class="f-light f-12 f-w-500">Finished at</span>
                        </div>
                        <div class="project-meeting-time">
                            <a class="f-14 f-w-500 " href="javascript:void(0)"><i class="fa fa-calendar"></i> {{ $pelanggan->tgl_completed }}</a>
                            <a class="f-14 f-w-500 " href="javascript:void(0)"><i class="fa fa-calendar"></i> {{ $pelanggan->tgl_finished }}</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-12 col-md-12 box-col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Data Pemasangan</span>
                                </div>
                                <div class="card-body">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-6 col-md-6 box-col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Lampiran Gambar (Maks. 2MB)</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            @empty($pemasangan_detail->gambar_rumah)
                                            <img class="img-thumbnail" src="{{ asset('assets/images/akagroup/image_empty.jpg') }}" id="preview_upload" itemprop="thumbnail" alt="Tidak ada gambar"></a>
                                            @else
                                            <a href="{{ url(Storage::url('gambar_rumah/'.$pemasangan_detail->gambar_rumah)) }}" data-fancybox data-caption='Gambar Rumah'>
                                            <img class="img-thumbnail" src="{{ url(Storage::url('gambar_rumah/'.$pemasangan_detail->gambar_rumah)) }}" id="preview_upload" itemprop="thumbnail" alt="Gambar Rumah"></a>
                                            @endif
                                            <input type="hidden" name="tmp_gambar_rumah" value="{{ $pemasangan_detail->gambar_rumah }}">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0">Upload Gambar Rumah:</label>
                                                <input class="form-control" name="fileRumah" id="fileRumah" type="file" onchange="loadFile(this)">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            @empty($pemasangan_detail->gambar_odp)
                                            <img class="img-thumbnail" src="{{ asset('assets/images/akagroup/image_empty.jpg') }}" id="preview_upload" itemprop="thumbnail" alt="Tidak ada gambar"></a>
                                            @else
                                            <a href="{{ url(Storage::url('gambar_odp/'.$pemasangan_detail->gambar_odp)) }}" data-fancybox data-caption='Gambar ODP'>
                                            <img class="img-thumbnail" src="{{ url(Storage::url('gambar_odp/'.$pemasangan_detail->gambar_odp)) }}" id="preview_upload" itemprop="thumbnail" alt="Gambar ODP"></a>
                                            @endif
                                            <input type="hidden" name="tmp_gambar_odp" value="{{ $pemasangan_detail->gambar_odp }}">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0">Upload ODP:</label>
                                                <input class="form-control" name="fileODP" id="fileODP" type="file" onchange="loadFile(this)">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            @empty($pemasangan_detail->gambar_ont_terpasang)
                                            <img class="img-thumbnail" src="{{ asset('assets/images/akagroup/image_empty.jpg') }}" id="preview_upload" itemprop="thumbnail" alt="Tidak ada gambar"></a>
                                            @else
                                            <a href="{{ url(Storage::url('gambar_ont_terpasang/'.$pemasangan_detail->gambar_ont_terpasang)) }}" data-fancybox data-caption='Gambar ONT'>
                                            <img class="img-thumbnail" src="{{ url(Storage::url('gambar_ont_terpasang/'.$pemasangan_detail->gambar_ont_terpasang)) }}" id="preview_upload" itemprop="thumbnail" alt="Gambar ONT"></a>
                                            @endif
                                            <input type="hidden" name="tmp_gambar_ont_terpasang" value="{{ $pemasangan_detail->gambar_ont_terpasang }}">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0">Upload ONT Terpasang:</label>
                                                <input class="form-control" name="fileOntTerpasang" id="fileOntTerpasang" onchange="loadFile(this)" type="file">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            @empty($pemasangan_detail->gambar_belakang_ont)
                                            <img class="img-thumbnail" src="{{ asset('assets/images/akagroup/image_empty.jpg') }}" id="preview_upload" itemprop="thumbnail" alt="Tidak ada gambar"></a>
                                            @else
                                            <a href="{{ url(Storage::url('gambar_ont_belakang/'.$pemasangan_detail->gambar_belakang_ont)) }}" data-fancybox data-caption='Gambar ONT Belakang'>
                                            <img class="img-thumbnail" src="{{ url(Storage::url('gambar_ont_belakang/'.$pemasangan_detail->gambar_belakang_ont)) }}" id="preview_upload" itemprop="thumbnail" alt="Gambar ONT Belakang"></a>
                                            @endif
                                            <input type="hidden" name="tmp_gambar_ont_belakang" value="{{ $pemasangan_detail->gambar_belakang_ont }}">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0">Upload ONT Belakang:</label>
                                                <input class="form-control" name="fileOntBelakang" id="fileOntBelakang" onchange="loadFile(this)" type="file">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            @empty($pemasangan_detail->gambar_redaman_odp)
                                            <img class="img-thumbnail" src="{{ asset('assets/images/akagroup/image_empty.jpg') }}" id="preview_upload" itemprop="thumbnail" alt="Tidak ada gambar"></a>
                                            @else
                                            <a href="{{ url(Storage::url('gambar_redaman_odp/'.$pemasangan_detail->gambar_redaman_odp)) }}" data-fancybox data-caption='Gambar Redaman ODP'>
                                            <img class="img-thumbnail" src="{{ url(Storage::url('gambar_redaman_odp/'.$pemasangan_detail->gambar_redaman_odp)) }}" id="preview_upload" itemprop="thumbnail" alt="Gambar Redaman ODP"></a>
                                            @endif
                                            <input type="hidden" name="tmp_gambar_redaman_odp" value="{{ $pemasangan_detail->gambar_redaman_odp }}">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0">Upload Redaman di ODP:</label>
                                                <input class="form-control" name="fileRedamanDiOdp" id="fileRedamanDiOdp" onchange="loadFile(this)" type="file">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            @empty($pemasangan_detail->gambar_redaman_rumah_pelanggan)
                                            <img class="img-thumbnail" src="{{ asset('assets/images/akagroup/image_empty.jpg') }}" id="preview_upload" itemprop="thumbnail" alt="Tidak ada gambar"></a>
                                            @else
                                            <a href="{{ url(Storage::url('gambar_redaman_rumah_pelanggan/'.$pemasangan_detail->gambar_redaman_rumah_pelanggan)) }}" data-fancybox data-caption='Gambar Redaman Rumah Pelanggan'>
                                            <img class="img-thumbnail" src="{{ url(Storage::url('gambar_redaman_rumah_pelanggan/'.$pemasangan_detail->gambar_redaman_rumah_pelanggan)) }}" id="preview_upload" itemprop="thumbnail" alt="Gambar Redaman Rumah Pelanggan"></a>
                                            @endif
                                            <input type="hidden" name="tmp_gambar_redaman_rumah_pelanggan" value="{{ $pemasangan_detail->gambar_redaman_rumah_pelanggan }}">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0">Upload Redaman Rumah Pelanggan:</label>
                                                <input class="form-control" name="fileRedamanRumahPelanggan" id="fileRedamanRumahPelanggan" type="file" onchange="loadFile(this)">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            @empty($pemasangan_detail->gambar_lainnya)
                                            <img class="img-thumbnail" src="{{ asset('assets/images/akagroup/image_empty.jpg') }}" id="preview_upload" itemprop="thumbnail" alt="Tidak ada gambar"></a>
                                            @else
                                            <a href="{{ url(Storage::url('gambar_lainnya/'.$pemasangan_detail->gambar_lainnya)) }}" data-fancybox data-caption='Gambar Lainnya'>
                                            <img class="img-thumbnail" src="{{ url(Storage::url('gambar_lainnya/'.$pemasangan_detail->gambar_lainnya)) }}" id="preview_upload" itemprop="thumbnail" alt="Gambar Lainnya"></a>
                                            @endif
                                            <input type="hidden" name="tmp_gambar_lainnya" value="{{ $pemasangan_detail->gambar_lainnya }}">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0">Upload Gambar Lainnya:</label>
                                                <input class="form-control" name="fileLainnya" id="fileLainnya" type="file" onchange="loadFile(this)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-md-6 box-col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Material yang digunakan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid search-page">
                                        <table class="display" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%; height: 30px">No.</th>
                                                    <th>Material</th>
                                                    <th style="width: 15%">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pemakaian_material as $r)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $r->getMaterial->material }}<br>Merek: {{ $r->getMaterial->getMerek->merek }}</td>
                                                    <td>{{ $r->jumlah }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-header">
                                    <h5>Tambahkan material yang digunakan</h5>
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
                                <button class="btn btn-primary" type="submit">Simpan Pembaharuan</button>
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
                        console.log(response.result);
                        if (response.success==true) {
                            // alert(response.message);
                            var content_item = '<tr class="rows_item" name="rows_item[]" style="height: 30px"><td class="text-center"><input type="hidden" name="current_stok[]" value='+response.result.stok_akhir+'><input type="hidden" name="current_harga[]" value='+response.result.harga_beli+'><button type="button" class="btn-warning" title="Hapus Baris" onclick="hapus_item(this)"><i class="fa fa-minus"></i></button></td>'+
                                '<td><input type="hidden" name="item_id_material[]" value="'+response.result.id+'">'+response.result.material+'<br>Merek: '+response.result.get_merek.merek+'</td>'+
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
        $('#pembaharuanForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            Swal.fire({
                title: "Yakin akan menyimpan data?",
                text: "Simpan perubahan data!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Simpan!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData(document.getElementById('pembaharuanForm'));
                    $.ajax({
                        url: "{{ url('pelanggan/simpanPembaharuanDataPelanggan') }}/"+$("#id_pelanggan").val(), // Update this with your route
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
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = "{{ url('pelanggan/daftar') }}";
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
                } else {
                    Swal.close();
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

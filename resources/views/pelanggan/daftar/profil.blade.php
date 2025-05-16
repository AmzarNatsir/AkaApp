<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Profil Pelanggan</h3>
    <div class="modal-body">
        <div class="card">
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
                        <span class="f-light f-12 f-w-500">Aktivated at</span>
                    </div>
                    <div class="project-meeting-time">
                        <a class="f-14 f-w-500 " href="javascript:void(0)"><i class="fa fa-calendar"></i> {{ $pelanggan->tgl_completed }}</a>
                        <a class="f-14 f-w-500 " href="javascript:void(0)"><i class="fa fa-calendar"></i> {{ $pelanggan->tgl_finished }}</a>
                        <a class="f-14 f-w-500 " href="javascript:void(0)"><i class="fa fa-calendar"></i> {{ $pemasangan_detail->tgl_aktivasi }}</a>
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
                    <div class="col-xxl-12 col-md-12 box-col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Lampiran Gambar</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xxl-6 col-md-6 box-col-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                @empty($pemasangan_detail->gambar_rumah)
                                                <img class="img-thumbnail" src="{{ asset('assets/images/akagroup/image_empty.jpg') }}" id="preview_upload" itemprop="thumbnail" alt="Tidak ada gambar"></a>
                                                @else
                                                <a href="{{ url(Storage::url('gambar_rumah/'.$pemasangan_detail->gambar_rumah)) }}" data-fancybox data-caption='Gambar Rumah'>
                                                <img class="img-thumbnail" src="{{ url(Storage::url('gambar_rumah/'.$pemasangan_detail->gambar_rumah)) }}" id="preview_upload" itemprop="thumbnail" alt="Gambar Rumah"></a>
                                                @endif
                                                <label class="mt-2">Gambar Rumah</label>
                                            </div>
                                            <div class="col-md-6">
                                                @empty($pemasangan_detail->gambar_odp)
                                                <img class="img-thumbnail" src="{{ asset('assets/images/akagroup/image_empty.jpg') }}" id="preview_upload" itemprop="thumbnail" alt="Tidak ada gambar"></a>
                                                @else
                                                <a href="{{ url(Storage::url('gambar_odp/'.$pemasangan_detail->gambar_odp)) }}" data-fancybox data-caption='Gambar ODP'>
                                                <img class="img-thumbnail" src="{{ url(Storage::url('gambar_odp/'.$pemasangan_detail->gambar_odp)) }}" id="preview_upload" itemprop="thumbnail" alt="Gambar ODP"></a>
                                                @endif
                                                <label class="mt-2">Gambar ODP</label>
                                            </div>
                                            <div class="col-md-6">
                                                @empty($pemasangan_detail->gambar_ont_terpasang)
                                                <img class="img-thumbnail" src="{{ asset('assets/images/akagroup/image_empty.jpg') }}" id="preview_upload" itemprop="thumbnail" alt="Tidak ada gambar"></a>
                                                @else
                                                <a href="{{ url(Storage::url('gambar_ont_terpasang/'.$pemasangan_detail->gambar_ont_terpasang)) }}" data-fancybox data-caption='Gambar ONT'>
                                                <img class="img-thumbnail" src="{{ url(Storage::url('gambar_ont_terpasang/'.$pemasangan_detail->gambar_ont_terpasang)) }}" id="preview_upload" itemprop="thumbnail" alt="Gambar ONT"></a>
                                                @endif
                                                <label class="mt-2">Gambar ONT Terpasang</label>
                                            </div>
                                            <div class="col-md-6">
                                                @empty($pemasangan_detail->gambar_belakang_ont)
                                                <img class="img-thumbnail" src="{{ asset('assets/images/akagroup/image_empty.jpg') }}" id="preview_upload" itemprop="thumbnail" alt="Tidak ada gambar"></a>
                                                @else
                                                <a href="{{ url(Storage::url('gambar_ont_belakang/'.$pemasangan_detail->gambar_belakang_ont)) }}" data-fancybox data-caption='Gambar ONT Belakang'>
                                                <img class="img-thumbnail" src="{{ url(Storage::url('gambar_ont_belakang/'.$pemasangan_detail->gambar_belakang_ont)) }}" id="preview_upload" itemprop="thumbnail" alt="Gambar ONT Belakang"></a>
                                                @endif
                                                <label class="mt-2">Gambar Belakang ONT</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-md-6 box-col-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                @empty($pemasangan_detail->gambar_redaman_odp)
                                                <img class="img-thumbnail" src="{{ asset('assets/images/akagroup/image_empty.jpg') }}" id="preview_upload" itemprop="thumbnail" alt="Tidak ada gambar"></a>
                                                @else
                                                <a href="{{ url(Storage::url('gambar_redaman_odp/'.$pemasangan_detail->gambar_redaman_odp)) }}" data-fancybox data-caption='Gambar Redaman ODP'>
                                                <img class="img-thumbnail" src="{{ url(Storage::url('gambar_redaman_odp/'.$pemasangan_detail->gambar_redaman_odp)) }}" id="preview_upload" itemprop="thumbnail" alt="Gambar Redaman ODP"></a>
                                                @endif
                                                <label class="mt-2">Gambar Redaman Odp</label>
                                            </div>
                                            <div class="col-md-6">
                                                @empty($pemasangan_detail->gambar_redaman_rumah_pelanggan)
                                                <img class="img-thumbnail" src="{{ asset('assets/images/akagroup/image_empty.jpg') }}" id="preview_upload" itemprop="thumbnail" alt="Tidak ada gambar"></a>
                                                @else
                                                <a href="{{ url(Storage::url('gambar_redaman_rumah_pelanggan/'.$pemasangan_detail->gambar_redaman_rumah_pelanggan)) }}" data-fancybox data-caption='Gambar Redaman Rumah Pelanggan'>
                                                <img class="img-thumbnail" src="{{ url(Storage::url('gambar_redaman_rumah_pelanggan/'.$pemasangan_detail->gambar_redaman_rumah_pelanggan)) }}" id="preview_upload" itemprop="thumbnail" alt="Gambar Redaman Rumah Pelanggan"></a>
                                                @endif
                                                <label class="mt-2">Gambar Redaman Rumah Pelanggan</label>
                                            </div>

                                            <div class="col-md-6">
                                                @empty($pemasangan_detail->gambar_lainnya)
                                                <img class="img-thumbnail" src="{{ asset('assets/images/akagroup/image_empty.jpg') }}" id="preview_upload" itemprop="thumbnail" alt="Tidak ada gambar"></a>
                                                @else
                                                <a href="{{ url(Storage::url('gambar_lainnya/'.$pemasangan_detail->gambar_lainnya)) }}" data-fancybox data-caption='Gambar Lainnya'>
                                                <img class="img-thumbnail" src="{{ url(Storage::url('gambar_lainnya/'.$pemasangan_detail->gambar_lainnya)) }}" id="preview_upload" itemprop="thumbnail" alt="Gambar Lainnya"></a>
                                                @endif
                                                <label class="mt-2">Gambar Lainnya</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-12 col-md-12 box-col-12">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
    </div>
</div>

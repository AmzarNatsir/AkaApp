<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Data Pelanggan</h3>
    <form id="aktivasiForm" method="post" class="row g-3 needs-validation" novalidate="">
    @csrf
    <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="{{ $pelanggan->id }}">
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
                                                    <h6 class="f-w-600"> <a href="#">Pelanggan : {{ $pelanggan->nama_pelanggan }}</a>
                                                        <span class="pull-right"><i class="fa fa-calendar"></i> Post at : {{ $pemakaian_material->tanggal }}</span>
                                                    </h6>
                                                    <p><i class="fa fa-location-arrow"></i> {{ $pelanggan->alamat }} - {{ $pelanggan->getWilayah->wilayah }}<br>
                                                    <i class="fa fa-phone"></i> {{ $pelanggan->no_telepon_1 }}{{ (!empty($pelanggan->no_telepon_2)) ? " - ".$pelanggan->no_telepon_2 : "" }}<br>
                                                    <span><i class="fa fa-star font-warning"></i> Paket: {{ $pelanggan->getPaket->nama_paket }}</span></p>
                                                </div>
                                            </div>
                                            <p>Deskripsi : {{ $pemakaian_material->keterangan }}</p>
                                            <div class="project-meeting-details">
                                                <div class="project-meeting">
                                                    <span class="f-light f-12 f-w-500">Completed at</span>
                                                    <span class="f-light f-12 f-w-500">Activated at</span>
                                                </div>
                                                <div class="project-meeting-time">
                                                    <a class="f-14 f-w-500 " href="javascript:void(0)"><i class="fa fa-calendar"></i> {{ $pelanggan->tgl_completed }}</a>
                                                    <a class="f-14 f-w-500 " href="javascript:void(0)"><i class="fa fa-calendar"></i> {{ $pemasangan_detail->tgl_aktivasi }}</a>
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
                                                                            @if(empty($pemasangan_detail->gambar_rumah))
                                                                            Tidak ada<br>gambar
                                                                            @else
                                                                            <a href="{{ url(Storage::url('gambar_rumah/'.$pemasangan_detail->gambar_rumah)) }}" data-fancybox data-caption="Gambar Rumah">
                                                                                <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_rumah/'.$pemasangan_detail->gambar_rumah)) }}" alt="nft" style="width: 100px; height: auto;"></a>
                                                                            @endif
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
                                                                            @if(empty($pemasangan_detail->gambar_odp))
                                                                            Tidak ada<br>gambar
                                                                            @else
                                                                            <a href="{{ url(Storage::url('gambar_odp/'.$pemasangan_detail->gambar_odp)) }}" data-fancybox data-caption="Gambar ODP">
                                                                            <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_odp/'.$pemasangan_detail->gambar_odp)) }}" alt="nft" style="width: 100px; height: auto;"></a>
                                                                            @endif
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
                                                                            @if(empty($pemasangan_detail->gambar_ont_terpasang))
                                                                            Tidak ada<br>gambar
                                                                            @else
                                                                            <a href="{{ url(Storage::url('gambar_ont_terpasang/'.$pemasangan_detail->gambar_ont_terpasang)) }}" data-fancybox data-caption="Gambar ODP">
                                                                            <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_ont_terpasang/'.$pemasangan_detail->gambar_ont_terpasang)) }}" alt="nft" style="width: 100px; height: auto;"></a>
                                                                            @endif
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
                                                                            @if(empty($pemasangan_detail->gambar_redaman_odp))
                                                                            Tidak ada<br>gambar
                                                                            @else
                                                                            <a href="{{ url(Storage::url('gambar_redaman_odp/'.$pemasangan_detail->gambar_redaman_odp)) }}" data-fancybox data-caption="Gambar Redaman di ODP">
                                                                            <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_redaman_odp/'.$pemasangan_detail->gambar_redaman_odp)) }}" alt="nft" style="width: 100px; height: auto;"></a>
                                                                            @endif
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
                                                                            @if(empty($pemasangan_detail->gambar_redaman_rumah_pelanggan))
                                                                            Tidak ada<br>gambar
                                                                            @else
                                                                            <a href="{{ url(Storage::url('gambar_redaman_rumah_pelanggan/'.$pemasangan_detail->gambar_redaman_rumah_pelanggan)) }}" data-fancybox data-caption="Gambar Redaman Rumah Pelanggan">
                                                                            <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_redaman_rumah_pelanggan/'.$pemasangan_detail->gambar_redaman_rumah_pelanggan)) }}" alt="nft" style="width: 100px; height: auto;"></a>
                                                                            @endif
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
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
    </div>
    </form>
</div>

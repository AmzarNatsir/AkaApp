<div class="job-description mb-3">
    <h6>List Task Finished</h6>
    </div>
    <div class="todo">
        <div class="todo-list-wrapper theme-scrollbar">
            <div class="todo-list-container">
                <div class="todo-list-body">
                    <ul id="todo-list">
                        @foreach ($listTask as $r)
                        <li class="task">
                            <div class="card">
                                <div class="job-search">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <h6 class="f-w-600"> <a href="#">Pelanggan : {{ $r->nama_pelanggan }}</a>
                                                    <span class="pull-right"><i class="fa fa-calendar"></i> Post at : {{ $r->tanggal }}</span>
                                                </h6>
                                                <p><i class="fa fa-location-arrow"></i> {{ $r->alamat }} - {{ $r->wilayah }}</p>
                                                <p><i class="fa fa-phone"></i> {{ $r->no_telepon_1 }}{{ (!empty($r->no_telepon_2 )) ? " - ".$r->no_telepon_2 : "" }}</p>
                                                <p><span><i class="fa fa-star font-warning"></i> Paket: {{ $r->nama_paket }}</span></p>
                                            </div>
                                        </div>
                                        <p>Deskripsi : {{ $r->keterangan }}</p>
                                        <div class="project-meeting-details">
                                            <div class="project-meeting">
                                                <span class="f-light f-12 f-w-500">Completed at</span>
                                                <span class="f-light f-12 f-w-500">Finished at</span>
                                            </div>
                                            <div class="project-meeting-time">
                                                <a class="f-14 f-w-500 " href="javascript:void(0)"><i class="fa fa-calendar"></i> {{ $r->tgl_completed }}</a>
                                                <a class="f-14 f-w-500 " href="javascript:void(0)"><i class="fa fa-calendar"></i> {{ $r->tgl_finished }}</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xxl-6 col-md-6 box-col-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="collection-filter-block">
                                                            <ul class="pro-services">
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>Serian Number ONT :</h5>
                                                                    <p>{{ $r->sn_ont }}</p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>Model ONT :</h5>
                                                                    <p>{{ $r->model_ont }}</p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>ODP :</h5>
                                                                    <p>{{ $r->odp }}</p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>Titik Kordinat ODP :</h5>
                                                                    <p>{{ $r->tikor_odp }}</p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>Titik Kordinat Pelanggan :</h5>
                                                                    <p>{{ $r->tikor_pelanggan }}</p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>Port :</h5>
                                                                    <p>{{ $r->port }}</p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>Port Ifle :</h5>
                                                                    <p>{{ $r->port_ifle }}</p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>Splitter :</h5>
                                                                    <p>{{ $r->splitter }}</p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>Kabel DC :</h5>
                                                                    <p>{{ $r->kabel_dc }}</p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="media-body">
                                                                    <h5>Tanggal Aktivasi :</h5>
                                                                    <p>{{ $r->tgl_finished }}</p>
                                                                </div>
                                                            </li>
                                                            </ul>
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
                                                                        <a href="{{ url(Storage::url('gambar_rumah/'.$r->gambar_rumah )) }}" data-fancybox data-caption="Gambar Rumah">
                                                                        <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_rumah/'.$r->gambar_rumah )) }}" alt="nft" style="width: 100px; height: auto;"></a>
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
                                                                        <a href="{{ url(Storage::url('gambar_odp/'.$r->gambar_odp )) }}" data-fancybox data-caption="Gambar ODP">
                                                                        <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_odp/'.$r->gambar_odp )) }}" alt="nft" style="width: 100px; height: auto;"></a>
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
                                                                        <a href="{{ url(Storage::url('gambar_ont_terpasang/'.$r->gambar_ont_terpasang )) }}" data-fancybox data-caption="Gambar ODP">
                                                                        <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_ont_terpasang/'.$r->gambar_ont_terpasang )) }}" alt="nft" style="width: 100px; height: auto;"></a>
                                                                        <div>
                                                                        <a class="f-14 f-w-500 d-block" href="javascript:void(0)">Gambar ONT Terpasang</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-12 col-md-12 box-col-12">
                                                            <div class="projectlist-card">
                                                                <div class="projectlist">
                                                                    <div class="project-data">
                                                                        <a href="{{ url(Storage::url('gambar_redaman_odp/'.$r->gambar_redaman_odp )) }}" data-fancybox data-caption="Gambar Redaman di ODP">
                                                                        <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_redaman_odp/'.$r->gambar_redaman_odp )) }}" alt="nft" style="width: 100px; height: auto;"></a>
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
                                                                        <a href="{{ url(Storage::url('gambar_redaman_rumah_pelanggan/'.$r->gambar_redaman_rumah_pelanggan )) }}" data-fancybox data-caption="Gambar Redaman Rumah Pelanggan">
                                                                        <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_redaman_rumah_pelanggan/'.$r->gambar_redaman_rumah_pelanggan )) }}" alt="nft" style="width: 100px; height: auto;"></a>
                                                                        <div>
                                                                        <a class="f-14 f-w-500 d-block" href="javascript:void(0)">Gambar Redaman Rumah Pelanggan</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(!empty($r->gambar_lainnya))
                                                        <div class="col-xl-12 col-md-12 box-col-12">
                                                            <div class="projectlist-card">
                                                                <div class="projectlist">
                                                                    <div class="project-data">
                                                                        <a href="{{ url(Storage::url('gambar_lainnya/'.$r->gambar_lainnya )) }}" data-fancybox data-caption="Gambar Gambar Lainnya">
                                                                        <img class="nft-img img-fluid" src="{{ url(Storage::url('gambar_lainnya/'.$r->gambar_lainnya )) }}" alt="nft" style="width: 100px; height: auto;"></a>
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
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

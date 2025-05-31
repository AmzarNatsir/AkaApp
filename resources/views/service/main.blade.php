@extends('partial.mainApp')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>TO-DO List</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">
                        <svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg></a></li>
                    <li class="breadcrumb-item active">To-Do List</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid email-wrap bookmark-wrap todo-wrap">
    <div class="row">
        <div class="col-xxl-3 col-xl-4">
            <div class="email-sidebar md-sidebar"><a class="btn btn-primary email-aside-toggle md-sidebar-toggle">To Do filter</a>
                <div class="email-left-aside md-sidebar-aside">
                  <div class="card">
                    <div class="card-body">
                      <div class="email-app-sidebar left-bookmark custom-scrollbar">
                        <div class="d-flex align-items-center">
                            <div class="media-size-email">
                                @if(empty(auth()->user()->petugas->photo))
                                <img class="me-3 rounded-circle" src="../assets/images/user/user.png" alt="Avatar">
                                @else
                                <img class="me-3 rounded-circle" src="{{ url(Storage::url('petugas/'. auth()->user()->petugas->photo)) }}" style="width: 50px; height: auto" alt="Avatar">
                                @endif

                            </div>
                          <div class="flex-grow-1">
                            <h6 class="f-w-600">{{ auth()->user()->petugas->nama_petugas }}</h6>
                            <p>{{ auth()->user()->petugas->alamat }}</p>
                            <p>{{ auth()->user()->petugas->no_telpon }}</p>
                          </div>
                        </div>
                        <ul class="nav main-menu">
                          <li class="nav-item">
                            <button class="btn-primary badge-light d-block btn-mail w-100 txt-light"> <i class="me-2" data-feather="check-circle"></i>To Do List</button>
                          </li>
                          <li class="nav-item"> <a href="javascript:void(0)"><span class="iconbg badge-light-primary"><i data-feather="file-plus"></i></span><span class="title ms-2">All Task</span></a></li>
                          <li class="nav-item"><a href="javascript:void(0)" onclick="goAllTask()"><span class="iconbg badge-light"><i data-feather="activity"></i></span><span class="title ms-2">In Process</span><span class="badge rounded-pill badge-primary">{{ $onProses }}</span></a></li>
                          <li class="nav-item"><a href="javascript:void(0)" onclick="goListCompleted()"><span class="iconbg badge-light-info"><i data-feather="check-circle"></i></span><span class="title ms-2">Completed</span><span class="badge rounded-pill badge-info">{{ $onComplete }}</span></a></li>
                          <li class="nav-item"><a href="javascript:void(0)" onclick="goListFinished()"><span class="iconbg badge-light-success"><i data-feather="check-circle"></i></span><span class="title ms-2">Finished</span><span class="badge rounded-pill badge-success">{{ $onFinished }}</span></a></li>
                          <li class="nav-item"><a href="javascript:void(0)"><span class="iconbg badge-light-danger"><i data-feather="trash"></i></span><span class="title ms-2">Canceled</span><span class="badge rounded-pill badge-danger">{{ $onCancel }}</span></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-9 col-xl-8 box-col-12">
            <div class="card">
                <div class="card-body" id="page-area">
                    <div class="todo">
                        <div class="todo-list-wrapper theme-scrollbar">
                            <div class="todo-list-container">
                                <div class="todo-list-body">
                                    <ul id="todo-list">
                                        @if($newTask->count() == 0)
                                        <li class="task">
                                            <div class="card">
                                                <div class="job-search">
                                                    <div class="card-body text-center">
                                                        Empty Task!
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endif
                                        @foreach ($listTask as $r)
                                        <li class="task">
                                            <div class="card">
                                                <div class="job-search">
                                                    <div class="card-body">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <h6 class="f-w-600"> <a href="#">Pelanggan : {{ $r->nama_pelanggan }}</a>
                                                                    <span class="pull-right"><i class="fa fa-calendar"></i> Posting tanggal : {{ $r->tanggal }}</span>
                                                                </h6>
                                                                <p><i class="fa fa-location-arrow"></i> {{ $r['alamat'] }} - {{ $r->wilayah }}</p>
                                                                <p><i class="fa fa-phone"></i> {{ $r->no_telepon_1 }}{{ (!empty($r->no_telepon_2 )) ? " - ".$r->no_telepon_2 : "" }}</p>
                                                                <p><span><i class="fa fa-star font-warning"></i> Paket: {{ $r->nama_paket }}</span></p>
                                                            </div>
                                                        </div>
                                                        <p>Deskripsi : {{ $r->keterangan }}</p>
                                                        <hr>
                                                        <div class="common-flex">
                                                            <button type="button" class="btn btn-primary btn-sm pull-right" name="btnApplyToComplete" id="btnApplyToComplete" data-bs-toggle="modal" data-bs-target="#modalComplete" data-whatever="@getbootstrap" value="{{ $r->id }}" onclick="goFormComplete(this)">Apply to Complete</button>
                                                            <button type="button" class="btn btn-secondary btn-sm pull-right" name="btnApplyToComplete" id="btnApplyToComplete" data-bs-toggle="modal" data-bs-target="#modalMaterial" data-whatever="@getbootstrap" value="{{ $r->id }}" onclick="goCancelForm(this)">Apply to Cancel</button>
                                                            <button type="button" class="btn btn-success btn-sm pull-right" name="btnListMaterial" id="btnListMaterial" data-bs-toggle="modal" data-bs-target="#modalMaterial" data-whatever="@getbootstrap" value="{{ $r->id_pemakaian }}" onclick="getListMaterial(this)">List Material</button>
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
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalComplete" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="form_complete"></div>
    </div>
</div>
<div class="modal fade" id="modalMaterial" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="form_view"></div>
    </div>
</div>
<script>
    $(document).ready(function () {

    });
    var goAllTask = function()
    {
        location.reload();
    }
    var getListMaterial = function(el)
    {
        var idHead = $(el).val();
        $("#form_view").load("{{ url('service/getListMaterial') }}/"+idHead);
    }
    var goCancelForm = function(el)
    {
        var idPelanggan = $(el).val();
        $("#form_view").load("{{ url('service/goFormCacelTask') }}/"+idPelanggan, function() {
            $("#cancelForm").validate({
                rules: {
                    inpAlasan: {
                        required: true,
                    },
                },
                messages: {
                    inpAlasan: {
                        required: "Inputan keterangan pembatalan tidak boleh kosong",
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
        });
    }

    var goListCompleted = function()
    {
        $("#page-area").load("{{ route('service.listTaskCompleted') }}");
    }
    var goListFinished = function()
    {
        $("#page-area").load("{{ route('service.listTaskFinished') }}");
    }

    var goFormComplete = function(el)
    {
        var idPelanggan = $(el).val();
        $("#form_complete").load("{{ url('service/goFormComplete') }}/"+idPelanggan);
    }
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
</script>
@endsection

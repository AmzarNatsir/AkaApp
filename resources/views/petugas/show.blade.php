<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Detail Data Petugas</h3>
    <div class="modal-body">
        <form id="updateForm" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate="">
        @csrf
            <div class="col-md-12">
                <label class="form-label" for="inpNama">Nama Petugas</label>
                <input class="form-control" id="inpNama" name="inpNama" type="text" maxlength="100" value="{{ $res->nama_petugas }}"  disabled>
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="col-md-8">
                <label class="form-label" for="inpTempatLahir">Tempat Lahir</label>
                <input class="form-control" id="inpTempatLahir" name="inpTempatLahir" type="text" maxlength="100" value="{{ $res->tempat_lahir }}" disabled>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="inpTanggalLahir">Tanggal Lahir</label>
                <div class="input-group flatpicker-calender">
                    <input class="form-control" name="inpTanggalLahir" id="datetime-local" type="date" value="{{ $res->tanggal_lahir }}" disabled>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card-wrapper border rounded-3 checkbox-checked">
                    <label class="form-label" for="inpTanggalLahir">Jenis Kelamin</label>
                    <div class="form-check-size rtl-input">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input me-2" id="jenkel_1" type="radio" name="pilihanJenkel" value="Laki-Laki" {{ ($res->jenkel=="Laki-Laki") ? "checked" : "" }} disabled>
                            <label class="form-check-label" for="jenkel_1">Laki-Laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input me-2" id="jenkel_2" type="radio" name="pilihanJenkel" value="Perempuan" {{ ($res->jenkel=="Perempuan") ? "checked" : "" }} disabled>
                            <label class="form-check-label" for="jenkel_2">Perempuan</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpAlamat">Alamat</label>
                <input class="form-control" id="inpAlamat" name="inpAlamat" type="text" value="{{ $res->alamat }}" maxlength="100" disabled>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpNotel">No.Telepon</label>
                <input class="form-control" id="inpNotel" name="inpNotel" type="text" value="{{ $res->no_telepon }}" maxlength="20" disabled>
            </div>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <img class="img-thumbnail" src="{{ url(Storage::url('petugas/'.$res->photo)) }}" id="preview_upload" itemprop="thumbnail" alt="Image description">
                </div>
            </div>
            <hr>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
</script>

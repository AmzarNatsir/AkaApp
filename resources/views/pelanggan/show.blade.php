<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Detail Data Pelanggan</h3>
    <div class="modal-body">
        <form id="showForm" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate="">
        @csrf
            <div class="col-md-12">
                <label class="form-label" for="inpNama">Nama Pelanggan</label>
                <input class="form-control" id="inpNama" name="inpNama" type="text" value="{{ $res->nama_pelanggan }}"  disabled>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="inpAlamat">Alamat</label>
                <input class="form-control" id="inpAlamat" name="inpAlamat" type="text" value="{{ $res->alamat }}" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpNotel_1">No.Telepon 1</label>
                <input class="form-control" id="inpNotel_1" name="inpNotel_1" type="text" value="{{ $res->no_telepon_1 }}" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpNotel_2">No.Telepon 2</label>
                <input class="form-control" id="inpNotel_2" name="inpNotel_2" type="text" value="{{ $res->no_telepon_2 }}" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpWilayah">Wilayah</label>
                <input class="form-control" id="inpWilayah" name="inpWilayah" type="text" value="{{ (empty($res->wilayah)) ? "" : $res->getWilayah->wilayah }}" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpPaket">Paket</label>
                <input class="form-control" id="inpPaket" name="inpPaket" type="text" value="{{ (empty($res->paket_internet)) ? "" : $res->getPaket->nama_paket }}" disabled>
            </div>
            <hr>
            <div class="col-md-12">
                <label class="form-label" for="inpNamaSales">Nama Sales</label>
                <input class="form-control" id="inpNamaSales" name="inpNamaSales" type="text" maxlength="100" value="{{ $res->nama_sales }}" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpNotelSales">No. Telepon Sales</label>
                <input class="form-control" id="inpNotelSales" name="inpNotelSales" type="text" maxlength="100" value="{{ $res->no_telepon_sales }}" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpNorekSales">No. Rekening Bank</label>
                <input class="form-control" id="inpNorekSales" name="inpNorekSales" type="text" maxlength="100" value="{{ $res->no_rekening_sales }}" disabled>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpNamaBankSales">Nama Bank Sales</label>
                <input class="form-control" id="inpNamaBankSales" name="inpNamaBankSales" type="text" maxlength="100" value="{{ $res->nama_bank }}" disabled>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
</script>

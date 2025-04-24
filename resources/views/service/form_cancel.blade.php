<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Form Cancel Task</h3>
    <form id="cancelForm" method="post" class="theme-form needs-validation" novalidate="">
    @csrf
    <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="{{ $pelanggan->id }}">
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
                                <label class="form-label" for="inpAlasan">Keterangan Pembatalan:<span class="font-danger">*</span></label>
                                <textarea class="form-control" name="inpAlasan" id="inpAlasan" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="submit">Submit</button>
    </div>
</form>
</div>
<script>
    $(document).ready(function () {
        $('#cancelForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            let formData = new FormData(document.getElementById('cancelForm'));
            $.ajax({
                url: "{{ route('service.storeCanceledTask') }}", // Update this with your route
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

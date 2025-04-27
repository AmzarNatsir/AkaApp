<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Edit Data Voucher</h3>
    <div class="modal-body">
        <form id="updateForm" method="post" class="row g-3 needs-validation" novalidate="">
        <input type="hidden" name="id_data" id="id_data" value="{{ $res->id }}">
        @csrf
        {{ method_field('PUT') }}
            <div class="col-md-12">
                <label class="form-label" for="inpNama">Nama Voucher</label>
                <input class="form-control" id="inpNama" name="inpNama" type="text" value="{{ $res->nama_voucher }}" required="">
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpHargaModal">Harga Modal</label>
                <input class="form-control angka" id="inpHargaModal" name="inpHargaModal" type="text" value="{{ $res->harga_modal }}" style="text-align: right" required="">
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpHargaJual">Harga Jual</label>
                <input class="form-control angka" id="inpHargaJual" name="inpHargaJual" type="text" value="{{ $res->harga_jual }}" style="text-align: right" required="">
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Save changes</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".angka").number(true, 0);
        const forms = document.querySelectorAll(".needs-validation");
        Array.from(forms).forEach((form) => {
            form.addEventListener(
            "submit",
            (event) => {
                if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                }

                form.classList.add("was-validated");
            },
            false
            );
        });
        $('#updateForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            $.ajax({
                url: "{{ url('voucher/update') }}/"+$("#id_data").val(), // Update this with your route
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    if (response.success==true) {
                        $('#exampleModalgetbootstrap').modal('hide'); // Close modal
                        Swal.fire({
                            icon: 'success',
                            title: 'Good Job!',
                            text: response.message
                        });
                        $('#table_view').DataTable().ajax.reload(); // Refresh DataTable
                    } else {
                        return false;
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText); // Debugging errors
                    Swal.fire({
                        icon: 'error',
                        title: "It's danger!",
                        text: "Something went wrong! "+response.message
                    });
                }
            });
        });
    });
</script>

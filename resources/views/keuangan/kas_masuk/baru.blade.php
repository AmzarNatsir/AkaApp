<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Input Kas Masuk</h3>
    <div class="modal-body">
        <form id="createForm" method="post" class="row g-3 needs-validation" novalidate="">
        @csrf
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="inpTanggal">Tanggal Transaksi</label>
                    <input class="form-control" name="inpTanggal" id="inpTanggal" type="date" value="{{ date('Y-m-d') }}" readonly>
                    <div class="valid-feedback">Looks good!</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="inpNominal">Nominal</label>
                    <input class="form-control angka" id="inpNominal" name="inpNominal" type="text" value="0" style="text-align: right" required="" data-no-zero>
                    <div class="valid-feedback">Looks good!</div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label" for="inpKeterangan">Keterangan</label>
                    <input class="form-control" id="inpKeterangan" name="inpKeterangan" type="text" maxlength="150" required="">
                    <div class="valid-feedback">Looks good!</div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".angka").number(true, 0);
        flatpickr("#inpTanggal", {
            enableTime: false,
            dateFormat: "Y-m-d",
        });
        const forms = document.querySelectorAll(".needs-validation");
        Array.from(forms).forEach((form) => {
            form.addEventListener(
            "submit",
            (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                // Validasi tambahan: cek input yang tidak boleh bernilai 0
                const invalidZeroFields = form.querySelectorAll("[data-no-zero]");
                let hasZeroValue = false;
                invalidZeroFields.forEach((field) => {
                    if (field.value.trim() === "0") {
                        field.setCustomValidity("Nilai tidak boleh 0");
                        hasZeroValue = true;
                    } else {
                        field.setCustomValidity("");
                    }
                });

                if (hasZeroValue) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add("was-validated");
            },
            false
            );
        });
        $('#createForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            $.ajax({
                url: "{{ route('keuangan.kasMasuk.simpan') }}", // Update this with your route
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
                        $('#list_transaksi').DataTable().ajax.reload(); // Refresh DataTable
                    } else {
                        return false;
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText); // Debugging errors
                    $('#exampleModalgetbootstrap').modal('hide'); // Close modal
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

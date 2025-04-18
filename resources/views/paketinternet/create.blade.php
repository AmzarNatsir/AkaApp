<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Input Data Paket Internet</h3>
    <div class="modal-body">
        <form id="createForm" method="post" class="row g-3 needs-validation" novalidate="">
        @csrf
            <div class="col-md-12">
                <label class="form-label" for="inpNama">Nama Paket Internet</label>
                <input class="form-control" id="inpNama" name="inpNama" type="text" placeholder="Masukkan nama paket internet" required="">
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inpHarga">Harga (Rp.)</label>
                <input class="form-control angka" id="inpHarga" name="inpHarga" type="text" value="0" style="text-align: right" required="">
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
                // Validasi tambahan: cek input yang tidak boleh bernilai 0
                // const invalidZeroFields = form.querySelectorAll("[data-no-zero]");
                // let hasZeroValue = false;
                // invalidZeroFields.forEach((field) => {
                //     if (field.value.trim() === "0") {
                //         field.setCustomValidity("Nilai tidak boleh 0");
                //         hasZeroValue = true;
                //     } else {
                //         field.setCustomValidity("");
                //     }
                // });

                // if (hasZeroValue) {
                //     event.preventDefault();
                //     event.stopPropagation();
                // }

                form.classList.add("was-validated");
            },
            false
            );
        });
        $('#createForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            $.ajax({
                url: "{{ route('paket_internet.store') }}", // Update this with your route
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    if (response.success==true) {
                        // $('#exampleModalgetbootstrap').modal('hide'); // Close modal
                        $('#createForm')[0].reset(); // Reset form fields
                        swal("Good job!", response.message, "success");
                        $('#table_view').DataTable().ajax.reload(); // Refresh DataTable
                    } else {
                        return false;
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText); // Debugging errors
                    swal("It's danger", "Something went wrong!", "error");
                }
            });
        });
    });
</script>

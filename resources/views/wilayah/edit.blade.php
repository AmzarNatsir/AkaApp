<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Edit data wilayah</h3>
    <div class="modal-body">
        <form id="updateForm" method="post" class="row g-3 needs-validation" novalidate="">
        <input type="hidden" name="id_data" id="id_data" value="{{ $res->id }}">
        @csrf
        {{ method_field('PUT') }}
            <div class="col-md-12">
                <label class="form-label" for="inpNama">Nama wilayah</label>
                <input class="form-control" id="inpNama" name="inpNama" type="text" placeholder="Masukkan nama wilayah" value="{{ $res->wilayah }}" required="">
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
                url: "{{ url('wilayah/update') }}/"+$("#id_data").val(), // Update this with your route
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

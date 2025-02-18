<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Edit Data Agen Voucher</h3>
    <div class="modal-body">
        <form id="updateForm" method="post" class="row g-3 needs-validation" novalidate="">
        <input type="hidden" name="id_data" id="id_data" value="{{ $res->id }}">
        @csrf
        {{ method_field('PUT') }}
            <div class="col-md-12">
                <label class="form-label" for="inpNama">Nama Agen</label>
                <input class="form-control" id="inpNama" name="inpNama" type="text" value="{{ $res->nama_agen }}" required="" maxlength="100">
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpAlamat">Alamat</label>
                <input class="form-control" id="inpAlamat" name="inpAlamat" type="text" value="{{ $res->alamat }}" maxlength="100">
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpNotel">No.Telepon</label>
                <input class="form-control" id="inpNotel" name="inpNotel" type="text" value="{{ $res->no_telepon }}" maxlength="20">
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inpKontak">Kontak Person</label>
                <input class="form-control" id="inpKontak" name="inpKontak" type="text" value="{{ $res->kontak_person }}" maxlength="50">
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
                url: "{{ url('agen/update') }}/"+$("#id_data").val(), // Update this with your route
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    if (response.success==true) {
                        $('#exampleModalgetbootstrap').modal('hide'); // Close modal
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

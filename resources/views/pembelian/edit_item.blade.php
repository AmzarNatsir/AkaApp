<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Edit Item Pembelian</h3>
    <div class="modal-body">
        <form id="formEditItem" method="post" class="row g-3 needs-validation" novalidate="">
        @csrf
        {{ method_field('PUT') }}
            <input type="hidden" name="idHead" id="idHead" value="{{ $dataItem->header_id }}">
            <input type="hidden" name="idDetail" id="idDetail" value="{{ $dataItem->id }}">
            <div class="col-md-12">
                <label class="form-label" for="selectItem">Pilih Material</label>
                <input type="text" class="form-control" name="inpMaterial" id="inpMaterial" value="{{ $dataItem->getMaterial->material }}" readonly>
                <input type="hidden" name="material_id" id="material_id" value="{{ $dataItem->material_id }}">
            </div>
            <label class="col-md-6 text-start">Harga Beli (Rp.)</label>
            <div class="col-md-6">
                <input class="form-control angka" id="inpHarga" name="inpHarga" type="text" value="{{ $dataItem->harga }}" style="text-align: right" required="" oninput="getTotal()">
            </div>
            <label class="col-md-6 text-start">Jumlah</label>
            <div class="col-md-6">
                <input class="form-control angka" id="inpJumlah" name="inpJumlah" value="{{ $dataItem->jumlah }}" type="text" style="text-align: right" required="" oninput="getTotal()">
                <input type="hidden" name="jumlahOld" id="jumlahOld" value="{{ $dataItem->jumlah }}">
            </div>
            <label class="col-md-6 text-start">Sub Total  (Rp.)</label>
            <div class="col-md-6">
                <input class="form-control angka" id="inpSubTotal" name="inpSubTotal" value="{{ $dataItem->sub_total }}" type="text" style="text-align: right" required="" readonly>
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
        $('#formEditItem').submit(function (e) {
            var idHead = $("#idHead").val();
            e.preventDefault(); // Prevent default form submission
            $.ajax({
                url: "{{ url('pembelian/updateItem') }}/"+$("#idDetail").val(), // Update this with your route
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    if (response.success==true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Good Job!',
                            text: response.message
                        });
                        location.replace("{{ url('pembelian/addDetail') }}/"+idHead);
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
                        text: "Something went wrong! "+response.message
                    });
                }
            });
        });
    });
    var getTotal = function()
    {
        $("#inpSubTotal").val(calculate_total());
    }
    function calculate_total()
    {
        var harga = $("#inpHarga").val();
        var jumlah = $("#inpJumlah").val();
        var sub_total = harga * jumlah;
        return sub_total;
    }
</script>

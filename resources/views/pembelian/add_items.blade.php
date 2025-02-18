<div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
    <h3 class="modal-header justify-content-center border-0">Tambah Item Pembelian</h3>
    <div class="modal-body">
        <form id="formAddItem" method="post" class="row g-3 needs-validation" novalidate="">
        @csrf
            <input type="hidden" name="idHead" id="idHead" value="{{ $idHead }}">
            <input type="hidden" name="nilTotal" id="nilTotal" value="{{ $tempTotal }}">
            <div class="col-md-12">
                <label class="form-label" for="selectItem">Pilih Material</label>
                <select class="form-select select" id="selectItem" name="selectItem" required="">
                    <option selected="" disabled="" value="">Pilihan...</option>
                    @foreach ($listMaterial as $item)
                        <option value="{{ $item['id'] }}">{{ $item['material'] }}</option>
                    @endforeach
                </select>
                <div class="invalid-tooltip">Anda belum memilih item material</div>
            </div>
            <label class="col-md-6 text-start">Harga Beli (Rp.)</label>
            <div class="col-md-6">
                <input class="form-control angka" id="inpHarga" name="inpHarga" type="text" value="0" style="text-align: right" required="" oninput="getTotal()">
            </div>
            <label class="col-md-6 text-start">Jumlah</label>
            <div class="col-md-6">
                <input class="form-control angka" id="inpJumlah" name="inpJumlah" value="0" type="text" style="text-align: right" required="" oninput="getTotal()">
            </div>
            <label class="col-md-6 text-start">Sub Total  (Rp.)</label>
            <div class="col-md-6">
                <input class="form-control angka" id="inpSubTotal" name="inpSubTotal" value="0" type="text" style="text-align: right" required="" readonly>
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
        $('#formAddItem').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            $.ajax({
                url: "{{ route('pembelian.storeItem') }}", // Update this with your route
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    if (response.success==true) {
                        // $('#exampleModalgetbootstrap').modal('hide'); // Close modal
                        // $('#formAddItem')[0].reset(); // Reset form fields
                        hapus_inputan();
                        swal("Good job!", response.message, "success");
                        $('#view_items').DataTable().ajax.reload(); // Refresh DataTable
                        $("#inpTotal").val(response.dataTotal);
                    } else {
                        swal("It's danger", response.message, "error");
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
    function hapus_inputan()
    {
        $("#selectItem").val("");
        $("#inpHarga").val('0');
        $("#inpJumlah").val('0');
        $("#inpSubTotal").val('0');
    }
</script>

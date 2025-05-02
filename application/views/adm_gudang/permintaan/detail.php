<!-- Main content -->
<section class="content">
    <div id="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-row card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <li class="fa fa-file"></li> Proses Permintaan
                        </h3>
                        <div class="card-tools">
                            <a href="<?= base_url('adm_gudang/Permintaan') ?>" type="button" class="btn btn-tool">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Master -->
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <li class="fas fa-file"></li> <strong>Data PO</strong>
                                </h3>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Nomor PO :</label>
                                            <input type="text" class="form-control form-control-sm" name="no_permintaan" value="<?= $permintaan->id ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tujuan :</label>
                                            <input type="text" class="form-control form-control-sm" name="toko" value="<?= $permintaan->nama_toko ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Alamat :</label><br>
                                            <address>
                                                <small><?= $permintaan->alamat ?></small>
                                            </address>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="rincian">
                            <form action="<?= base_url('adm_gudang/Permintaan/kirim') ?>" method="post" id="form_po">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <li class="fas fa-list"></li> <strong>List Artikel</strong>
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th rowspan="2" style="width: 20px;">No</th>
                                                        <th rowspan="2" style="width: 45%;">Artikel</th>
                                                        <th colspan="2">Jumlah</th>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th>Diminta</th>
                                                        <th style="width: 20%;">Dikirim</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 0;
                                                    $total_minta = 0;
                                                    $total_kirim = 0;
                                                    foreach ($detail as $d) :
                                                        $no++;
                                                        if ($d->het == 1) {
                                                            $harga = $d->harga_jawa;
                                                        } else {
                                                            $harga = $d->harga_indobarat;
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?= $no ?></td>
                                                            <td>
                                                                <small>
                                                                    <strong><?= $d->kode ?></strong> <br>
                                                                    <?= $d->nama_produk ?>
                                                                </small>
                                                            </td>
                                                            <td class="text-center"><?= $d->qty_acc ?></td>
                                                            <td class="text-center">
                                                                <input type="hidden" class="form-control" name="id_permintaan" value="<?= $d->id_permintaan ?>">
                                                                <input type="hidden" class="form-control" name="id_toko" value="<?= $d->id_toko ?>">
                                                                <input type="hidden" class="form-control" name="id_detail[]" value="<?= $d->id ?>">
                                                                <input type="hidden" class="form-control" name="id_produk[]" value="<?= $d->id_produk ?>">
                                                                <input type="number" class="form-control form-control-sm" name="qty_input[]" min="0" value="<?= $d->qty_acc ?>" max="<?= $d->qty_acc ?>" required>
                                                                <input type="hidden" name="hrg[]" class="form-control form-control-sm text-right" value="Rp <?= number_format($harga, 0, ',', '.') ?>" readonly>
                                                                <input type="hidden" name="total[]" class="form-control form-control-sm text-right" value="<?= number_format($d->qty_acc * $harga) ?>" readonly>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        $total_minta += $d->qty_acc;
                                                    endforeach;
                                                    ?>
                                                    <tr>
                                                        <td colspan="2" class="text-right">Total :</td>
                                                        <td class="text-center"><?= $total_minta ?></td>
                                                        <td class="text-center"> <span id="total_kirim"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-center">
                                                            <strong>Grand Total : <div id="grandTotal"></div></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <b>Perhatian :</b>
                                            <li>Jika ada artikel yang kosong, silahkan input dengan jumlah 0 (nol).</li>
                                            <li>Jika Total pengiriman masih minor dan perlu tambah artikel baru, silahkan hubungi MV untuk edit data.</li>
                                            <li>Sebelum di simpan, pastikan data sudah benar. karena jika sudah di simpan maka data tidak bisa di perbarui lagi.</li>
                                            <hr>
                                            <div class="form-group">
                                                <strong>Catatan :</strong> <br>
                                                <textarea name="catatan" class="form-control form-control-sm" placeholder="cth: ada 8 koli/box/karung" required></textarea>
                                                <small>Wajib di isi | untuk keterangan jumlah packing</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer " id="footer">
                                        <div class="float-right">
                                            <a href="<?= base_url('adm_gudang/Permintaan') ?>" class="btn btn-sm btn-danger">
                                                <li class="fa fa-times-circle"></li> Tutup
                                            </a>
                                            <button type="submit" class="btn btn-sm btn-success" id="btn_simpan">
                                                <li class="fa fa-save"></li> Simpan
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fungsi untuk memformat angka ke format Rupiah
        function formatRupiah(angka) {
            return `Rp ${angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;
        }

        // Fungsi untuk menghitung dan memperbarui total serta jumlah kirim
        function updateTotalsAndKirim() {
            var grandTotal = 0;
            var totalKirim = 0;

            qtyAccInputs.forEach(function(input) {
                var maxQty = parseInt(input.getAttribute('max'), 10);
                var value = parseInt(input.value, 10) || 0;

                // Pengecekan jika qty_input melebihi max
                if (value > maxQty) {
                    Swal.fire(
                        'Peringatan !',
                        'Jumlah tidak boleh melebihi maksimum di minta.',
                        'info'
                    );
                    input.value = maxQty;
                    value = maxQty;
                }

                totalKirim += value;

                var parentRow = input.closest("tr");
                var hrgProdukValue = parseInt(parentRow.querySelector('input[name="hrg[]"]').value.replace(/\D/g, ''), 10) || 0;
                var total = value * hrgProdukValue;
                parentRow.querySelector('input[name="total[]"]').value = formatRupiah(total);

                grandTotal += total;
            });

            grandTotalElement.textContent = formatRupiah(grandTotal);
            totalKirimElement.textContent = totalKirim;
        }

        var qtyAccInputs = document.querySelectorAll('input[name="qty_input[]"]');
        var grandTotalElement = document.getElementById("grandTotal");
        var totalKirimElement = document.getElementById("total_kirim");

        qtyAccInputs.forEach(function(input) {
            input.addEventListener("input", updateTotalsAndKirim);
        });

        // Inisialisasi pertama kali
        updateTotalsAndKirim();
    });
</script>
<script>
    $(document).ready(function() {
        function validateForm() {
            let isValid = true;
            // Get all required input fields
            $('#form_po').find('input[required], select[required], textarea[required]').each(function() {
                if ($(this).val() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            return isValid;
        }
        $("#btn_simpan").click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data Permintaan akan di proses dan di buatkan DO .",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Yakin'
            }).then((result) => {
                if (result.isConfirmed) {

                    if (validateForm()) {
                        document.getElementById("form_po").submit();
                    } else {
                        Swal.fire({
                            title: 'Belum Lengkap',
                            text: ' Semua kolom  harus di isi.',
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            })
        })
    });
</script>
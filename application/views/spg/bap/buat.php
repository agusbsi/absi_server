<style>
    .judul {
        display: flex;
        justify-content: space-between;
        background-color: #17a2b8;
        color: #f4f6f9;
        padding: 2px 10px 2px 10px;
        border-radius: 10px;
        align-items: center;
        margin-bottom: 20px;
    }

    .cardArtikel {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        margin-bottom: 20px;
        padding: 10px;
    }

    .cardArtikel strong {
        font-size: 16px;
        font-weight: bold;
        display: block;
    }

    .cardArtikel small {
        margin-bottom: 10px;
        display: block;
    }

    .perbaikan {
        display: flex;
        justify-content: flex-start;
        gap: 20px;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <form action="<?= base_url('spg/Bap/kirim') ?>" method="post" id="form_bap">
            <div class="judul">
                <div>
                    <input type="hidden" name="id_kirim" value="<?= $bap->id ?>">
                    <input type="hidden" name="unique_id" value="<?= uniqid() ?>">
                    <strong>Nomor : <?= $bap->id ?></strong> <br>
                    <small><?= date('d M Y', strtotime($bap->created_at)) ?></small>
                </div>
                <div class="card-tools">
                    <a href="<?= base_url('spg/Bap') ?>" type="button" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <?php $no = 0;
            foreach ($detail as $d): $no++; ?>
                <div class="cardArtikel">
                    <strong><?= $no ?> | <?= $d->kode ?></strong>
                    <small><?= $d->artikel ?></small>
                    <input type="hidden" name="id_produk[]" value="<?= $d->id_produk ?>">
                    <div class="form-group mt-1">
                        <label>Kategori : *</label>
                        <select name="kategori[]" class="form-control form-control-sm select2 kategori" required>
                            <option value=""> Pilih kategori </option>
                            <option value="Perbaikan QTY diterima"> Perbaikan QTY diterima</option>
                            <option value="Artikel tidak di kirim"> Artikel tidak di kirim </option>
                        </select>
                    </div>
                    <div class="perbaikan">
                        <div class="form-group">
                            <strong>Di kirim</strong>
                            <input type="text" name="qty_kirim[]" class="form-control form-control-sm" value="<?= $d->qty ?>" readonly>
                        </div>
                        <div class="form-group">
                            <strong>Di Terima</strong>
                            <input type="text" name="qty_terima[]" class="form-control form-control-sm" value="<?= $d->qty_diterima ?>" readonly>
                        </div>
                        <div class="form-group">
                            <strong>Di Update *</strong>
                            <input type="number" name="qty_update[]" class="form-control form-control-sm qty_update" required>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <strong>Catatan : *</strong>
                        <textarea name="catatan[]" class="form-control form-control-sm" required></textarea>
                        <small>* Harus di isi.</small>
                    </div>
                </div>
            <?php endforeach ?>
            <hr>
            <div class="card-footer text-right">
                <a href="<?= base_url('spg/Bap/selisih') ?>" class="btn btn-sm btn-danger"><i class="fas fa-arrow-left"></i> Close</a>
                <button type="submit" class="btn btn-sm btn-info" id="btn_kirim"><i class="fas fa-paper-plane"></i> Kirim</button>
            </div>
        </form>
    </div>
</section>
<script>
    $(document).ready(function() {
        $('.kategori').on('change', function() {
            var selectedValue = $(this).val();
            var $qtyUpdate = $(this).closest('.cardArtikel').find('.qty_update');
            if (selectedValue == 'Artikel tidak di kirim') {
                $qtyUpdate.val(0).attr('readonly', true);
            } else {
                $qtyUpdate.val('').attr('readonly', false);
            }
        });
    });
</script>
<script>
    function validateForm() {
        let isValid = true;
        $('#form_bap').find('input[required], select[required], textarea[required]').each(function() {
            if ($(this).val() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        return isValid;
    }
    document.getElementById("btn_kirim").addEventListener("click", function(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data Pengajuan BAP akan dikirim",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Yakin'
        }).then((result) => {
            if (result.isConfirmed) {
                if (validateForm()) {
                    document.getElementById("form_bap").submit();
                } else {
                    Swal.fire({
                        title: 'Belum lengkap',
                        text: "Kategori & Semua kolom harus di isi.",
                        icon: 'info',
                    });
                }

            }
        })
    });
</script>
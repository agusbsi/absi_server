<style>
    .artikel-container {
        width: 100%;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .artikel-container h2 {
        font-size: 20px;
        color: #1a2c53;
        margin-bottom: 15px;
    }

    .judul {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .total {
        text-align: end;
    }

    .area-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .artikel-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .artikel-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .artikel-number {
        font-size: 14px;
        font-weight: bold;
        color: #1a2c53;
        margin-right: 10px;
    }

    .artikel-content {
        flex: 1;
    }

    .artikel-title {
        font-size: 14px;
        font-weight: bold;
        color: #1a2c53;
        margin: 0;
    }

    .artikel-description {
        font-size: 12px;
        color: #6c757d;
        margin: 1px 0 0 0;
    }

    .artikel-quantity {
        font-size: 14px;
        font-weight: bold;
        color: #1a2c53;
    }

    .artikel-quantity input {
        width: 100px;
        border-radius: 5px;
    }

    .is-invalid {
        border: 2px solid #dc3545;
        background-color: rgb(244, 134, 143, 0.2);
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="callout callout-info">
            <div class="row">
                <div class="col-6">
                    <small><i class="fas fa-store"></i> <strong><?= $so->id; ?></strong></small>
                </div>
                <div class="col-6">
                    <small>
                        <i class="fas fa-calendar"></i> Tgl SO : <?= date('d M Y', strtotime($so->tgl_so)) ?>
                    </small>
                </div>
            </div>
        </div>
        <form action="<?= base_url('spg/Stok_opname/update_so') ?>" method="post" id="form_update">
            <input type="hidden" name="id_so" value="<?= $so->id ?>">
            <div class="artikel-container">
                <div class="judul">
                    <h2>Detail Artikel</h2>
                    <h2>
                        Hasil SO
                    </h2>
                </div>
                <ul class="artikel-list">
                    <?php
                    $no = 0;
                    $total = 0;
                    foreach ($detail as $d):
                        $no++;
                    ?>
                        <li class="artikel-item">
                            <span class="artikel-number"><?= $no ?></span>
                            <div class="artikel-content">
                                <p class="artikel-title"><?= $d->kode ?></p>
                                <p class="artikel-description"><?= $d->artikel ?></p>
                            </div>
                            <span class="artikel-quantity">
                                <?php if ($aksi == 'edit') { ?>
                                    <input type="hidden" name="id_detail[]" value="<?= $d->id ?>" required>
                                    <input type="number" name="qty[]" class="qty_input" autocomplete="off" value="<?= $d->hasil_so ?>">
                                <?php } else { ?>
                                    <?= $d->hasil_so ?>
                                <?php } ?>
                            </span>
                        </li>
                    <?php
                        $total += $d->hasil_so;
                    endforeach ?>
                    <div class="total">
                        <strong>Total: <span id="total"><?= $total ?></span></strong>
                    </div>
                </ul>
            </div>
            <hr>
            <div class="area-footer">
                <a href="<?= base_url('spg/Stok_opname') ?>" class="btn btn-sm btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                <?php if ($aksi == 'edit') { ?>
                    <button type="submit" class="btn btn-sm btn-primary" id="btn_update" title="Simpan"><i class="fas fa-save"></i> Simpan</button>
                <?php } ?>
            </div>
        </form>
        <hr>
    </div>
</section>
<script>
    function validateForm() {
        let isValid = true;
        $('#form_update').find('.qty_input').each(function() {
            if ($(this).val() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        return isValid;
    }
    $('#btn_update').click(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin ?',
            text: " Data Stok opname artikel akan di perbarui.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Yakin'
        }).then((result) => {
            if (result.isConfirmed) {
                if (validateForm()) {
                    document.getElementById("form_update").submit();
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Belum Lengkap',
                        text: 'Kolom Hasil So tidak boleh kosong.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            }
        })
    })
</script>
<script>
    function updateTotal() {
        const qtyInputs = document.querySelectorAll('.qty_input');
        let total = 0;
        qtyInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });
        document.getElementById('total').textContent = total;
    }
    document.querySelectorAll('.qty_input').forEach(input => {
        input.addEventListener('input', updateTotal);
    });
</script>
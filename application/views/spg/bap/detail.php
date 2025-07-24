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
        <div class="judul">
            <div>
                <strong><?= $bap->nomor ? $bap->nomor : "-" ?></strong> <br>
                <?= status_bap($bap->status) ?>
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
                <div class="form-group mt-1">
                    <input type="text" class="form-control form-control-sm" value="<?= $d->kategori ?>" readonly>
                </div>
                <div class="perbaikan">
                    <div class="form-group">
                        <strong>Di kirim</strong>
                        <input type="text" name="qty_kirim[]" class="form-control form-control-sm" value="<?= $d->qty_kirim ?>" readonly>
                    </div>
                    <div class="form-group">
                        <strong>Di Terima</strong>
                        <input type="text" name="qty_terima[]" class="form-control form-control-sm" value="<?= $d->qty_awal ?>" readonly>
                    </div>
                    <div class="form-group">
                        <strong>Di Update</strong>
                        <input type="number" name="qty_update[]" class="form-control form-control-sm qty_update" value="<?= $d->qty_update ?>" readonly>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <strong>Catatan :</strong>
                    <textarea name="catatan[]" class="form-control form-control-sm" readonly><?= $d->catatan ?></textarea>
                </div>
            </div>
        <?php endforeach ?>
        <hr>
        # Proses Pengajuan :
        <hr>
        <div class="timeline">
            <?php $no = 0;
            foreach ($histori as $h) :
                $no++;
            ?>
                <div>
                    <i class="fas bg-blue"><?= $no ?></i>
                    <div class="timeline-item">
                        <span class="time"></span>
                        <p class="timeline-header"><small><?= $h->aksi ?> <strong><?= $h->pembuat ?></strong></small></p>
                        <div class="timeline-body">
                            <small>
                                <?= date('d-M-Y  H:i:s', strtotime($h->tanggal)) ?> <br>
                                Catatan :<br>
                                <?= $h->catatan ?>
                            </small>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
<style>
    .box {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        margin-bottom: 20px;
        padding: 10px;
    }

    .box-header {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid rgba(0, 123, 255, 1);
        margin-bottom: 5px;
    }

    .box-body h5 {
        margin: 0;
        font-size: 13px;
        font-weight: bold;
    }

    .box-body small {
        display: block;
    }

    .tombol {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        font-size: 14px;
    }

    .tombol a {
        border-radius: 15px;
        padding: 2px 10px 2px 10px;
        color: #ffffff;
        background-color: #38ae53;
    }

    .tombol a:hover {
        background-color: rgb(0, 123, 255);
        color: white;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                Data BAP
                <div class="card-tools">
                    <a href="<?= base_url('spg/Dashboard') ?>" type="button" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <small style="display: block;">Berikut list Pengiriman yang selisih, segera buat BAP untuk memperbaiki datanya.</small>
                <hr>
                <div id="bap-list">
                    <?php foreach ($bap as $row): ?>
                        <div class="box">
                            <div class="box-header">
                                <strong><?= $row->id ?></strong>
                                <small><?= date('d M Y', strtotime($row->created_at)) ?></small>
                            </div>
                            <div class="box-body">
                                <h5><?= (empty($row->id_bap)) ? 'Status Kirim :' : 'Status BAP :' ?></h5> <?= (empty($row->id_bap)) ? status_pengiriman($row->status) : status_bap($row->status_bap) ?>
                            </div>
                            <div class="tombol">
                                <?php
                                if (empty($row->id_bap)) { ?>
                                    <a href="<?= base_url('spg/Bap/buat/' . $row->id) ?>">Buat BAP</a>
                                <?php } else if ($row->status_bap == 4) { ?>
                                    <a href="<?= base_url('spg/Bap/buat/' . $row->id) ?>">Ajukan Ulang</a>
                                    <a href="<?= base_url('spg/Bap/detail/' . $row->id_bap) ?>">Detail</a>
                                <?php } else { ?>
                                    <a href="<?= base_url('spg/Bap/detail/' . $row->id_bap) ?>">Detail</a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
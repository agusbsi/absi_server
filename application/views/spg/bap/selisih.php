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
                List data selisih
                <div class="card-tools">
                    <a href="<?= base_url('spg/Dashboard') ?>" type="button" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <small style="display: block;">Berikut list data Pengiriman yang selisih, segera buat BAP untuk memperbaiki datanya.</small>
                <hr>
                <div id="bap-list">
                    <?php if (empty($bap)): ?>
                        <div class="alert alert-info text-center">Tidak ada data yang selisih.</div>
                    <?php else: ?>
                        <?php $no = 0;
                        foreach ($bap as $row): $no++; ?>
                            <div class="box">
                                <div class="box-header">
                                    <strong><?= $no ?> | <?= $row->id ?></strong>
                                    <small><?= date('d M Y', strtotime($row->created_at)) ?></small>
                                </div>
                                <div class="box-body">
                                    <h5>Status pengiriman :</h5>
                                    <h5><?= status_pengiriman($row->status) ?></h5>
                                </div>
                                <div class="tombol">
                                    <a href="<?= base_url('spg/Bap/buat/' . $row->id) ?>">Buat BAP</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>
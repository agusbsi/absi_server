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
        background-color: #0aaefaff;
    }

    .tombol a:hover {
        background-color: rgba(4, 50, 99, 1);
        color: white;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                List Data BAP (Berita Acara Pengiriman)
                <div class="card-tools">
                    <a href="<?= base_url('spg/Dashboard') ?>" type="button" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <small style="display: block;">Berikut list data BAP yang pernah anda buat.</small>
                <hr>
                <div id="bap-list">
                    <?php foreach ($bap as $row): ?>
                        <div class="box">
                            <div class="box-header">
                                <strong><?= $row->nomor ? $row->nomor : "-" ?></strong>
                                <small><?= date('d M Y', strtotime($row->created_at)) ?></small>
                            </div>
                            <div class="box-body">
                                <h5>Nomor Kirim : <?= $row->id_kirim ?></h5>
                                <h5>Status :</h5>
                                <h5><?= status_bap($row->status) ?></h5>
                            </div>
                            <div class="tombol">
                                <a href="<?= base_url('spg/Bap/detail/' . $row->id) ?>">Detail</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
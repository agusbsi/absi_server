<style>
  .nomor {
    position: absolute;
    transform: translate(-250%, 10%);
    font-weight: bold;
  }

  .list {
    padding: 0;
    margin: 0;
    list-style: none;
  }

  .list-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #ddd;
    padding: 10px;
  }

  .list-item:last-child {
    border-bottom: none;
  }

  .number {
    background-color: #e8f5e9;
    color: #34a853;
    font-size: 20px;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-weight: bold;
  }

  .details {
    flex-grow: 1;
    margin-left: 10px;
  }

  .details h4 {
    margin: 0;
    font-size: 16px;
    font-weight: bold;
  }

  .details span {
    font-size: 14px;
    color: gray;
  }

  .amount {
    text-align: right;
    font-size: 16px;
    font-weight: bold;
  }

  .amount .percentage {
    font-size: 14px;
    font-weight: bold;
  }

  .amount span {
    color: gray;
    font-size: 12px;
    font-weight: normal;
  }
</style>
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-4">
            <img src="<?= base_url('assets/img/saran.svg') ?>" alt="dashboard" class="img-dashboard">
          </div>
          <div class="col-lg-8">
            <div class="konten text-left">
              <h2>Hallo.. <?= $this->session->userdata('nama_user') ?>,</h2>
              <p>Selamat datang di Dahboard <a href="#">Staff HRD.</a> <br>
                anda bisa menggunakan aplikasi ABSI ini untuk mempermudah pekerjaan anda.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- box master -->
    <div class="row">
      <?php foreach ($box as $info_box) : ?>
        <div class="col-lg-3 col-6">
          <div class="small-box <?= $info_box->box ?>">
            <div class="inner">
              <h3 class="count">
                <?= ($info_box->total == 0) ? "Kosong" : number_format($info_box->total) ?>
              </h3>
              <p><?= $info_box->title; ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-<?= $info_box->icon ?>"></i>
            </div>
            <a href="#" class="small-box-footer">

            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <!-- list update stok opname -->
    <div class="row">
      <div class="col-md-6">
        <div class="card card-danger">
          <div class="card-header text-center">
            <strong> List Toko belum update laporan Aset</strong>
            <div class="mt-2">
              <span class="badge badge-warning" style="font-size: 14px; padding: 6px 12px;">
                Total: <?php echo is_array($so_aset) ? count($so_aset) : 0; ?> Toko
              </span>
            </div>
          </div>
          <div class="card-body" style="max-height: 400px; overflow-y: auto; padding: 0;">
            <ul class="list" style="margin: 0; padding: 15px;">
              <?php if (is_array($so_aset)) { ?>
                <?php
                $no = 0;
                foreach ($so_aset as $dd) :
                  $no++;
                ?>
                  <li class="list-item" style="display: flex; align-items: center; padding: 10px 0; border-bottom: 1px solid #f0f0f0;">
                    <div class="number" style="width: 30px; height: 30px; background: #28a745; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-weight: bold; font-size: 14px;"><?= $no ?></div>
                    <div class="details" style="flex: 1;">
                      <h4 style="margin: 0 0 5px 0; font-size: 16px; font-weight: 600; color: #333;"><?= $dd->nama_toko ?></h4>
                      <span style="color: #666; font-size: 14px;"><?= $dd->spg ? $dd->spg : "- tanpa spg -" ?></span>
                    </div>
                  </li>
                <?php endforeach; ?>
              <?php } else { ?>
                <li style="text-align: center; padding: 40px 20px; color: #999;">
                  <i class="fas fa-check-circle" style="font-size: 48px; color: #28a745; margin-bottom: 10px; display: block;"></i>
                  <span style="font-size: 16px; font-weight: 500;">Semua Toko Sudah Update</span>
                  <br>
                  <small style="color: #666; margin-top: 5px; display: block;">Tidak ada toko yang perlu update laporan aset</small>
                </li>
              <?php } ?>
            </ul>
          </div>
          <div class="card-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6;">
            <div class="row">
              <div class="col-md-6">
                <small>* Periode So Aset : <?= date('M-Y') ?></small>
              </div>
              <div class="col-md-6 text-right">
                <small class="text-muted">
                  <?php if (is_array($so_aset) && count($so_aset) > 0): ?>
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    <?= count($so_aset) ?> toko perlu update
                  <?php else: ?>
                    <i class="fas fa-check-circle text-success"></i>
                    Semua toko sudah update
                  <?php endif; ?>
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card card-danger">
          <div class="card-header text-center">
            <strong> List Toko belum update SO artikel</strong>
            <div class="mt-2">
              <span class="badge badge-warning" style="font-size: 14px; padding: 6px 12px;">
                Total: <?php echo is_array($so_artikel) ? count($so_artikel) : 0; ?> Toko
              </span>
            </div>
          </div>
          <div class="card-body" style="max-height: 400px; overflow-y: auto; padding: 0;">
            <ul class="list" style="margin: 0; padding: 15px;">
              <?php if (is_array($so_artikel)) { ?>
                <?php
                $no = 0;
                foreach ($so_artikel as $dd) :
                  $no++;
                ?>
                  <li class="list-item" style="display: flex; align-items: center; padding: 10px 0; border-bottom: 1px solid #f0f0f0;">
                    <div class="number" style="width: 30px; height: 30px; background: #28a745; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-weight: bold; font-size: 14px;"><?= $no ?></div>
                    <div class="details" style="flex: 1;">
                      <h4 style="margin: 0 0 5px 0; font-size: 16px; font-weight: 600; color: #333;"><?= $dd->nama_toko ?></h4>
                      <span style="color: #666; font-size: 14px;"><?= $dd->spg ? $dd->spg : "- tanpa spg -" ?></span>
                    </div>
                  </li>
                <?php endforeach; ?>
              <?php } else { ?>
                <li style="text-align: center; padding: 40px 20px; color: #999;">
                  <i class="fas fa-check-circle" style="font-size: 48px; color: #28a745; margin-bottom: 10px; display: block;"></i>
                  <span style="font-size: 16px; font-weight: 500;">Semua Toko Sudah Update</span>
                  <br>
                  <small style="color: #666; margin-top: 5px; display: block;">Tidak ada toko yang perlu update laporan aset</small>
                </li>
              <?php } ?>
            </ul>
          </div>
          <div class="card-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6;">
            <div class="row">
              <div class="col-md-6">
                <small>* Periode So Artikel : <?= date('M-Y', strtotime('last month')) ?></small>
              </div>
              <div class="col-md-6 text-right">
                <small class="text-muted">
                  <?php if (is_array($so_artikel) && count($so_artikel) > 0): ?>
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    <?= count($so_artikel) ?> toko perlu update
                  <?php else: ?>
                    <i class="fas fa-check-circle text-success"></i>
                    Semua toko sudah update
                  <?php endif; ?>
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
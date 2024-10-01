<!-- Small boxes (Stat box) -->
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
              <p>Selamat datang di Dahboard <a href="#">Admin Gudang.</a> <br>
                anda bisa menggunakan aplikasi ABSI ini untuk mempermudah pekerjaan anda.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <?php foreach ($box as $info_box) : ?>
        <div class="col-md-6">
          <div class="small-box <?= $info_box->box ?>">
            <div class="inner">

              <h3 class="count">
                <?php if (($info_box->total) == 0) {
                  echo "kosong";
                } else {
                  echo number_format($info_box->total);
                }
                ?>
              </h3>
              <p><?= $info_box->title; ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-<?= $info_box->icon ?>"></i>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="callout callout-danger">
      <p> Data Transaksi Bulan : <b><?= date('M-Y') ?></b> </p>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="info-box bg-gradient-warning">
          <span class="info-box-icon"><i class="fas fa-file"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Data PO Barang</span>
            <strong><?= ($t_minta->total == 0) ? "Kosong" : number_format($t_minta->total) . " PO" ?></strong>
            <div class="progress">
              <div class="progress-bar" style="width: 100%"></div>
            </div>
            <a href="<?= base_url('adm_gudang/Permintaan') ?>" class="text-right text-white">Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box bg-gradient-info">
          <span class="info-box-icon"><i class="fas fa-truck"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Data Artikel Terkirim</span>
            <strong><?= ($t_kirim->total == 0) ? "Kosong" : number_format($t_kirim->total) . " Artikel" ?></strong>
            <div class="progress">
              <div class="progress-bar" style="width: 100%"></div>
            </div>
            <a href="<?= base_url('adm_gudang/Pengiriman') ?>" class="text-right text-white">Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box bg-gradient-danger">
          <span class="info-box-icon"><i class="fas fa-exchange-alt"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Data Retur</span>
            <strong><?= ($t_retur->total == 0) ? "Kosong" : number_format($t_retur->total) . " Retur" ?></strong>
            <div class="progress">
              <div class="progress-bar" style="width: 100%"></div>
            </div>
            <a href="<?= base_url('adm_gudang/Retur') ?>" class="text-right text-white">Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end boxes -->
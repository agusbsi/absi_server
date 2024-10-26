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
              <p>Selamat datang di Dahboard <a href="#"><?= ($this->session->userdata('role') == 17) ? 'Manager Operasional' : 'Staff Operasional' ?></a> <br>
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
            <a href="<?= base_url() . strtolower($info_box->link); ?>" class="small-box-footer">
              Lihat Data
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="callout callout-danger">
      <p> Data Transaksi Bulan ini ( <b><?= date('M-Y') ?></b> )</p>
    </div>
    <!-- box transaksi -->
    <div class="row">
      <div class="col-md-6">
        <div class="info-box bg-gradient-warning">
          <span class="info-box-icon"><i class="fas fa-list-alt"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Data Permintaan</span>
            <strong><?= ($t_minta->total == 0) ? "Kosong" : number_format($t_minta->total) . " Artikel" ?></strong>
            <div class="progress">
              <div class="progress-bar" style="width: 100%"></div>
            </div>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-6">
        <div class="info-box bg-gradient-info">
          <span class="info-box-icon"><i class="fas fa-truck"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Data Pengiriman</span>
            <strong><?= ($t_kirim->total == 0) ? "Kosong" : number_format($t_kirim->total) . " Artikel" ?></strong>
            <div class="progress">
              <div class="progress-bar" style="width: 100%"></div>
            </div>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-6">
        <div class="info-box bg-gradient-success">
          <span class="info-box-icon"><i class="fas fa-cart-plus"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Data Penjualan</span>
            <strong><?= ($t_jual->total == 0) ? "Kosong" : number_format($t_jual->total) . " Artikel" ?></strong>
            <div class="progress">
              <div class="progress-bar" style="width: 100%"></div>
            </div>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-6">
        <div class="info-box bg-gradient-danger">
          <span class="info-box-icon"><i class="fas fa-exchange-alt"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Data Retur</span>
            <strong><?= ($t_retur->total == 0) ? "Kosong" : number_format($t_retur->total) . " Artikel" ?></strong>
            <div class="progress">
              <div class="progress-bar" style="width: 100%"></div>
            </div>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
    </div>
  </div>
</section>
<!-- jQuery -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
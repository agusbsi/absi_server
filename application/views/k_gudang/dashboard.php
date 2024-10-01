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
              <h2>Hallo.. <?= $this->session->userdata('nama_user') ?></h2>
              <p>Selamat datang di Dahboard <a href="#">Kepala Gudang.</a> <br>
                anda bisa menggunakan aplikasi ABSI ini untuk mempermudah pekerjaan anda.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="containerkartu">
      <div class="kartu">
        <div class="kartu-ikon">
          <i class="fas fa-box"></i>
        </div>
        <div class="konten">
          <p>Total Items</p>
          <h2><?= ($t_artikel->total == 0) ? "0" : number_format($t_artikel->total) ?></h2>
          <p>Artikel</p>
        </div>
      </div>
      <div class="kartu">
        <div class="kartu-ikon">
          <i class="fas fa-store"></i>
        </div>
        <div class="konten">
          <p>Total Toko</p>
          <h2><?= ($t_toko->total == 0) ? "0" : number_format($t_toko->total) ?></h2>
          <p>Toko Aktif</p>
        </div>
      </div>
      <div class="kartu">
        <div class="kartu-ikon">
          <i class="fas fa-cubes"></i>
        </div>
        <div class="konten">
          <p>Total Stok</p>
          <h2><?= ($t_stok->total == 0) ? "0" : number_format($t_stok->total) ?></h2>
          <p>Semua Toko</p>
        </div>
      </div>
    </div>
    <div class="callout callout-info text-left">
      Transaksi Bulan : <b><?= date('M-Y') ?></b>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3><?= ($t_minta->total == 0) ? "Kosong" : number_format($t_minta->total) ?></h3>
            <small>( <?= ($t_minta->total_qty == 0) ? "0" : number_format($t_minta->total_qty) ?> artikel )</small>
          </div>
          <div class="icon">
            <i class="fas fa-file"></i>
          </div>
          <a href="<?= base_url('k_gudang/Dashboard/po') ?>" class="small-box-footer">
            Permintaan
          </a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3><?= ($t_kirim->total == 0) ? "Kosong" : number_format($t_kirim->total) ?></h3>
            <small>( <?= ($t_kirim->total_qty == 0) ? "0" : number_format($t_kirim->total_qty) ?> artikel )</small>
          </div>
          <div class="icon">
            <i class="fas fa-truck"></i>
          </div>
          <a href="<?= base_url('k_gudang/Dashboard/kirim') ?>" class="small-box-footer">
            Pengiriman
          </a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3><?= ($t_retur->total == 0) ? "Kosong" : number_format($t_retur->total) ?></h3>
            <small>( <?= ($t_retur->total_qty == 0) ? "0" : number_format($t_retur->total_qty) ?> artikel )</small>
          </div>
          <div class="icon">
            <i class="fas fa-exchange-alt"></i>
          </div>
          <a href="<?= base_url('k_gudang/Dashboard/retur') ?>" class="small-box-footer">
            Retur
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
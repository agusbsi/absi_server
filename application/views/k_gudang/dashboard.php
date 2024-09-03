<style>
  .card-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 30px;
  }

  .cardgudang {
    flex: 1 1 calc(33.333% - 20px);
    background-color: #343a40;
    border-radius: 10px;
    padding: 20px;
    color: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: relative;
  }

  .box-icon {
    position: absolute;
    bottom: -30px;
    left: 10px;
    font-size: 60px;
  }

  .box-icon i {
    color: #007bff;
  }

  .content {
    text-align: center;
    margin-left: auto;
    margin-right: auto;
  }

  .content p:first-child {
    font-size: 18px;
    margin: 0;
  }

  .content h2 {
    font-size: 32px;
    margin: 5px 0;
  }

  .content p:last-child {
    font-size: 18px;
    margin: 0;
  }

  /* Penyesuaian untuk layar ponsel */
  @media (max-width: 768px) {
    .cardgudang {
      flex: 1 1 calc(50% - 10px);
      /* Dua kolom pada layar ponsel */
    }
  }

  @media (max-width: 480px) {
    .cardgudang {
      flex: 1 1 100%;
      /* Satu kolom pada layar sangat kecil */
    }
  }
</style>
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-4">
            <img src="<?= base_url('assets/img/saran.svg') ?>" alt="dashboard" style="width:100px;">
          </div>
          <div class="col-lg-8 text-left">
            <strong>Hi, <?= $this->session->userdata('nama_user') ?>.</strong> <br>
            <small>Selamat datang di Dahboard Kepala Gudang. <br>
              anda bisa menggunakan aplikasi ABSI ini untuk mempermudah pekerjaan anda, silahkan berikan saran dan masukan untuk pengembangan aplikasi dengan chat langsung TIM IT atau klik <a href="<?= base_url('Profile/saran') ?>"> <strong>Disini .</strong> </a></small>
          </div>
        </div>
      </div>
    </div>
    <div class="card-container">
      <div class="cardgudang">
        <div class="box-icon">
          <i class="fas fa-box"></i>
        </div>
        <div class="content">
          <p>Total Items</p>
          <h2><?= ($t_artikel->total == 0) ? "0" : number_format($t_artikel->total) ?></h2>
          <p>Artikel</p>
        </div>
      </div>
      <div class="cardgudang">
        <div class="box-icon">
          <i class="fas fa-store"></i>
        </div>
        <div class="content">
          <p>Total Toko</p>
          <h2><?= ($t_toko->total == 0) ? "0" : number_format($t_toko->total) ?></h2>
          <p>Toko Aktif</p>
        </div>
      </div>
      <div class="cardgudang">
        <div class="box-icon">
          <i class="fas fa-cubes"></i>
        </div>
        <div class="content">
          <p>Total Stok</p>
          <h2><?= ($t_stok->total == 0) ? "0" : number_format($t_stok->total) ?></h2>
          <p>Semua Toko</p>
        </div>
      </div>
    </div>
    <div class="callout callout-danger text-left">
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
<!-- end boxes -->
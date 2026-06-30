<style>
  /* menu livin */
  .menu-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
  }

  .menu-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin-bottom: 10px;
    position: relative;
  }

  .menu-item a {
    position: relative;
    display: inline-block;
  }

  /* Notif Badge */
  .notif {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: #ed2938;
    color: #fff;
    border-radius: 50%;
    padding: 4px 6px;
    font-size: 0.7rem;
    font-weight: bold;
    line-height: 1;
    text-align: center;
    box-shadow: 0 0 0 2px #fff;
    animation: bounce 1.5s infinite;
  }

  @keyframes bounce {

    0%,
    20%,
    50%,
    80%,
    100% {
      transform: translateY(0);
    }

    40% {
      transform: translateY(-6px);
    }

    60% {
      transform: translateY(-3px);
    }
  }

  .menu-item i {
    font-size: 30px;
    margin-bottom: 5px;
    background-color: rgb(238, 242, 248);
    color: #007bff;
    padding: 12px 16px;
    border-radius: 25%;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }

  .menu-item a:hover i {
    color: #28a745;
    background-color: rgb(214, 248, 222);
    transform: scale(1.1);
  }

  .menu-item span {
    font-size: 12px;
    font-weight: 700;
    color: #333;
    margin-top: 4px;
  }

  .judul-menu {
    font-size: 18px;
    font-weight: 700;
    color: #333;
    margin: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  /* Dashboard Team Leader */
  .tl-dashboard {
    --tl-ink: #172033;
    --tl-muted: #64748b;
    --tl-line: #e7edf4;
    padding: 18px 8px 28px;
    color: var(--tl-ink);
  }

  .tl-dashboard a:hover {
    text-decoration: none;
  }

  .tl-hero-card {
    position: relative;
    min-height: 220px;
    overflow: hidden;
    color: #fff;
    background: radial-gradient(circle at 76% 18%, rgba(94, 234, 212, .28), transparent 28%), linear-gradient(125deg, #0f172a 0%, #0f766e 62%, #14b8a6 100%);
    border: 0;
    border-radius: 24px;
    box-shadow: 0 18px 38px rgba(15, 118, 110, .18);
  }

  .tl-hero-card::after {
    position: absolute;
    right: -70px;
    bottom: -145px;
    width: 240px;
    height: 240px;
    content: '';
    border: 1px solid rgba(255, 255, 255, .14);
    border-radius: 50%;
  }

  .tl-hero-card .card-body {
    position: relative;
    z-index: 1;
    padding: 32px 38px;
  }

  .tl-hero-card .row {
    min-height: 150px;
    align-items: center;
  }

  .tl-hero-card .konten {
    margin: 0;
    text-align: left !important;
  }

  .tl-hero-card .konten h2 {
    margin: 0 0 10px;
    font-size: clamp(27px, 4vw, 38px);
    font-weight: 800;
  }

  .tl-hero-card .konten p {
    max-width: 560px;
    margin: 0;
    color: rgba(255, 255, 255, .78);
    font-size: 15px;
    line-height: 1.65;
  }

  .tl-hero-card .konten a {
    padding: 0;
    color: #99f6e4;
    background: transparent;
  }

  .tl-hero-card .img-dashboard {
    position: relative;
    top: auto;
    left: auto;
    display: block;
    width: 100%;
    max-width: 210px;
    max-height: 170px;
    margin: auto;
    object-fit: contain;
    filter: drop-shadow(0 12px 18px rgba(15, 23, 42, .18));
  }

  .tl-section-heading {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 12px;
    margin: 22px 2px 13px;
  }

  .tl-section-heading h3 {
    margin: 0 0 3px;
    font-size: 19px;
    font-weight: 800;
  }

  .tl-section-heading p {
    margin: 0;
    color: var(--tl-muted);
    font-size: 12px;
  }

  .tl-kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 22px;
  }

  .tl-kpi-card {
    display: block;
    min-width: 0;
    padding: 18px;
    color: var(--tl-ink);
    background: #fff;
    border: 1px solid var(--tl-line);
    border-radius: 18px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, .055);
    transition: transform .2s ease, box-shadow .2s ease;
  }

  .tl-kpi-card:hover {
    color: var(--tl-ink);
    transform: translateY(-3px);
    box-shadow: 0 14px 28px rgba(15, 23, 42, .09);
  }

  .tl-kpi-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 13px;
    color: var(--tl-muted);
    font-size: 12px;
    font-weight: 700;
  }

  .tl-kpi-icon {
    display: inline-flex;
    width: 42px;
    height: 42px;
    align-items: center;
    justify-content: center;
    color: var(--kpi-color);
    background: var(--kpi-bg);
    border-radius: 13px;
    font-size: 17px;
  }

  .tl-kpi-value {
    display: block;
    margin-bottom: 3px;
    overflow: hidden;
    font-size: 25px;
    font-weight: 800;
    line-height: 1.15;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .tl-kpi-hint {
    color: #94a3b8;
    font-size: 11px;
  }

  .tl-kpi-card.teal { --kpi-color: #0f766e; --kpi-bg: #ccfbf1; }
  .tl-kpi-card.blue { --kpi-color: #2563eb; --kpi-bg: #dbeafe; }
  .tl-kpi-card.violet { --kpi-color: #7c3aed; --kpi-bg: #ede9fe; }
  .tl-kpi-card.amber { --kpi-color: #d97706; --kpi-bg: #fef3c7; }

  .tl-modern-card {
    border: 1px solid var(--tl-line);
    border-radius: 20px;
    box-shadow: 0 8px 26px rgba(15, 23, 42, .05);
  }

  .tl-modern-card > .card-header {
    padding: 20px 22px 14px;
    color: var(--tl-ink);
    background: transparent;
    border: 0;
  }

  .tl-card-title {
    display: block;
    margin-bottom: 3px;
    font-size: 18px;
    font-weight: 800;
  }

  .tl-card-subtitle {
    color: var(--tl-muted);
    font-size: 12px;
  }

  .tl-menu-card .card-body {
    padding: 6px 22px 22px;
  }

  .tl-menu-card .menu-container {
    grid-template-columns: repeat(7, minmax(0, 1fr));
    gap: 10px;
  }

  .tl-menu-card .menu-item {
    min-width: 0;
    min-height: 105px;
    align-items: flex-start;
    justify-content: space-between;
    gap: 10px;
    margin: 0;
    padding: 14px;
    text-align: left;
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 15px;
    transition: border-color .2s ease, background .2s ease, transform .2s ease;
  }

  .tl-menu-card .menu-item:hover {
    background: #f0fdfa;
    border-color: #99f6e4;
    transform: translateY(-2px);
  }

  .tl-menu-card .menu-item a {
    display: inline-flex;
  }

  .tl-menu-card .menu-item i {
    width: 38px;
    height: 38px;
    margin: 0;
    padding: 0;
    color: #0f766e;
    background: #ccfbf1;
    border-radius: 12px;
    box-shadow: none;
    font-size: 15px;
    line-height: 38px;
    text-align: center;
  }

  .tl-menu-card .menu-item a:hover i {
    color: #0f766e;
    background: #99f6e4;
    transform: none;
  }

  .tl-menu-card .menu-item span {
    margin: 0;
    color: var(--tl-ink);
    font-size: 12px;
    line-height: 1.25;
  }

  .tl-menu-card .notif {
    top: -5px;
    right: -8px;
    z-index: 2;
    min-width: 22px;
    padding: 5px 6px;
    animation: none;
    box-shadow: 0 4px 10px rgba(239, 68, 68, .25);
  }

  .tl-menu-card .menu-item .notif {
    color: #fff;
    font-size: 10px;
    line-height: 1;
  }

  .tl-chart-card .card-body {
    padding: 8px 22px 20px;
  }

  .tl-chart-card .chart {
    position: relative;
    height: 315px;
  }

  .tl-chart-state {
    position: absolute;
    z-index: 2;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    color: var(--tl-muted);
    background: rgba(255, 255, 255, .9);
    font-size: 12px;
  }

  .tl-chart-card .card-footer {
    padding: 12px 22px;
    color: var(--tl-muted);
    background: #f8fafc;
    border-top: 1px solid var(--tl-line);
    border-radius: 0 0 20px 20px;
  }

  @media (max-width: 1199.98px) {
    .tl-menu-card .menu-container { grid-template-columns: repeat(5, minmax(0, 1fr)); }
  }

  @media (max-width: 991.98px) {
    .tl-kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .tl-menu-card .menu-container { grid-template-columns: repeat(4, minmax(0, 1fr)); }
  }

  @media (max-width: 767.98px) {
    .tl-dashboard { padding: 10px 0 20px; }
    .tl-hero-card { min-height: auto; border-radius: 20px; }
    .tl-hero-card .card-body { padding: 25px 22px; }
    .tl-hero-card .row { min-height: 0; }
    .tl-hero-card .img-dashboard { max-width: 145px; margin-bottom: 18px; }
    .tl-menu-card .menu-container { grid-template-columns: repeat(3, minmax(0, 1fr)); }
  }

  @media (max-width: 479.98px) {
    .tl-kpi-grid { gap: 10px; }
    .tl-kpi-card { padding: 14px; }
    .tl-kpi-value { font-size: 21px; }
    .tl-menu-card .card-body { padding-right: 14px; padding-left: 14px; }
    .tl-menu-card .menu-container { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .tl-chart-card .chart { height: 270px; }
  }

  /* Akses cepat bergaya mobile banking */
  .tl-menu-card {
    overflow: hidden;
    background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
  }

  .tl-menu-card > .card-header {
    padding-bottom: 18px;
    border-bottom: 1px solid #eef3f8;
  }

  .tl-menu-card .card-body {
    padding: 22px 24px 24px;
  }

  .tl-menu-card .menu-container {
    grid-template-columns: repeat(7, minmax(0, 1fr));
    gap: 20px 8px;
  }

  .tl-menu-card .menu-item {
    min-height: 92px;
    align-items: center;
    justify-content: flex-start;
    gap: 10px;
    padding: 0 3px;
    text-align: center;
    background: transparent;
    border: 0;
    border-radius: 0;
  }

  .tl-menu-card .menu-item:hover {
    background: transparent;
    border-color: transparent;
    transform: none;
  }

  .tl-menu-card .menu-item a {
    display: inline-flex;
    width: 56px;
    height: 56px;
    flex: 0 0 56px;
    align-items: center;
    justify-content: center;
    background: linear-gradient(145deg, #f2f9ff 0%, #e4f2ff 100%);
    border: 1px solid #d8ecfb;
    border-radius: 19px;
    box-shadow: 0 7px 16px rgba(0, 108, 181, .10), inset 0 1px 0 rgba(255, 255, 255, .9);
    transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
  }

  .tl-menu-card .menu-item i {
    width: auto;
    height: auto;
    color: #0072bc;
    background: transparent;
    border-radius: 0;
    font-size: 21px;
    line-height: 1;
  }

  .tl-menu-card .menu-item:hover a,
  .tl-menu-card .menu-item a:focus {
    background: linear-gradient(145deg, #e8f5ff 0%, #d8edff 100%);
    box-shadow: 0 10px 20px rgba(0, 108, 181, .16), inset 0 1px 0 rgba(255, 255, 255, .9);
    outline: none;
    transform: translateY(-3px);
  }

  .tl-menu-card .menu-item a:hover i,
  .tl-menu-card .menu-item a:focus i {
    color: #005b99;
    background: transparent;
  }

  .tl-menu-card .menu-item > span:not(.notif) {
    display: block;
    width: 100%;
    color: #334155;
    font-size: 11.5px;
    font-weight: 600;
    line-height: 1.25;
  }

  .tl-menu-card .notif,
  .tl-menu-card .menu-item .notif {
    top: -7px;
    right: -7px;
    min-width: 21px;
    height: 21px;
    padding: 0 5px;
    color: #fff;
    background: #ef4444;
    border: 2px solid #fff;
    font-size: 9px;
    line-height: 17px;
    box-shadow: 0 4px 9px rgba(239, 68, 68, .28);
  }

  @media (max-width: 991.98px) {
    .tl-menu-card .menu-container {
      grid-template-columns: repeat(5, minmax(0, 1fr));
    }
  }

  @media (max-width: 767.98px) {
    .tl-menu-card .card-body {
      padding: 20px 12px 22px;
    }

    .tl-menu-card .menu-container {
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 18px 4px;
    }

    .tl-menu-card .menu-item a {
      width: 54px;
      height: 54px;
      flex-basis: 54px;
      border-radius: 18px;
    }
  }

  @media (max-width: 359.98px) {
    .tl-menu-card .menu-item a {
      width: 50px;
      height: 50px;
      flex-basis: 50px;
      border-radius: 16px;
    }

    .tl-menu-card .menu-item i {
      font-size: 19px;
    }

    .tl-menu-card .menu-item > span:not(.notif) {
      font-size: 10.5px;
    }
  }
</style>

<?php
$id = $this->session->userdata('id');
$Permintaan = $this->db->query("SELECT * FROM tb_permintaan JOIN tb_toko ON tb_permintaan.id_toko = tb_toko.id JOIN tb_user ON tb_user.id = tb_toko.id_leader WHERE tb_permintaan.status = '0' AND tb_toko.id_leader ='$id'")->num_rows();
$Retur = $this->db->query("SELECT * FROM tb_retur JOIN tb_toko ON tb_retur.id_toko = tb_toko.id JOIN tb_user ON tb_user.id = tb_toko.id_leader WHERE tb_retur.status = '0' AND tb_toko.id_leader ='$id'")->num_rows();
$Bap = $this->db->query("SELECT * FROM tb_bap 
  JOIN tb_toko ON tb_bap.id_toko = tb_toko.id 
  JOIN tb_user ON tb_user.id = tb_toko.id_leader 
  WHERE tb_bap.status = '0' AND tb_toko.id_leader ='$id'")->num_rows();
$kirim = $this->db->query("SELECT tp.id FROM tb_pengiriman tp
  JOIN tb_toko tt ON tp.id_toko = tt.id 
  JOIN tb_user tu ON tu.id = tt.id_leader 
  WHERE tp.status = '1' AND tt.id_leader ='$id'")->num_rows();
$total_toko = isset($t_toko->total) ? (int) $t_toko->total : 0;
$total_user = isset($t_user) ? (int) $t_user : 0;
$total_stok = isset($t_stok->total) ? (int) $t_stok->total : 0;
$total_perlu_tindakan = $Permintaan + $Retur + $Bap + $kirim;
?>
<section class="content tl-dashboard">
  <div class="card tl-hero-card">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-4">
          <img src="<?= base_url('assets/img/saran.svg') ?>" alt="dashboard" class="img-dashboard">
        </div>
        <div class="col-lg-8">
          <div class="konten text-left">
            <h2>Halo, <?= html_escape($this->session->userdata('nama_user')) ?>!</h2>
            <p>Selamat datang di dashboard <a href="#">Team Leader</a>. Pantau aktivitas toko dan tindak lanjuti pekerjaan area Anda dari satu tempat.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="tl-section-heading">
    <div>
      <h3>Ringkasan area</h3>
      <p>Gambaran operasional yang berada dalam tanggung jawab Anda.</p>
    </div>
  </div>
  <div class="tl-kpi-grid">
    <a href="<?= base_url('leader/toko') ?>" class="tl-kpi-card teal">
      <div class="tl-kpi-top"><span>Toko aktif</span><span class="tl-kpi-icon"><i class="fas fa-store"></i></span></div>
      <strong class="tl-kpi-value"><?= number_format($total_toko, 0, ',', '.') ?></strong>
      <span class="tl-kpi-hint">Toko dalam area Anda</span>
    </a>
    <a href="<?= base_url('leader/spg') ?>" class="tl-kpi-card blue">
      <div class="tl-kpi-top"><span>SPG aktif</span><span class="tl-kpi-icon"><i class="fas fa-users"></i></span></div>
      <strong class="tl-kpi-value"><?= number_format($total_user, 0, ',', '.') ?></strong>
      <span class="tl-kpi-hint">Personel toko terdaftar</span>
    </a>
    <a href="<?= base_url('leader/Stok') ?>" class="tl-kpi-card violet">
      <div class="tl-kpi-top"><span>Stok area</span><span class="tl-kpi-icon"><i class="fas fa-boxes"></i></span></div>
      <strong class="tl-kpi-value"><?= number_format($total_stok, 0, ',', '.') ?></strong>
      <span class="tl-kpi-hint">Total unit seluruh toko</span>
    </a>
    <a href="<?= base_url('leader/permintaan') ?>" class="tl-kpi-card amber">
      <div class="tl-kpi-top"><span>Perlu tindakan</span><span class="tl-kpi-icon"><i class="fas fa-bell"></i></span></div>
      <strong class="tl-kpi-value"><?= number_format($total_perlu_tindakan, 0, ',', '.') ?></strong>
      <span class="tl-kpi-hint">Transaksi menunggu tindak lanjut</span>
    </a>
  </div>

  <div class="card tl-modern-card tl-menu-card">
    <div class="card-header">
      <span class="tl-card-title">Akses cepat</span>
      <span class="tl-card-subtitle">Menu operasional dan laporan yang paling sering digunakan.</span>
    </div>
    <div class="card-body">
      <div class="menu-container">
        <div class="menu-item">
          <a href="<?= base_url('leader/toko') ?>"><i class="fas fa-store"></i></a>
          <span>Toko Aktif</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('spv/Toko/toko_tutup') ?>"><i class="fas fa-store-slash"></i></a>
          <span>Toko Tutup</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('leader/spg') ?>"><i class="fas fa-users"></i></a>
          <span>SPG</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('adm/Stok/stok_gudang') ?>"><i class="fas fa-warehouse"></i></a>
          <span>Stok Gudang</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('leader/permintaan') ?>">
            <?php if ($Permintaan != 0) { ?>
              <div class="notif">
                <?= $Permintaan; ?>
              </div>
            <?php } ?>
            <i class="fas fa-file-alt"></i>
          </a>
          <span>PO</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('leader/pengiriman') ?>">
            <?php if ($kirim != 0) { ?>
              <div class="notif">
                <?= $kirim; ?>
              </div>
            <?php } ?>
            <i class="fas fa-truck"></i>
          </a>
          <span>Pengiriman</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('leader/retur') ?>">
            <?php if ($Retur != 0) { ?>
              <div class="notif">
                <?= $Retur; ?>
              </div>
            <?php } ?>
            <i class="fas fa-exchange-alt"></i>
          </a>
          <span>Retur</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('leader/Mutasi') ?>">
            <i class="fas fa-copy"></i>
          </a>
          <span>Mutasi</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('leader/Bap') ?>">
            <?php if ($Bap != 0) { ?>
              <div class="notif">
                <?= $Bap; ?>
              </div>
            <?php } ?>
            <i class="fas fa-envelope"></i>
          </a>
          <span>BAP</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('sup/So') ?>"><i class="fas fa-box"></i></a>
          <span>SO Artikel</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('hrd/Aset/list_aset') ?>"><i class="fas fa-cubes"></i></a>
          <span>SO Aset</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('sup/So/Riwayat_so') ?>"><i class="fas fa-history"></i></a>
          <span>Riwayat SO Artikel</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('adm/So/histori_aset') ?>"><i class="fas fa-clipboard-list"></i></a>
          <span>Riwayat SO Aset</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('leader/Penjualan/lap_toko') ?>"><i class="fas fa-cart-plus"></i></a>
          <span>Lap Penjualan</span>
        </div>

      </div>
    </div>
  </div>
  <div class="card tl-modern-card tl-chart-card">
    <div class="card-header">
      <span class="tl-card-title">Tren transaksi <?= date('Y') ?></span>
      <span class="tl-card-subtitle">Perbandingan jumlah unit penjualan, pengiriman, dan retur per bulan.</span>
    </div>
    <div class="card-body">
      <div class="chart">
        <div class="tl-chart-state" id="chartState"><i class="fas fa-circle-notch fa-spin"></i> Memuat data transaksi...</div>
        <canvas id="grafikTransaksi" aria-label="Grafik transaksi semua toko" role="img"></canvas>
      </div>
    </div>
    <div class="card-footer">
      <small>* Data update : <?= date('d-M-Y H:i:s') ?> </small>
    </div>
    <!-- /.card-body -->
  </div>
</section>
<script src="<?php echo base_url() ?>/assets/plugins/chart.js/Chart.min.js"></script>
<script>
  $(document).ready(function() {
    $.ajax({
      url: '<?= base_url('leader/Dashboard/transaksi') ?>',
      method: 'GET',
      dataType: 'json',
      success: function(data) {
        $('#chartState').fadeOut(180);
        // Get the current month to limit the months displayed
        var currentMonth = new Date().getMonth() + 1; // getMonth() returns 0-11
        var bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'].slice(0, currentMonth);

        var transaksi = {
          labels: bulan,
          datasets: [{
              label: 'Penjualan',
              backgroundColor: '#14b8a6',
              borderColor: 'rgba(210, 214, 222, 1)',
              pointRadius: false,
              pointColor: 'rgba(210, 214, 222, 1)',
              pointStrokeColor: '#c1c7d1',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(220,220,220,1)',
              data: data.jual
            },
            {
              label: 'Retur',
              backgroundColor: '#f97316',
              borderColor: 'rgba(210, 214, 222, 1)',
              pointRadius: false,
              pointColor: 'rgba(210, 214, 222, 1)',
              pointStrokeColor: '#c1c7d1',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(220,220,220,1)',
              data: data.retur
            },
            {
              label: 'Pengiriman',
              backgroundColor: '#3b82f6',
              borderColor: 'rgba(60,141,188,0.8)',
              pointRadius: false,
              pointColor: '#3b8bba',
              pointStrokeColor: 'rgba(60,141,188,1)',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data: data.kirim
            }
          ]
        }
        var barChartCanvas = $('#grafikTransaksi').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, transaksi)
        var temp0 = transaksi.datasets[0]
        var temp1 = transaksi.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
          responsive: true,
          maintainAspectRatio: false,
          datasetFill: false,
          legend: {
            position: 'bottom',
            labels: { usePointStyle: true, boxWidth: 8, fontColor: '#64748b', padding: 18 }
          },
          tooltips: {
            mode: 'index',
            intersect: false,
            backgroundColor: '#0f172a',
            cornerRadius: 8
          },
          scales: {
            xAxes: [{
              gridLines: { display: false },
              ticks: { fontColor: '#64748b' },
              barPercentage: .72,
              categoryPercentage: .72
            }],
            yAxes: [{
              gridLines: { color: '#edf2f7', drawBorder: false },
              ticks: { beginAtZero: true, precision: 0, fontColor: '#64748b' }
            }]
          }
        }

        new Chart(barChartCanvas, {
          type: 'bar',
          data: barChartData,
          options: barChartOptions
        })
      },
      error: function() {
        $('#chartState').html('<i class="fas fa-exclamation-circle text-warning"></i> Data grafik belum dapat dimuat. Silakan muat ulang halaman.');
      }
    });
  });
</script>

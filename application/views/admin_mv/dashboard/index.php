<?php
$nama_user = html_escape((string) $this->session->userdata('nama_user'));
?>

<style>
  .mv-dashboard {
    --mv-ink: #172033;
    --mv-muted: #64748b;
    --mv-line: #e7edf4;
    padding: 18px 8px 30px;
    color: var(--mv-ink);
  }

  .mv-dashboard a:hover { text-decoration: none; }

  .mv-dashboard > .card:first-child {
    position: relative;
    min-height: 218px;
    overflow: hidden;
    color: #fff;
    background: radial-gradient(circle at 83% 14%, rgba(125, 211, 252, .32), transparent 27%), linear-gradient(125deg, #0f172a 0%, #075985 57%, #0284c7 100%);
    border: 0;
    border-radius: 24px;
    box-shadow: 0 18px 38px rgba(2, 132, 199, .18);
  }

  .mv-dashboard > .card:first-child::after {
    position: absolute;
    right: -70px;
    bottom: -145px;
    width: 250px;
    height: 250px;
    content: '';
    border: 1px solid rgba(255, 255, 255, .14);
    border-radius: 50%;
  }

  .mv-dashboard > .card:first-child .card-body {
    position: relative;
    z-index: 1;
    padding: 32px 38px;
  }

  .mv-dashboard > .card:first-child .row { min-height: 150px; align-items: center; }
  .mv-dashboard .konten { margin: 0; }

  .mv-dashboard .konten h2 {
    margin: 0 0 10px;
    color: #fff;
    font-size: clamp(27px, 4vw, 38px);
    font-weight: 800;
  }

  .mv-dashboard .konten p {
    max-width: 590px;
    margin: 0;
    color: rgba(255, 255, 255, .78);
    font-size: 15px;
    line-height: 1.65;
  }

  .mv-dashboard .konten a { padding: 0; color: #bae6fd; background: transparent; }

  .mv-dashboard .img-dashboard {
    position: relative;
    top: auto;
    left: auto;
    display: block;
    width: 100%;
    max-width: 215px;
    max-height: 170px;
    margin: auto;
    object-fit: contain;
    filter: drop-shadow(0 13px 18px rgba(15, 23, 42, .22));
  }

  .mv-summary-heading,
  .mv-action-heading {
    margin: 24px 2px 13px;
  }

  .mv-summary-heading h3,
  .mv-action-heading h3 { margin: 0 0 3px; font-size: 19px; font-weight: 800; }
  .mv-summary-heading p,
  .mv-action-heading p { margin: 0; color: var(--mv-muted); font-size: 12px; }

  .mv-dashboard .mv-kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
  }

  .mv-dashboard .mv-kpi-grid .mv-summary-heading { grid-column: 1 / -1; }

  .mv-dashboard .info-box {
    position: relative;
    min-height: 128px;
    overflow: hidden;
    margin-bottom: 14px !important;
    padding: 16px;
    color: var(--mv-ink) !important;
    background: #fff !important;
    border: 1px solid var(--mv-line);
    border-radius: 18px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, .055);
    transition: transform .2s ease, box-shadow .2s ease;
  }

  .mv-dashboard .info-box:hover { transform: translateY(-3px); box-shadow: 0 14px 28px rgba(15, 23, 42, .09); }

  .mv-dashboard .info-box-icon {
    width: 45px;
    height: 45px;
    flex: 0 0 45px;
    align-self: flex-start;
    color: var(--box-color);
    background: var(--box-bg);
    border-radius: 13px;
    font-size: 18px;
  }

  .mv-dashboard .info-box.bg-success { --box-color: #15803d; --box-bg: #dcfce7; }
  .mv-dashboard .info-box.bg-info { --box-color: #0369a1; --box-bg: #e0f2fe; }
  .mv-dashboard .info-box.bg-primary { --box-color: #7c3aed; --box-bg: #ede9fe; }
  .mv-dashboard .info-box.bg-danger { --box-color: #dc2626; --box-bg: #fee2e2; }

  .mv-dashboard .info-box-content { padding: 0 0 0 13px; }
  .mv-dashboard .info-box-text { color: var(--mv-muted); font-size: 12px; font-weight: 700; }
  .mv-dashboard .info-box-number { margin-top: 4px; font-size: 27px; font-weight: 800; line-height: 1.1; }

  .mv-dashboard .info-box > a {
    position: absolute;
    right: 16px;
    bottom: 13px;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
  }

  .mv-dashboard .info-box > a i { margin-left: 4px; }

  .mv-dashboard .mv-table-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
  }

  .mv-dashboard .mv-table-grid .mv-action-heading { grid-column: 1 / -1; }

  .mv-dashboard .mv-table-card {
    overflow: hidden;
    height: calc(100% - 16px);
    margin-bottom: 16px;
    background: #fff;
    border: 1px solid var(--mv-line);
    border-radius: 20px;
    box-shadow: 0 8px 26px rgba(15, 23, 42, .05);
  }

  .mv-dashboard .mv-table-card .card-header {
    padding: 20px 22px 15px;
    color: var(--mv-ink);
    background: #fff;
    border: 0;
  }

  .mv-dashboard .mv-table-card .card-title { float: none; margin: 0; font-size: 16px; font-weight: 800; }
  .mv-dashboard .mv-table-card .card-title i {
    display: inline-flex;
    width: 38px;
    height: 38px;
    align-items: center;
    justify-content: center;
    margin-right: 9px;
    color: var(--card-color);
    background: var(--card-bg);
    border-radius: 12px;
  }

  .mv-dashboard .mv-table-card.card-success { --card-color: #15803d; --card-bg: #dcfce7; }
  .mv-dashboard .mv-table-card.card-danger { --card-color: #dc2626; --card-bg: #fee2e2; }

  .mv-dashboard .mv-table-card .table { margin: 0; }
  .mv-dashboard .mv-table-card .table thead th {
    padding: 11px 22px;
    color: #94a3b8;
    background: #f8fafc;
    border: 0;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .045em;
    text-transform: uppercase;
    white-space: nowrap;
  }

  .mv-dashboard .mv-table-card .table tbody td {
    padding: 14px 22px;
    vertical-align: middle;
    color: #334155;
    border-color: #eef2f7;
    font-size: 12px;
  }

  .mv-dashboard .mv-table-card .table tbody td:first-child a { color: #0369a1; font-weight: 800; }
  .mv-dashboard .mv-table-card .badge {
    padding: 5px 8px;
    color: #64748b;
    background: #f1f5f9;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 600;
  }

  .mv-dashboard .mv-empty-state { padding: 38px 18px !important; color: var(--mv-muted) !important; text-align: center; }
  .mv-dashboard .mv-empty-state i { display: block; margin-bottom: 8px; color: #22c55e; font-size: 20px; }

  .mv-dashboard .mv-table-card .card-footer {
    padding: 13px 22px;
    background: #fff;
    border-top: 1px solid var(--mv-line);
  }

  .mv-dashboard .mv-table-card .card-footer .btn {
    padding: 0;
    color: #0369a1;
    background: transparent;
    border: 0;
    font-size: 12px;
    font-weight: 700;
    box-shadow: none;
  }

  @media (max-width: 767.98px) {
    .mv-dashboard { padding: 10px 0 22px; }
    .mv-dashboard > .card:first-child { min-height: auto; border-radius: 20px; }
    .mv-dashboard > .card:first-child .card-body { padding: 25px 22px; }
    .mv-dashboard > .card:first-child .row { min-height: 0; }
    .mv-dashboard .img-dashboard { max-width: 145px; margin-bottom: 18px; }
    .mv-dashboard .mv-table-card .card-header,
    .mv-dashboard .mv-table-card .card-footer { padding-right: 16px; padding-left: 16px; }
    .mv-dashboard .mv-table-card .table thead th,
    .mv-dashboard .mv-table-card .table tbody td { padding-right: 16px; padding-left: 16px; }
    .mv-dashboard .mv-kpi-grid,
    .mv-dashboard .mv-table-grid { grid-template-columns: 1fr; }
  }

  @media (min-width: 768px) and (max-width: 991.98px) {
    .mv-dashboard .mv-kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  }
</style>

<section class="content mv-dashboard">
  <div class="card card-primary card-outline">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-4">
          <img src="<?= base_url('assets/img/saran.svg') ?>" alt="dashboard" class="img-dashboard">
        </div>
        <div class="col-lg-8">
          <div class="konten text-left">
            <h2>Halo, <?= $nama_user ?>!</h2>
            <p>Selamat datang di dashboard <a href="#">Admin MV</a>. Pantau aktivitas merchandise, kelola data operasional, dan tindak lanjuti transaksi dari satu tempat.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mv-main-row">
    <div class="col-12 mv-table-grid">
      <div class="mv-action-heading">
        <h3>Perlu ditindaklanjuti</h3>
        <p>Transaksi terbaru yang masih menunggu persetujuan.</p>
      </div>
      <div class="card card-success mv-table-card">
        <div class="card-header border-transparent">
          <h3 class="card-title">
            <i class="fas fa-file-alt"></i> Permintaan barang
          </h3>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table m-0">
              <thead>
                <tr>
                  <th>ID Permintaan</th>
                  <th>Toko</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                <?php if (is_array($list_minta) && count($list_minta) > 0) { ?>
                  <?php
                  foreach ($list_minta as $dd) :
                  ?>
                    <tr>
                      <td><a href="#">#<?= html_escape($dd->id) ?></a></td>
                      <td><?= html_escape($dd->nama_toko) ?></td>
                      <td><span class="badge"><?= html_escape($dd->created_at) ?></span></td>
                    </tr>
                  <?php endforeach; ?>
                <?php  } else { ?>
                  <tr><td colspan="3" class="mv-empty-state"><i class="fas fa-check-circle"></i><strong>Semua permintaan sudah ditangani</strong></td></tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <div class="card-footer clearfix">
          <a href="<?= base_url('sup/Permintaan'); ?>" class="btn btn-sm float-right">Lihat semua permintaan <i class="fas fa-arrow-right ml-1"></i></a>
        </div>
      </div>
      <div class="card card-danger mv-table-card">
        <div class="card-header border-transparent">
          <h3 class="card-title">
            <i class="fas fa-exchange-alt"></i> Retur barang
          </h3>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table m-0">
              <thead>
                <tr>
                  <th>ID Retur</th>
                  <th>Toko</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                <?php if (is_array($list_retur) && count($list_retur) > 0) { ?>
                  <?php
                  foreach ($list_retur as $dd) :
                  ?>
                    <tr>
                      <td><a href="#">#<?= html_escape($dd->id) ?></a></td>
                      <td><?= html_escape($dd->nama_toko) ?></td>
                      <td><span class="badge"><?= html_escape($dd->created_at) ?></span></td>
                    </tr>
                  <?php endforeach; ?>
                <?php  } else { ?>
                  <tr><td colspan="3" class="mv-empty-state"><i class="fas fa-check-circle"></i><strong>Semua retur sudah ditangani</strong></td></tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer clearfix">
          <a href="<?= base_url('adm_mv/Retur'); ?>" class="btn btn-sm float-right">Lihat semua retur <i class="fas fa-arrow-right ml-1"></i></a>
        </div>
      </div>
    </div>
    <div class="col-12 order-first mv-kpi-grid">
      <div class="mv-summary-heading">
        <h3>Ringkasan operasional</h3>
        <p>Gambaran data terbaru yang dikelola oleh Admin MV.</p>
      </div>
      <div class="info-box mb-3 bg-success">
        <span class="info-box-icon"><i class="fas fa-file-alt"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Permintaan Barang</span>
          <span class="info-box-number">
            <?= number_format((int) $jumlah_permintaan, 0, ',', '.') ?>
          </span>
        </div>
        <a href="<?= base_url('sup/permintaan') ?>" class="text-right">Lihat detail <i class="fas fa-arrow-right"></i></a>
      </div>
      <div class="info-box mb-3 bg-info">
        <span class="info-box-icon"><i class="fas fa-box"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Barang</span>
          <span class="info-box-number">
            <?= number_format((int) $jumlah_produk, 0, ',', '.') ?>
          </span>
        </div>
        <a href="<?= base_url('adm_mv/barang') ?>" class="text-right">Lihat detail <i class="fas fa-arrow-right"></i></a>
      </div>
      <div class="info-box mb-3 bg-primary">
        <span class="info-box-icon"><i class="fas fa-store"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Toko</span>
          <span class="info-box-number">
            <?= number_format(isset($t_toko->total) ? (int) $t_toko->total : 0, 0, ',', '.') ?>
          </span>
        </div>
        <a href="<?= base_url('adm_mv/Toko') ?>" class="text-right">Lihat detail <i class="fas fa-arrow-right"></i></a>
      </div>
      <div class="info-box mb-3 bg-danger">
        <span class="info-box-icon"><i class="fas fa-exchange-alt"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Retur</span>
          <span class="info-box-number">
            <?= number_format((int) $jumlah_retur, 0, ',', '.') ?>
          </span>
        </div>
        <a href="<?= base_url('adm_mv/retur') ?>" class="text-right">Lihat detail <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
  </div>
</section>

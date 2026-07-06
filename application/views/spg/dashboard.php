<?php
$nama_user = html_escape((string) $this->session->userdata('nama_user'));
$id_toko = (int) $this->session->userdata('id_toko');
$nama_toko = isset($toko_new->nama_toko) ? html_escape($toko_new->nama_toko) : 'Toko belum tersedia';
$alamat_toko = isset($toko_new->alamat) ? html_escape($toko_new->alamat) : '-';
$total_terima = (int) $terima;
$total_mutasi = (int) $mutasi;
$total_bap = (int) $bap;
$total_tindakan = $total_terima + $total_mutasi + $total_bap;
?>

<style>
  .spg-dashboard {
    --spg-ink: #172033;
    --spg-muted: #64748b;
    --spg-line: #e7edf4;
    padding: 18px 8px 32px;
    color: var(--spg-ink);
  }

  .spg-dashboard a:hover { text-decoration: none; }

  .spg-welcome {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 12px;
    margin: 0 2px 14px;
  }

  .spg-welcome h1 { margin: 0 0 3px; font-size: 23px; font-weight: 800; }
  .spg-welcome p { margin: 0; color: var(--spg-muted); font-size: 12px; }
  .spg-date { color: #94a3b8; font-size: 11px; font-weight: 600; white-space: nowrap; }

  .spg-store-card {
    position: relative;
    min-height: 190px;
    overflow: hidden;
    padding: 26px 28px;
    color: #fff;
    background: radial-gradient(circle at 82% 9%, rgba(125, 211, 252, .32), transparent 27%), linear-gradient(125deg, #0f172a 0%, #075985 58%, #0284c7 100%);
    border-radius: 23px;
    box-shadow: 0 18px 38px rgba(2, 132, 199, .18);
  }

  .spg-store-card::after {
    position: absolute;
    right: -75px;
    bottom: -145px;
    width: 250px;
    height: 250px;
    content: '';
    border: 1px solid rgba(255, 255, 255, .14);
    border-radius: 50%;
  }

  .spg-store-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 18px;
    padding: 5px 9px;
    color: #e0f2fe;
    background: rgba(255, 255, 255, .11);
    border: 1px solid rgba(255, 255, 255, .13);
    border-radius: 999px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .035em;
    text-transform: uppercase;
  }

  .spg-store-content { position: relative; z-index: 1; display: flex; align-items: center; gap: 15px; }
  .spg-store-icon {
    display: inline-flex;
    width: 52px;
    height: 52px;
    flex: 0 0 52px;
    align-items: center;
    justify-content: center;
    color: #e0f2fe;
    background: rgba(255, 255, 255, .12);
    border: 1px solid rgba(255, 255, 255, .15);
    border-radius: 16px;
    font-size: 21px;
  }

  .spg-store-info { min-width: 0; }
  .spg-store-info strong { display: block; margin-bottom: 4px; overflow: hidden; font-size: 20px; font-weight: 800; text-overflow: ellipsis; white-space: nowrap; }
  .spg-store-info span { display: block; max-width: 650px; overflow: hidden; color: rgba(255, 255, 255, .72); font-size: 11px; line-height: 1.5; text-overflow: ellipsis; white-space: nowrap; }

  .spg-store-actions { position: relative; z-index: 1; display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 8px; margin-top: 20px; }
  .spg-store-actions a { padding: 8px 13px; color: #fff; background: rgba(255, 255, 255, .12); border: 1px solid rgba(255, 255, 255, .16); border-radius: 10px; font-size: 10px; font-weight: 700; transition: background .2s ease, transform .2s ease; }
  .spg-store-actions a:hover { color: #075985; background: #fff; transform: translateY(-1px); }
  .spg-store-actions i { margin-left: 4px; }

  .spg-alert {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-top: 13px;
    padding: 15px 17px;
    color: #854d0e;
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 15px;
  }

  .spg-alert-icon { display: inline-flex; width: 36px; height: 36px; flex: 0 0 36px; align-items: center; justify-content: center; color: #d97706; background: #fef3c7; border-radius: 11px; }
  .spg-alert strong { display: block; margin-bottom: 2px; font-size: 12px; }
  .spg-alert span { display: block; color: #a16207; font-size: 11px; line-height: 1.45; }

  .spg-section-heading { display: flex; align-items: flex-end; justify-content: space-between; gap: 12px; margin: 24px 2px 13px; }
  .spg-section-heading h2 { margin: 0 0 3px; font-size: 18px; font-weight: 800; }
  .spg-section-heading p { margin: 0; color: var(--spg-muted); font-size: 11px; }
  .spg-action-count { padding: 5px 9px; color: #0369a1; background: #e0f2fe; border-radius: 999px; font-size: 10px; font-weight: 800; white-space: nowrap; }

  .spg-quick-card {
    overflow: hidden;
    padding: 24px 22px 21px;
    background: linear-gradient(180deg, #fff 0%, #fbfdff 100%);
    border: 1px solid var(--spg-line);
    border-radius: 21px;
    box-shadow: 0 10px 28px rgba(15, 23, 42, .055);
  }

  .spg-quick-grid { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 24px 10px; }
  .spg-quick-item { display: flex; min-width: 0; align-items: center; flex-direction: column; gap: 10px; color: #334155; text-align: center; }
  .spg-quick-icon {
    position: relative;
    display: inline-flex;
    width: 58px;
    height: 58px;
    flex: 0 0 58px;
    align-items: center;
    justify-content: center;
    color: #0066b3;
    background: linear-gradient(145deg, #f1f8ff 0%, #e3f2ff 100%);
    border: 1px solid #d5eaf9;
    border-radius: 20px;
    box-shadow: 0 7px 16px rgba(0, 102, 179, .10), inset 0 1px 0 rgba(255, 255, 255, .9);
    font-size: 21px;
    transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
  }

  .spg-quick-item:hover,
  .spg-quick-item:focus { color: #0f4c81; outline: none; }
  .spg-quick-item:hover .spg-quick-icon,
  .spg-quick-item:focus .spg-quick-icon { background: linear-gradient(145deg, #e8f5ff 0%, #d8edff 100%); box-shadow: 0 10px 20px rgba(0, 102, 179, .16); transform: translateY(-3px); }
  .spg-quick-label { display: block; width: 100%; overflow: hidden; font-size: 11px; font-weight: 650; line-height: 1.25; text-overflow: ellipsis; }

  .spg-notif {
    position: absolute;
    top: -7px;
    right: -7px;
    z-index: 2;
    min-width: 22px;
    height: 22px;
    padding: 0 5px;
    color: #fff;
    background: #ef4444;
    border: 2px solid #fff;
    border-radius: 999px;
    box-shadow: 0 4px 9px rgba(239, 68, 68, .28);
    font-size: 9px;
    font-weight: 800;
    line-height: 18px;
    text-align: center;
  }

  .spg-summary-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 11px; margin-top: 14px; }
  .spg-summary-item { display: flex; min-width: 0; align-items: center; gap: 11px; padding: 14px; background: #fff; border: 1px solid var(--spg-line); border-radius: 15px; }
  .spg-summary-icon { display: inline-flex; width: 38px; height: 38px; flex: 0 0 38px; align-items: center; justify-content: center; color: var(--summary-color); background: var(--summary-bg); border-radius: 11px; }
  .spg-summary-item.receipt { --summary-color: #0369a1; --summary-bg: #e0f2fe; }
  .spg-summary-item.mutation { --summary-color: #7c3aed; --summary-bg: #ede9fe; }
  .spg-summary-item.difference { --summary-color: #d97706; --summary-bg: #fef3c7; }
  .spg-summary-value { display: block; font-size: 18px; font-weight: 800; line-height: 1.1; }
  .spg-summary-label { color: var(--spg-muted); font-size: 10px; }

  @media (max-width: 991.98px) {
    .spg-quick-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
  }

  @media (max-width: 767.98px) {
    .spg-dashboard { padding: 10px 0 24px; }
    .spg-welcome { align-items: flex-start; flex-direction: column; }
    .spg-date { display: none; }
    .spg-store-card { min-height: 180px; padding: 22px 19px; border-radius: 20px; }
    .spg-store-info { flex: 1; }
    .spg-store-info strong {
      overflow: visible;
      font-size: clamp(13px, 4vw, 17px);
      line-height: 1.2;
      text-overflow: clip;
      white-space: normal;
      overflow-wrap: anywhere;
    }
    .spg-store-actions { justify-content: flex-start; }
    .spg-quick-card { padding: 22px 12px 20px; }
    .spg-quick-grid { gap: 21px 4px; }
    .spg-quick-icon { width: 54px; height: 54px; flex-basis: 54px; border-radius: 18px; font-size: 19px; }
  }

  @media (max-width: 575.98px) {
    .spg-summary-grid {
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 5px;
      margin-top: 10px;
    }
    .spg-summary-item {
      min-height: 58px;
      gap: 6px;
      padding: 7px 6px;
      border-radius: 10px;
    }
    .spg-summary-item > div { min-width: 0; }
    .spg-summary-icon {
      width: 28px;
      height: 28px;
      flex-basis: 28px;
      border-radius: 8px;
      font-size: 11px;
    }
    .spg-summary-value { font-size: 14px; }
    .spg-summary-label {
      display: block;
      font-size: 8px;
      line-height: 1.15;
    }
    .spg-quick-label { font-size: 10.5px; }
  }

  @media (max-width: 359.98px) {
    .spg-summary-grid { gap: 3px; }
    .spg-summary-item { gap: 4px; padding: 6px 4px; }
    .spg-summary-icon { width: 24px; height: 24px; flex-basis: 24px; font-size: 10px; }
    .spg-summary-value { font-size: 12px; }
    .spg-summary-label { font-size: 7px; }
    .spg-quick-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
  }
</style>

<section class="content spg-dashboard">
  <div class="spg-welcome">
    <div>
      <h1>Halo, <?= $nama_user ?>!</h1>
      <p>Selamat datang kembali. Kelola aktivitas toko Anda dari satu tempat.</p>
    </div>
    <span class="spg-date"><i class="far fa-calendar-alt mr-1"></i><?= date('d M Y') ?></span>
  </div>

  <div class="spg-store-card">
    <span class="spg-store-label"><i class="fas fa-map-marker-alt"></i> Toko aktif</span>
    <div class="spg-store-content">
      <span class="spg-store-icon"><i class="fas fa-store"></i></span>
      <div class="spg-store-info">
        <strong><?= $nama_toko ?></strong>
        <span><?= $alamat_toko ?></span>
      </div>
    </div>
    <div class="spg-store-actions">
      <?php if ((int) $jml > 1) { ?>
        <a href="<?= base_url('Login/list_toko') ?>">Ganti toko <i class="fas fa-exchange-alt"></i></a>
      <?php } ?>
      <a href="<?= base_url('spg/Dashboard/toko_spg/' . $id_toko) ?>">Lihat toko <i class="fas fa-arrow-right"></i></a>
    </div>
  </div>

  <?php if ($bap != 0) { ?>
    <div class="spg-alert" role="alert">
      <span class="spg-alert-icon"><i class="fas fa-exclamation-triangle"></i></span>
      <div>
        <strong>Pengiriman memerlukan perhatian</strong>
        <span>Ada <?= number_format($total_bap, 0, ',', '.') ?> pengiriman dengan selisih. Segera periksa dan buat BAP.</span>
      </div>
    </div>
  <?php } ?>

  <div class="spg-summary-grid">
    <div class="spg-summary-item receipt">
      <span class="spg-summary-icon"><i class="fas fa-box-open"></i></span>
      <div><strong class="spg-summary-value"><?= number_format($total_terima, 0, ',', '.') ?></strong><span class="spg-summary-label">PO menunggu diterima</span></div>
    </div>
    <div class="spg-summary-item mutation">
      <span class="spg-summary-icon"><i class="fas fa-copy"></i></span>
      <div><strong class="spg-summary-value"><?= number_format($total_mutasi, 0, ',', '.') ?></strong><span class="spg-summary-label">Mutasi masuk</span></div>
    </div>
    <div class="spg-summary-item difference">
      <span class="spg-summary-icon"><i class="fas fa-not-equal"></i></span>
      <div><strong class="spg-summary-value"><?= number_format($total_bap, 0, ',', '.') ?></strong><span class="spg-summary-label">Selisih perlu BAP</span></div>
    </div>
  </div>

  <div class="spg-section-heading">
    <div>
      <h2>Akses cepat</h2>
      <p>Menu operasional yang paling sering digunakan.</p>
    </div>
    <?php if ($total_tindakan > 0) { ?><span class="spg-action-count"><?= number_format($total_tindakan, 0, ',', '.') ?> perlu tindakan</span><?php } ?>
  </div>

  <div class="spg-quick-card">
    <div class="spg-quick-grid">
      <a class="spg-quick-item" href="<?= base_url('spg/permintaan') ?>">
        <span class="spg-quick-icon"><i class="fas fa-file-alt"></i></span>
        <span class="spg-quick-label">Permintaan PO</span>
      </a>
      <a class="spg-quick-item" href="<?= base_url('spg/Penerimaan') ?>">
        <span class="spg-quick-icon">
          <?php if ($total_terima > 0) { ?><span class="spg-notif"><?= $total_terima > 99 ? '99+' : $total_terima ?></span><?php } ?>
          <i class="fas fa-check-circle"></i>
        </span>
        <span class="spg-quick-label">Terima PO</span>
      </a>
      <a class="spg-quick-item" href="<?= base_url('spg/penjualan') ?>">
        <span class="spg-quick-icon"><i class="fas fa-shopping-cart"></i></span>
        <span class="spg-quick-label">Penjualan</span>
      </a>
      <a class="spg-quick-item" href="<?= base_url('spg/Dashboard/toko_spg/' . $id_toko) ?>">
        <span class="spg-quick-icon"><i class="fas fa-boxes"></i></span>
        <span class="spg-quick-label">Stok Toko</span>
      </a>
      <a class="spg-quick-item" href="<?= base_url('spg/retur') ?>">
        <span class="spg-quick-icon"><i class="fas fa-exchange-alt"></i></span>
        <span class="spg-quick-label">Retur</span>
      </a>
      <a class="spg-quick-item" href="<?= base_url('spg/Mutasi') ?>">
        <span class="spg-quick-icon">
          <?php if ($total_mutasi > 0) { ?><span class="spg-notif"><?= $total_mutasi > 99 ? '99+' : $total_mutasi ?></span><?php } ?>
          <i class="fas fa-copy"></i>
        </span>
        <span class="spg-quick-label">Terima Mutasi</span>
      </a>
      <a class="spg-quick-item" href="<?= base_url('spg/Aset') ?>">
        <span class="spg-quick-icon"><i class="fas fa-dolly"></i></span>
        <span class="spg-quick-label">Update Aset</span>
      </a>
      <a class="spg-quick-item" href="<?= base_url('spg/Stok_opname') ?>">
        <span class="spg-quick-icon"><i class="fas fa-clipboard-check"></i></span>
        <span class="spg-quick-label">Stok Opname</span>
      </a>
      <a class="spg-quick-item" href="<?= base_url('spg/Bap/selisih') ?>">
        <span class="spg-quick-icon">
          <?php if ($total_bap > 0) { ?><span class="spg-notif"><?= $total_bap > 99 ? '99+' : $total_bap ?></span><?php } ?>
          <i class="fas fa-not-equal"></i>
        </span>
        <span class="spg-quick-label">Selisih Data</span>
      </a>
      <a class="spg-quick-item" href="<?= base_url('spg/Bap') ?>">
        <span class="spg-quick-icon"><i class="fas fa-envelope-open-text"></i></span>
        <span class="spg-quick-label">BAP</span>
      </a>
    </div>
  </div>
</section>

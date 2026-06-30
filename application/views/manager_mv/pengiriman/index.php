<?php
$daftar_pengiriman = is_array($list) ? $list : array();
$total_pengiriman = count($daftar_pengiriman);
$total_perlu_proses = 0;
$total_dikirim = 0;
$total_selesai = 0;
$total_selisih = 0;

foreach ($daftar_pengiriman as $item) {
  $status = (int) $item->status;
  if ($status === 0) {
    $total_perlu_proses++;
  } elseif ($status === 1) {
    $total_dikirim++;
  } elseif ($status === 2) {
    $total_selesai++;
  } else {
    $total_selisih++;
  }
}

$filter_aktif = !empty($tgl) || !empty($kat);
?>

<style>
  .do-page {
    --do-ink: #172033;
    --do-muted: #64748b;
    --do-line: #e7edf4;
    padding: 18px 8px 30px;
    color: var(--do-ink);
  }

  .do-loading {
    position: fixed;
    z-index: 9999;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, .35);
    backdrop-filter: blur(3px);
  }

  .do-loading-box {
    display: flex;
    min-width: 190px;
    align-items: center;
    gap: 12px;
    padding: 17px 20px;
    color: #334155;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 20px 55px rgba(15, 23, 42, .2);
    font-size: 12px;
    font-weight: 700;
  }

  .do-loading-box i { color: #2563eb; font-size: 20px; }

  .do-card {
    overflow: hidden;
    border: 1px solid var(--do-line);
    border-radius: 22px;
    box-shadow: 0 12px 32px rgba(15, 23, 42, .065);
  }

  .do-card > .do-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 26px;
    color: #fff;
    background: radial-gradient(circle at 85% 0, rgba(147, 197, 253, .28), transparent 27%), linear-gradient(125deg, #0f172a 0%, #1d4ed8 62%, #3b82f6 100%);
    border: 0;
  }

  .do-title-wrap { display: flex; min-width: 0; align-items: center; gap: 14px; }
  .do-title-icon {
    display: inline-flex;
    width: 49px;
    height: 49px;
    flex: 0 0 49px;
    align-items: center;
    justify-content: center;
    color: #dbeafe;
    background: rgba(255, 255, 255, .12);
    border: 1px solid rgba(255, 255, 255, .14);
    border-radius: 15px;
    font-size: 20px;
  }

  .do-header h1 { margin: 0 0 4px; font-size: 22px; font-weight: 800; }
  .do-header p { margin: 0; color: rgba(255, 255, 255, .72); font-size: 12px; }
  .do-header-badge {
    padding: 7px 11px;
    color: #dbeafe;
    background: rgba(255, 255, 255, .11);
    border: 1px solid rgba(255, 255, 255, .14);
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
  }

  .do-card > .card-body { padding: 22px 24px 25px; }
  .do-summary {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 11px;
    margin-bottom: 18px;
  }

  .do-stat {
    display: flex;
    min-width: 0;
    align-items: center;
    gap: 10px;
    padding: 14px;
    background: #fff;
    border: 1px solid var(--do-line);
    border-radius: 16px;
  }

  .do-stat-icon {
    display: inline-flex;
    width: 38px;
    height: 38px;
    flex: 0 0 38px;
    align-items: center;
    justify-content: center;
    color: var(--stat-color);
    background: var(--stat-bg);
    border-radius: 11px;
  }

  .do-stat.all { --stat-color: #0369a1; --stat-bg: #e0f2fe; }
  .do-stat.action { --stat-color: #d97706; --stat-bg: #fef3c7; }
  .do-stat.sent { --stat-color: #2563eb; --stat-bg: #dbeafe; }
  .do-stat.done { --stat-color: #15803d; --stat-bg: #dcfce7; }
  .do-stat.issue { --stat-color: #dc2626; --stat-bg: #fee2e2; }
  .do-stat-value { display: block; font-size: 20px; font-weight: 800; line-height: 1.1; }
  .do-stat-label { display: block; overflow: hidden; color: var(--do-muted); font-size: 10px; font-weight: 600; text-overflow: ellipsis; white-space: nowrap; }

  .do-filter {
    margin-bottom: 19px;
    padding: 17px 18px 3px;
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 16px;
  }

  .do-filter-heading { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
  .do-filter-heading strong { font-size: 13px; font-weight: 800; }
  .do-filter-heading span { color: var(--do-muted); font-size: 10px; }
  .do-filter label { margin-bottom: 5px; color: #475569; font-size: 10px; font-weight: 700; }
  .do-filter .form-control { min-height: 38px; padding-right: 12px; padding-left: 12px; background: #fff; border-color: #dbe3ec; border-radius: 10px; font-size: 11px; }
  .do-filter-actions { display: flex; flex-wrap: wrap; align-items: flex-end; gap: 7px; padding-bottom: 16px; }
  .do-filter-actions .btn { min-height: 38px; padding: 9px 14px; border-radius: 10px; font-size: 11px; font-weight: 700; }

  .do-table-wrap { overflow-x: auto; border: 1px solid var(--do-line); border-radius: 16px; }
  .do-table-wrap .dataTables_wrapper { padding-top: 14px; }
  .do-table-wrap .dataTables_length,
  .do-table-wrap .dataTables_filter { padding: 0 14px 10px; color: var(--do-muted); font-size: 11px; }
  .do-table-wrap .dataTables_info { padding: 13px 14px !important; color: var(--do-muted); font-size: 11px; }
  .do-table-wrap .dataTables_paginate { padding: 8px 14px !important; }
  .do-table-wrap .dataTables_filter input,
  .do-table-wrap .dataTables_length select { min-height: 34px; border: 1px solid #dbe3ec; border-radius: 9px; }

  .do-table { width: 100% !important; margin: 0 !important; border: 0 !important; }
  .do-table thead th {
    padding: 12px;
    color: #64748b;
    background: #f8fafc;
    border-color: #e9eff5 !important;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .035em;
    text-transform: uppercase;
    white-space: nowrap;
  }

  .do-table tbody td {
    padding: 14px 12px;
    vertical-align: middle;
    color: #334155;
    border-color: #edf2f7 !important;
    font-size: 11px;
  }

  .do-table tbody tr { background: #fff; transition: background .18s ease; }
  .do-table tbody tr:hover { background: #f8fbfe !important; }
  .do-number { color: #1d4ed8; font-size: 12px; font-weight: 800; white-space: nowrap; }
  .do-store { display: flex; min-width: 170px; align-items: center; gap: 9px; font-weight: 600; }
  .do-store-icon { display: inline-flex; width: 31px; height: 31px; flex: 0 0 31px; align-items: center; justify-content: center; color: #0369a1; background: #e0f2fe; border-radius: 9px; }
  .do-sender { min-width: 130px; font-weight: 600; }
  .do-sender i { margin-right: 6px; color: #94a3b8; }
  .do-date { color: var(--do-muted); white-space: nowrap; }
  .do-date i { margin-right: 5px; color: #94a3b8; }
  .do-table .badge { padding: 6px 9px; border-radius: 999px; font-size: 9px; font-weight: 700; }
  .do-action { display: inline-flex; min-width: 86px; align-items: center; justify-content: center; padding: 7px 11px; border-radius: 9px; font-size: 10px; font-weight: 700; }

  @media (max-width: 1199.98px) {
    .do-summary { grid-template-columns: repeat(3, minmax(0, 1fr)); }
  }

  @media (max-width: 767.98px) {
    .do-page { padding: 10px 0 22px; }
    .do-card { border-radius: 18px; }
    .do-card > .do-header { align-items: flex-start; padding: 21px 18px; }
    .do-header-badge { display: none; }
    .do-card > .card-body { padding: 17px 14px 20px; }
    .do-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .do-filter-actions .btn { flex: 1 1 auto; }
  }

  @media (max-width: 479.98px) {
    .do-summary { gap: 8px; }
    .do-stat { gap: 8px; padding: 11px; }
    .do-stat-icon { width: 35px; height: 35px; flex-basis: 35px; }
    .do-stat-value { font-size: 18px; }
  }
</style>

<section class="content do-page">
  <div class="container-fluid">
    <div id="loading" class="do-loading" style="display: none;" aria-live="polite" aria-busy="true">
      <div class="do-loading-box"><i class="fas fa-circle-notch fa-spin"></i><span>Memuat data pengiriman...</span></div>
    </div>
    <div class="col-12">
      <div class="card do-card">
        <div class="card-header do-header">
          <div class="do-title-wrap">
            <span class="do-title-icon"><i class="fas fa-shipping-fast"></i></span>
            <div>
              <h1>Pengiriman Barang (DO)</h1>
              <p>Pantau proses pengiriman, status penerimaan, dan dokumen tujuan toko.</p>
            </div>
          </div>
          <span class="do-header-badge"><i class="fas fa-sync-alt mr-1"></i><?= $filter_aktif ? 'Hasil filter' : '500 data terbaru' ?></span>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="do-summary">
            <div class="do-stat all">
              <span class="do-stat-icon"><i class="fas fa-clipboard-list"></i></span>
              <div><strong class="do-stat-value"><?= number_format($total_pengiriman, 0, ',', '.') ?></strong><span class="do-stat-label">DO ditampilkan</span></div>
            </div>
            <div class="do-stat action">
              <span class="do-stat-icon"><i class="fas fa-hourglass-half"></i></span>
              <div><strong class="do-stat-value"><?= number_format($total_perlu_proses, 0, ',', '.') ?></strong><span class="do-stat-label">Perlu diproses</span></div>
            </div>
            <div class="do-stat sent">
              <span class="do-stat-icon"><i class="fas fa-truck"></i></span>
              <div><strong class="do-stat-value"><?= number_format($total_dikirim, 0, ',', '.') ?></strong><span class="do-stat-label">Sedang dikirim</span></div>
            </div>
            <div class="do-stat done">
              <span class="do-stat-icon"><i class="fas fa-check-circle"></i></span>
              <div><strong class="do-stat-value"><?= number_format($total_selesai, 0, ',', '.') ?></strong><span class="do-stat-label">Selesai</span></div>
            </div>
            <div class="do-stat issue">
              <span class="do-stat-icon"><i class="fas fa-exclamation-triangle"></i></span>
              <div><strong class="do-stat-value"><?= number_format($total_selisih, 0, ',', '.') ?></strong><span class="do-stat-label">Terdapat selisih</span></div>
            </div>
          </div>

          <div class="do-filter">
            <div class="do-filter-heading">
              <strong><i class="fas fa-filter mr-1 text-primary"></i> Filter data</strong>
              <span>Cari berdasarkan DO, toko, atau periode</span>
            </div>
          <form action="<?= base_url('sup/Pengiriman') ?>" method="post" id="form_cari">
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label for="kategori">Nomor DO atau nama toko</label>
                  <input type="text" id="kategori" name="kategori" value="<?= !empty($kat) ? html_escape($kat) : '' ?>" class="form-control form-control-sm" placeholder="Contoh: DO-001 atau nama toko">

                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="tanggal">Rentang tanggal</label>
                  <input type="text" id="tanggal" name="tanggal" value="<?= !empty($tgl) ? html_escape($tgl) : '' ?>" class="form-control form-control-sm" autocomplete="off" placeholder="Pilih periode">
                </div>
              </div>
              <div class="col-md-3 do-filter-actions">
                <button type="submit" class="btn btn-primary btn-sm" id="btn_cari"><i class="fas fa-search mr-1"></i> Tampilkan</button>
                <?php if ($filter_aktif) { ?><a href="<?= base_url('sup/Pengiriman') ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-times-circle mr-1"></i> Reset</a><?php } ?>
              </div>
            </div>
          </form>
          </div>

          <div class="do-table-wrap">
          <table id="example1" class="table do-table">
            <thead>
              <tr class="text-center">
                <th style="width: 2%">No.</th>
                <th style="width:16%">Nomor DO</th>
                <th>Status</th>
                <th>Toko tujuan</th>
                <th>Pengirim</th>
                <th>Tanggal dibuat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              foreach ($daftar_pengiriman as $data) :
                $no++; ?>
                <tr>
                  <td class="text-center"><?= $no ?></td>
                  <td class="text-center">
                    <span class="do-number">#<?= html_escape($data->id) ?></span>
                  </td>
                  <td class="text-center">
                    <?=
                    status_pengiriman($data->status);
                    ?>
                  </td>
                  <td><span class="do-store"><span class="do-store-icon"><i class="fas fa-store"></i></span><?= html_escape($data->nama_toko) ?></span></td>
                  <td class="text-center"><span class="do-sender"><i class="fas fa-user"></i><?= html_escape($data->nama_user) ?></span></td>
                  <td class="text-center do-date">
                    <?php if (!empty($data->created_at)) { ?>
                      <i class="far fa-clock"></i><?= date('d M Y, H:i', strtotime($data->created_at)) ?>
                    <?php } else { ?>
                      <span class="text-muted">Tanggal belum tersedia</span>
                    <?php } ?>
                  </td>
                  <td class="text-center">
                    <?php
                    if ($data->status == 0) {
                    ?>
                      <a class="btn btn-success btn-sm do-action" href="<?= base_url('sup/Pengiriman/detail/' . rawurlencode($data->id)) ?>" name="btn_proses"><i class="fas fa-paper-plane mr-1"></i> Proses</a>
                    <?php
                    } else {
                    ?>
                      <a class="btn btn-primary btn-sm do-action" href="<?= base_url('sup/Pengiriman/detail/' . rawurlencode($data->id)) ?>" name="btn_detail"><i class="fas fa-eye mr-1"></i> Detail</a>
                    <?php }
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
  <!-- /.container-fluid -->
</section>
<script>
  $(function() {
    var $tanggal = $('input[name="tanggal"]');

    if ($tanggal.length) {
      $tanggal.daterangepicker({
        autoUpdateInput: false,
        locale: {
          applyLabel: 'Terapkan',
          cancelLabel: 'Hapus',
          format: 'YYYY-MM-DD'
        }
      });

      $tanggal.on('apply.daterangepicker', function(event, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
      });

      $tanggal.on('cancel.daterangepicker', function() {
        $(this).val('');
      });
    }

    $('#form_cari').on('submit', function() {
      $('#loading').css('display', 'flex');
      $('#btn_cari').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-1"></i> Memuat...');
    });
  });
</script>

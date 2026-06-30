<?php
$daftar_permintaan = is_array($list) ? $list : array();
$total_permintaan = count($daftar_permintaan);
$total_perlu_proses = 0;
$total_disetujui = 0;
$total_pemenuhan = 0;

foreach ($daftar_permintaan as $item) {
  $status = (int) $item->status;
  if ($status === 1 || $status === 7) {
    $total_perlu_proses++;
  } elseif ($status === 2) {
    $total_disetujui++;
  } elseif ($status === 3 || $status === 4) {
    $total_pemenuhan++;
  }
}

$filter_aktif = !empty($tgl) || !empty($kat);
?>

<style>
  .po-page {
    --po-ink: #172033;
    --po-muted: #64748b;
    --po-line: #e7edf4;
    padding: 18px 8px 30px;
    color: var(--po-ink);
  }

  .po-loading {
    position: fixed;
    z-index: 9999;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, .35);
    backdrop-filter: blur(3px);
  }

  .po-loading-box {
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

  .po-loading-box i { color: #0284c7; font-size: 20px; }

  .po-card {
    overflow: hidden;
    border: 1px solid var(--po-line);
    border-radius: 22px;
    box-shadow: 0 12px 32px rgba(15, 23, 42, .065);
  }

  .po-card > .po-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 26px;
    color: #fff;
    background: radial-gradient(circle at 85% 0, rgba(94, 234, 212, .24), transparent 27%), linear-gradient(125deg, #0f172a 0%, #0f766e 62%, #14b8a6 100%);
    border: 0;
  }

  .po-title-wrap { display: flex; min-width: 0; align-items: center; gap: 14px; }
  .po-title-icon {
    display: inline-flex;
    width: 49px;
    height: 49px;
    flex: 0 0 49px;
    align-items: center;
    justify-content: center;
    color: #ccfbf1;
    background: rgba(255, 255, 255, .12);
    border: 1px solid rgba(255, 255, 255, .14);
    border-radius: 15px;
    font-size: 20px;
  }

  .po-header h1 { margin: 0 0 4px; font-size: 22px; font-weight: 800; }
  .po-header p { margin: 0; color: rgba(255, 255, 255, .72); font-size: 12px; }
  .po-header-badge {
    padding: 7px 11px;
    color: #ccfbf1;
    background: rgba(255, 255, 255, .11);
    border: 1px solid rgba(255, 255, 255, .14);
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
  }

  .po-card > .card-body { padding: 22px 24px 25px; }
  .po-summary {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 12px;
    margin-bottom: 18px;
  }

  .po-stat {
    display: flex;
    min-width: 0;
    align-items: center;
    gap: 12px;
    padding: 15px;
    background: #fff;
    border: 1px solid var(--po-line);
    border-radius: 16px;
  }

  .po-stat-icon {
    display: inline-flex;
    width: 40px;
    height: 40px;
    flex: 0 0 40px;
    align-items: center;
    justify-content: center;
    color: var(--stat-color);
    background: var(--stat-bg);
    border-radius: 12px;
  }

  .po-stat.all { --stat-color: #0369a1; --stat-bg: #e0f2fe; }
  .po-stat.action { --stat-color: #d97706; --stat-bg: #fef3c7; }
  .po-stat.approved { --stat-color: #15803d; --stat-bg: #dcfce7; }
  .po-stat.delivery { --stat-color: #7c3aed; --stat-bg: #ede9fe; }
  .po-stat-value { display: block; font-size: 21px; font-weight: 800; line-height: 1.1; }
  .po-stat-label { color: var(--po-muted); font-size: 10px; font-weight: 600; }

  .po-filter {
    margin-bottom: 19px;
    padding: 17px 18px 3px;
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 16px;
  }

  .po-filter-heading { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
  .po-filter-heading strong { font-size: 13px; font-weight: 800; }
  .po-filter-heading span { color: var(--po-muted); font-size: 10px; }
  .po-filter label { margin-bottom: 5px; color: #475569; font-size: 10px; font-weight: 700; }
  .po-filter .form-control { min-height: 38px; padding-right: 12px; padding-left: 12px; background: #fff; border-color: #dbe3ec; border-radius: 10px; font-size: 11px; }
  .po-filter .form-control[readonly] { color: #475569; background: #f1f5f9; }
  .po-filter-actions { display: flex; flex-wrap: wrap; align-items: flex-end; gap: 7px; padding-bottom: 16px; }
  .po-filter-actions .btn { min-height: 38px; padding: 9px 14px; border-radius: 10px; font-size: 11px; font-weight: 700; }

  .po-table-wrap { overflow-x: auto; border: 1px solid var(--po-line); border-radius: 16px; }
  .po-table-wrap .dataTables_wrapper { padding-top: 14px; }
  .po-table-wrap .dataTables_length,
  .po-table-wrap .dataTables_filter { padding: 0 14px 10px; color: var(--po-muted); font-size: 11px; }
  .po-table-wrap .dataTables_info { padding: 13px 14px !important; color: var(--po-muted); font-size: 11px; }
  .po-table-wrap .dataTables_paginate { padding: 8px 14px !important; }
  .po-table-wrap .dataTables_filter input,
  .po-table-wrap .dataTables_length select { min-height: 34px; border: 1px solid #dbe3ec; border-radius: 9px; }

  .po-table { width: 100% !important; margin: 0 !important; border: 0 !important; }
  .po-table thead th {
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

  .po-table tbody td {
    padding: 14px 12px;
    vertical-align: middle;
    color: #334155;
    border-color: #edf2f7 !important;
    font-size: 11px;
  }

  .po-table tbody tr { background: #fff; transition: background .18s ease; }
  .po-table tbody tr:hover { background: #f8fbfe !important; }
  .po-number { color: #0f766e; font-size: 12px; font-weight: 800; white-space: nowrap; }
  .po-store { display: flex; min-width: 180px; align-items: center; gap: 9px; font-weight: 600; }
  .po-store-icon { display: inline-flex; width: 31px; height: 31px; flex: 0 0 31px; align-items: center; justify-content: center; color: #0369a1; background: #e0f2fe; border-radius: 9px; }
  .po-date { color: var(--po-muted); white-space: nowrap; }
  .po-date i { margin-right: 5px; color: #94a3b8; }
  .po-table .badge { padding: 6px 9px; border-radius: 999px; font-size: 9px; font-weight: 700; }
  .po-action { display: inline-flex; min-width: 86px; align-items: center; justify-content: center; padding: 7px 11px; border-radius: 9px; font-size: 10px; font-weight: 700; }

  @media (max-width: 991.98px) {
    .po-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  }

  @media (max-width: 767.98px) {
    .po-page { padding: 10px 0 22px; }
    .po-card { border-radius: 18px; }
    .po-card > .po-header { align-items: flex-start; padding: 21px 18px; }
    .po-header-badge { display: none; }
    .po-card > .card-body { padding: 17px 14px 20px; }
    .po-filter-actions .btn { width: 100%; }
  }

  @media (max-width: 479.98px) {
    .po-summary { gap: 8px; }
    .po-stat { gap: 9px; padding: 12px; }
    .po-stat-icon { width: 36px; height: 36px; flex-basis: 36px; }
    .po-stat-value { font-size: 18px; }
  }
</style>

<section class="content po-page">
  <div class="container-fluid">
    <div id="loading" class="po-loading" style="display: none;" aria-live="polite" aria-busy="true">
      <div class="po-loading-box"><i class="fas fa-circle-notch fa-spin"></i><span>Memuat data permintaan...</span></div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card po-card">
          <div class="card-header po-header">
            <div class="po-title-wrap">
              <span class="po-title-icon"><i class="fas fa-file-invoice"></i></span>
              <div>
                <h1>Permintaan Barang (PO)</h1>
                <p>Pantau, tinjau, dan tindak lanjuti permintaan barang dari seluruh toko.</p>
              </div>
            </div>
            <span class="po-header-badge"><i class="fas fa-sync-alt mr-1"></i><?= $filter_aktif ? 'Hasil filter' : 'Data aktif' ?></span>
          </div>
          <div class="card-body">
            <div class="po-summary">
              <div class="po-stat all">
                <span class="po-stat-icon"><i class="fas fa-file-alt"></i></span>
                <div><strong class="po-stat-value"><?= number_format($total_permintaan, 0, ',', '.') ?></strong><span class="po-stat-label">PO ditampilkan</span></div>
              </div>
              <div class="po-stat action">
                <span class="po-stat-icon"><i class="fas fa-hourglass-half"></i></span>
                <div><strong class="po-stat-value"><?= number_format($total_perlu_proses, 0, ',', '.') ?></strong><span class="po-stat-label">Perlu diproses</span></div>
              </div>
              <div class="po-stat approved">
                <span class="po-stat-icon"><i class="fas fa-check-circle"></i></span>
                <div><strong class="po-stat-value"><?= number_format($total_disetujui, 0, ',', '.') ?></strong><span class="po-stat-label">Telah disetujui</span></div>
              </div>
              <div class="po-stat delivery">
                <span class="po-stat-icon"><i class="fas fa-truck-loading"></i></span>
                <div><strong class="po-stat-value"><?= number_format($total_pemenuhan, 0, ',', '.') ?></strong><span class="po-stat-label">Proses pemenuhan</span></div>
              </div>
            </div>

            <div class="po-filter">
              <div class="po-filter-heading">
                <strong><i class="fas fa-filter mr-1 text-info"></i> Filter data</strong>
                <span>Cari berdasarkan PO, toko, atau periode</span>
              </div>
            <form action="<?= base_url('sup/Permintaan') ?>" method="post" id="form_cari">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="kategori">Nomor PO atau nama toko</label>
                    <input type="text" id="kategori" name="kategori" value="<?= !empty($kat) ? html_escape($kat) : '' ?>" class="form-control form-control-sm" placeholder="Contoh: PO-001 atau nama toko">

                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="tanggal">Rentang tanggal</label>
                    <input type="text" id="tanggal" name="tanggal" value="<?= !empty($tgl) ? html_escape($tgl) : '' ?>" class="form-control form-control-sm" autocomplete="off" placeholder="Pilih periode">
                  </div>
                </div>
                <div class="col-md-3 po-filter-actions">
                  <button type="submit" class="btn btn-info btn-sm" id="btn_cari"><i class="fas fa-search mr-1"></i> Tampilkan</button>
                  <?php if ($filter_aktif) { ?><a href="<?= base_url('sup/Permintaan') ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-times-circle mr-1"></i> Reset</a><?php } ?>
                </div>
              </div>
            </form>
            </div>

            <div class="po-table-wrap">
            <table id="example1" class="table po-table">
              <thead>
                <tr class="text-center">
                  <th style="width: 2%">No.</th>
                  <th>Nomor PO</th>
                  <th>Status</th>
                  <th>Toko</th>
                  <th>Terakhir diperbarui</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($daftar_permintaan as $data) :
                  $no++; ?>
                  <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td class="text-center"><span class="po-number">#<?= html_escape($data->id) ?></span></td>
                    <td class="text-center">
                      <?php
                      status_permintaan($data->status);
                      ?>
                    </td>
                    <td><span class="po-store"><span class="po-store-icon"><i class="fas fa-store"></i></span><?= html_escape($data->nama_toko) ?></span></td>
                    <td class="text-center po-date">
                      <?php if ($data->updated_at != NULL) { ?>
                        <i class="far fa-clock"></i><?= date('d M Y, H:i', strtotime($data->updated_at)) ?>
                      <?php } else { ?>
                        <span class="text-muted">Belum diperbarui</span>
                      <?php } ?>
                    </td>
                    <td class="text-center">
                      <?php
                      if ($data->status == 1 || $data->status == 7) {
                      ?>
                        <a class="btn btn-success btn-sm po-action" href="<?= base_url('sup/permintaan/terima/' . rawurlencode($data->id)) ?>"><i class="fas fa-paper-plane mr-1"></i> Proses</a>
                      <?php
                      } else {
                      ?>
                        <a class="btn btn-primary btn-sm po-action" href="<?= base_url('sup/permintaan/detail/' . rawurlencode($data->id)) ?>"><i class="fas fa-eye mr-1"></i> Detail</a>
                      <?php }
                      ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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

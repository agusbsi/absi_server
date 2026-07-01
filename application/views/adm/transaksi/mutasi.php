<?php
$total_mutasi = is_array($list) ? count($list) : 0;
$total_verifikasi = $total_transfer = $total_selesai = 0;
if (!empty($list)) foreach ($list as $item) {
  $status = (int) $item->status;
  if (in_array($status, array(0, 6), true)) $total_verifikasi++;
  elseif ($status === 1) $total_transfer++;
  elseif (in_array($status, array(2, 5), true)) $total_selesai++;
}
?>
<style>
  #loading {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(255, 255, 255, 0.7);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .loader {
    position: relative;
    width: 200px;
    height: 200px;
  }

  .circle {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: conic-gradient(#3498db 0deg, #3498db 0deg, transparent 0deg);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .percentage {
    position: absolute;
    font-size: 2em;
    font-weight: bold;
    color: #ffc107;
  }

  .img-nodata {
    width: 100%;

  }
  .mutation-page{--primary:#2563eb;--muted:#64748b;--line:#e2e8f0;color:#0f172a}.mutation-page .page-hero{display:flex;align-items:center;justify-content:space-between;padding:25px 27px;margin-bottom:18px;border-radius:19px;color:#fff;background:linear-gradient(125deg,#172554,#1d4ed8 75%,#38bdf8 140%);box-shadow:0 13px 32px rgba(30,64,175,.17)}.mutation-page .page-hero h2{margin:0 0 6px;font-size:25px;font-weight:700}.mutation-page .page-hero p{margin:0;color:rgba(255,255,255,.78);font-size:12px}.mutation-page .hero-icon{display:flex;width:60px;height:60px;align-items:center;justify-content:center;border-radius:17px;background:rgba(255,255,255,.13);font-size:25px}
  .mutation-page .stat-card{display:flex;align-items:center;height:100%;min-height:88px;padding:16px 18px;border:1px solid var(--line);border-radius:15px;background:#fff;box-shadow:0 4px 16px rgba(15,23,42,.04)}.mutation-page .stat-icon{display:flex;width:43px;height:43px;align-items:center;justify-content:center;margin-right:12px;border-radius:12px;color:#2563eb;background:#eff6ff}.mutation-page .stat-icon.amber{color:#d97706;background:#fffbeb}.mutation-page .stat-icon.cyan{color:#0891b2;background:#ecfeff}.mutation-page .stat-icon.green{color:#059669;background:#ecfdf5}.mutation-page .stat-label{display:block;color:var(--muted);font-size:11px;font-weight:600}.mutation-page .stat-value{display:block;font-size:21px;line-height:1.2}
  .mutation-page .flow-note{display:flex;padding:13px 15px;margin:5px 0 18px;border:1px solid #bfdbfe;border-radius:12px;color:#475569;background:#eff6ff;font-size:11px}.mutation-page .flow-note i{margin:2px 9px 0 0;color:#2563eb}.mutation-page .flow-note strong{color:#1e3a8a}.mutation-page .mutation-card{overflow:hidden;border:1px solid var(--line);border-radius:16px;box-shadow:0 5px 18px rgba(15,23,42,.05)}.mutation-page .mutation-card>.card-header{display:flex;align-items:center;justify-content:space-between;padding:19px 21px;border:0;color:#0f172a;background:#fff}.mutation-page .mutation-card .card-title{margin:0;font-size:16px;font-weight:700}.mutation-page .mutation-card>.card-header small{color:var(--muted)}.mutation-page .mutation-card>.card-body{padding:0 20px 20px}.mutation-page .filter-panel{padding:16px 17px;margin-bottom:16px;border:1px solid var(--line);border-radius:13px;background:#f8fafc}.mutation-page .filter-panel .form-group{margin:0}.mutation-page .filter-panel label{margin-bottom:6px;color:#475569;font-size:10px;font-weight:700;text-transform:uppercase}.mutation-page .filter-panel .form-control{height:39px;border-color:#cbd5e1;border-radius:9px;font-size:11px}.mutation-page .filter-actions{display:flex;height:100%;align-items:flex-end}.mutation-page .filter-actions .btn{height:39px;padding:0 14px;border-radius:9px;font-size:11px;font-weight:700}.mutation-page .table thead th{padding:13px 11px;border-width:1px 0;border-color:var(--line);color:#475569;background:#f8fafc;font-size:10px;font-weight:700;text-transform:uppercase}.mutation-page .table tbody td{padding:14px 11px;border-color:#f1f5f9;vertical-align:middle}.mutation-page .mutation-number{color:#1d4ed8;font-size:11px;font-weight:700}.mutation-page .route-item{display:block;color:#475569;font-size:10px;line-height:1.55}.mutation-page .route-item b{color:#0f172a}.mutation-page td .badge{padding:6px 9px;border-radius:20px;font-size:9px}.mutation-page .date-text{color:#475569;font-size:10px;white-space:nowrap}.mutation-page .detail-action{display:inline-flex;height:34px;align-items:center;padding:0 12px;border:1px solid #bfdbfe;border-radius:9px;color:#1d4ed8;background:#eff6ff;font-size:11px;font-weight:700}.mutation-page .detail-action:hover{color:#fff;background:#2563eb;text-decoration:none}.mutation-page #loading{background:rgba(15,23,42,.42);backdrop-filter:blur(3px)}.mutation-page .loader{width:130px;height:130px;padding:9px;border-radius:22px;background:#fff;box-shadow:0 20px 50px rgba(15,23,42,.25)}.mutation-page .circle{background:conic-gradient(#2563eb 0deg,transparent 0deg)}.mutation-page .percentage{color:#1d4ed8;font-size:22px}
  @media(max-width:767.98px){.mutation-page .page-hero{padding:21px}.mutation-page .page-hero h2{font-size:22px}.mutation-page .hero-icon{display:none}.mutation-page .stat-card{margin-bottom:12px;height:auto}.mutation-page .mutation-card>.card-header{align-items:flex-start;flex-direction:column}.mutation-page .mutation-card>.card-body{padding:0 13px 15px}.mutation-page .filter-panel .form-group{margin-bottom:12px}.mutation-page .filter-actions .btn{width:100%}}
</style>
<section class="content mutation-page">
  <div class="container-fluid">
    <div id="loading" style="display: none;">
      <div class="loader">
        <div class="circle">
          <div class="percentage" id="percentage">0%</div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="page-hero"><div><h2>Mutasi Artikel</h2><p>Pantau perpindahan stok artikel dari toko asal menuju toko tujuan beserta proses verifikasinya.</p></div><div class="hero-icon"><i class="fas fa-exchange-alt"></i></div></div>
        <div class="row">
          <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon"><i class="fas fa-copy"></i></div><div><span class="stat-label">Total Mutasi</span><strong class="stat-value"><?= number_format($total_mutasi, 0, ',', '.') ?></strong></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon amber"><i class="fas fa-search"></i></div><div><span class="stat-label">Verifikasi</span><strong class="stat-value"><?= number_format($total_verifikasi, 0, ',', '.') ?></strong></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon cyan"><i class="fas fa-truck-moving"></i></div><div><span class="stat-label">Proses Transfer</span><strong class="stat-value"><?= number_format($total_transfer, 0, ',', '.') ?></strong></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon green"><i class="fas fa-check-circle"></i></div><div><span class="stat-label">Selesai</span><strong class="stat-value"><?= number_format($total_selesai, 0, ',', '.') ?></strong></div></div></div>
        </div>
        <div class="flow-note"><i class="fas fa-info-circle"></i><div><strong>Informasi:</strong> proses verifikasi mutasi ditangani oleh Manager Operasional dan Manager Marketing.</div></div>
        <div class="card mutation-card">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-list-ul mr-2 text-primary"></i><?= html_escape($title) ?></h3><small><?= number_format($total_mutasi, 0, ',', '.') ?> data ditemukan</small>
          </div>
          <div class="card-body">
            <div class="alert alert-success alert-dismissible d-none">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <i class="icon fas fa-info"></i>
              <small>Info : Proses verifikasi Mutasi sekarang berpindah ke manager operasional dan manager marketing. </small>
            </div>
            <form action="<?= base_url('adm/Mutasi') ?>" method="post" id="form_cari" class="filter-panel">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label>Kategori</label>
                    <?php if (empty($kat)) { ?>
                      <input type="text" name="kategori" value="<?= !empty($kat) ? html_escape($kat) : '' ?>" class="form-control form-control-sm" placeholder="Cari berdasarkan Nomor atau Nama Toko">
                    <?php } else { ?>
                      <input type="text" class="form-control form-control-sm" value="<?= html_escape($kat) ?>" readonly>
                    <?php } ?>

                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Range Tanggal</label>
                    <?php if (empty($tgl)) { ?>
                      <input type="text" name="tanggal" class="form-control form-control-sm" autocomplete="off" placeholder="Periode">
                    <?php } else { ?>
                      <input type="text" class="form-control form-control-sm" value="<?= html_escape($tgl) ?>" readonly>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-3"><div class="filter-actions">
                  <?php if (!empty($tgl) || !empty($kat)) { ?>
                    <a href="<?= base_url('adm/Mutasi') ?>" class="btn btn-light border"><i class="fas fa-times-circle mr-1"></i>Reset Filter</a>
                  <?php } else { ?>
                    <button class="btn btn-primary" id="btn_cari"><i class="fas fa-search mr-1"></i>Cari Data</button>
                  <?php } ?>
                </div></div>
              </div>
            </form>
            <div class="table-responsive"><table id="example1" class="table">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Nomor</th>
                  <th>Nama Toko</th>
                  <th>Status</th>
                  <th>Tgl Buat</th>
                  <th>Tgl Terima</th>
                  <th>Menu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($list as $row) {
                  $no++; ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td class="text-center"><span class="mutation-number"><?= html_escape($row->id) ?></span></td>
                    <td><span class="route-item"><b>Asal:</b> <?= html_escape($row->pengirim) ?></span><span class="route-item"><b>Tujuan:</b> <?= html_escape($row->tujuan) ?></span></td>
                    <td class="text-center"><?= status_mutasi($row->status) ?></td>
                    <td class="text-center"><span class="date-text"><?= date('d M Y, H:i', strtotime($row->created_at)) ?></span></td>
                    <td class="text-center"><span class="date-text"><?= $row->tgl_terima ? date('d M Y', strtotime($row->tgl_terima)) : "-" ?></span></td>
                    <td class="text-center"><a class="detail-action" href="<?= base_url('adm/Mutasi/detail/' . rawurlencode($row->id)) ?>"><i class="fa fa-eye mr-1"></i>Detail</a></td>
                  </tr>
                <?php } ?>
                <?php if (empty($list)) : ?><tr><td colspan="7" class="text-center text-muted py-5"><i class="fas fa-exchange-alt fa-2x d-block mb-2"></i>Belum ada data mutasi.</td></tr><?php endif; ?>
              </tbody>
            </table></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
<script>
  $(document).ready(function() {
    $('input[name="tanggal"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
        cancelLabel: 'Clear'
      }
    });

    $('input[name="tanggal"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('input[name="tanggal"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });
  })
  var searchButton = document.getElementById('btn_cari');
  if (searchButton) searchButton.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent form submission

    var loadingElement = document.getElementById('loading');
    loadingElement.style.display = 'flex';
    var percentageElement = document.getElementById('percentage');
    var circle = document.querySelector('.circle');
    var percentage = 0;
    var intervalTime = 50; // Update every 50ms
    var intervalDuration = 500; // 2 seconds

    var interval = setInterval(() => {
      if (percentage < 100) {
        percentage += 5;
        percentageElement.textContent = Math.round(percentage) + '%';
        var angle = percentage * 3.6;
        circle.style.background = `conic-gradient(
                #3498db 0deg,
                #3498db ${angle}deg,
                transparent ${angle}deg,
                transparent 360deg
            )`;
      } else {
        clearInterval(interval);
        setTimeout(() => {
          document.getElementById('form_cari').submit();
        }, intervalDuration);
      }
    }, intervalTime);
  });
</script>

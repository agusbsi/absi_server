<?php
$total_pengajuan = is_array($pengajuan) ? count($pengajuan) : 0;
$total_proses = $total_selesai = $total_ditolak = 0;
if (!empty($pengajuan)) foreach ($pengajuan as $item) {
  if ((int) $item->status === 4) $total_selesai++;
  elseif (in_array((int) $item->status, array(0, 1, 2, 3, 6), true)) $total_proses++;
  else $total_ditolak++;
}
?>
<style>
  .submission-page{--primary:#2563eb;--muted:#64748b;--line:#e2e8f0;color:#0f172a}.submission-page .page-hero{display:flex;align-items:center;justify-content:space-between;padding:25px 27px;margin-bottom:18px;border-radius:19px;color:#fff;background:linear-gradient(125deg,#172554,#1d4ed8 75%,#38bdf8 140%);box-shadow:0 13px 32px rgba(30,64,175,.17)}.submission-page .page-hero h2{margin:0 0 7px;font-size:25px;font-weight:700}.submission-page .page-hero p{max-width:650px;margin:0;color:rgba(255,255,255,.79);font-size:13px}.submission-page .hero-icon{display:flex;width:60px;height:60px;align-items:center;justify-content:center;border-radius:17px;background:rgba(255,255,255,.13);font-size:25px}
  .submission-page .stat-card{display:flex;align-items:center;height:100%;min-height:88px;padding:16px 18px;border:1px solid var(--line);border-radius:15px;background:#fff;box-shadow:0 4px 16px rgba(15,23,42,.04)}.submission-page .stat-icon{display:flex;width:43px;height:43px;align-items:center;justify-content:center;margin-right:12px;border-radius:12px;color:#2563eb;background:#eff6ff}.submission-page .stat-icon.amber{color:#d97706;background:#fffbeb}.submission-page .stat-icon.green{color:#059669;background:#ecfdf5}.submission-page .stat-icon.red{color:#dc2626;background:#fef2f2}.submission-page .stat-label{display:block;color:var(--muted);font-size:11px;font-weight:600}.submission-page .stat-value{display:block;font-size:21px;line-height:1.2}
  .submission-page .info-banner{display:flex;align-items:center;padding:15px 17px;margin:5px 0 18px;border:1px solid #bfdbfe;border-radius:14px;color:#475569;background:#eff6ff;font-size:12px}.submission-page .info-banner i{margin-right:12px;color:#2563eb;font-size:20px}.submission-page .info-banner strong{display:block;color:#1e3a8a;font-size:13px}.submission-page .menu-panel{overflow:hidden;margin-bottom:20px;border:1px solid #dbeafe;border-radius:17px;background:#f8fbff;box-shadow:0 6px 20px rgba(30,64,175,.06)}.submission-page .menu-heading{display:flex;align-items:center;justify-content:space-between;padding:17px 19px;border-bottom:1px solid #dbeafe;background:#fff}.submission-page .menu-title{display:flex;align-items:center}.submission-page .menu-title-icon{display:flex;width:38px;height:38px;align-items:center;justify-content:center;margin-right:11px;border-radius:11px;color:#fff;background:#2563eb}.submission-page .menu-heading h3{margin:0;color:#0f172a;font-size:16px;font-weight:700}.submission-page .menu-heading p{margin:2px 0 0;color:var(--muted);font-size:12px}.submission-page .menu-heading .menu-label{padding:5px 10px;border-radius:20px;color:#1d4ed8;background:#eff6ff;font-size:10px;font-weight:700;text-transform:uppercase}.submission-page .action-grid{padding:16px 16px 4px;margin:0}.submission-page .action-grid>div{margin-bottom:12px}.submission-page .action-card{display:flex;align-items:center;height:100%;min-height:88px;padding:16px;border:1px solid #dbe3ee;border-radius:13px;color:#0f172a;background:#fff;transition:.2s ease}.submission-page .action-card:hover{border-color:#93c5fd;color:#1d4ed8;text-decoration:none;transform:translateY(-2px);box-shadow:0 8px 20px rgba(15,23,42,.08)}.submission-page .action-card.danger:hover{border-color:#fecaca;color:#b91c1c}.submission-page .action-icon{display:flex;flex:0 0 44px;height:44px;align-items:center;justify-content:center;margin-right:12px;border-radius:12px;color:#2563eb;background:#eff6ff;font-size:18px}.submission-page .action-card.danger .action-icon{color:#dc2626;background:#fef2f2}.submission-page .action-card strong{display:block;margin-bottom:2px;font-size:13px}.submission-page .action-card small{display:block;color:var(--muted);line-height:1.35}.submission-page .action-card .arrow{margin-left:auto;color:#94a3b8;font-size:11px}
  .submission-page .submission-card{overflow:hidden;border:1px solid var(--line);border-radius:16px;box-shadow:0 5px 18px rgba(15,23,42,.05)}.submission-page .submission-card>.card-header{display:flex;align-items:center;justify-content:space-between;padding:19px 21px;border:0;color:#0f172a;background:#fff}.submission-page .submission-card .card-title{margin:0;font-size:16px;font-weight:700}.submission-page .submission-card>.card-header small{color:var(--muted)}.submission-page .submission-card>.card-body{padding:0 20px 20px}.submission-page .table thead th{padding:13px 11px;border-width:1px 0;border-color:var(--line);color:#475569;background:#f8fafc;font-size:11px;font-weight:700;text-transform:uppercase}.submission-page .table tbody td{padding:15px 11px;border-color:#f1f5f9;vertical-align:middle}.submission-page .submission-number{color:#1d4ed8;font-size:12px}.submission-page .store-name{display:block;margin-bottom:3px;color:#0f172a;font-size:13px}.submission-page address{max-width:390px;margin:0;color:var(--muted);font-size:11px}.submission-page td .badge{padding:6px 9px;border-radius:20px;font-size:10px}.submission-page .row-actions{display:inline-flex;align-items:center;justify-content:center;white-space:nowrap}.submission-page .row-action{display:inline-flex;height:34px;align-items:center;justify-content:center;padding:0 12px;border:1px solid #bfdbfe;border-radius:9px;color:#1d4ed8;background:#eff6ff;font-size:11px;font-weight:700;transition:.18s ease}.submission-page .row-action:hover{border-color:#2563eb;color:#fff;background:#2563eb;text-decoration:none;transform:translateY(-1px)}.submission-page .row-action i{margin-right:6px}.submission-page .row-action.print-action{width:34px;padding:0;margin-left:6px;border-color:#d1fae5;color:#047857;background:#ecfdf5}.submission-page .row-action.print-action i{margin:0}.submission-page .row-action.print-action:hover{border-color:#059669;color:#fff;background:#059669}.submission-page .empty-row{padding:38px!important;color:var(--muted);text-align:center}
  .submission-modal .modal-content{overflow:hidden;border:0;border-radius:17px;box-shadow:0 20px 50px rgba(15,23,42,.2)}.submission-modal .modal-header{padding:18px 20px;border:0}.submission-modal .modal-body{padding:20px}.submission-modal .verification-list{margin:15px 0 0;padding:0;list-style:none}.submission-modal .verification-list li{display:flex;align-items:center;padding:10px 0;border-bottom:1px solid #f1f5f9;font-size:12px}.submission-modal .step-number{display:flex;width:27px;height:27px;align-items:center;justify-content:center;margin-right:10px;border-radius:50%;color:#2563eb;background:#eff6ff;font-weight:700}.submission-modal .btn{border-radius:9px}
  @media(max-width:767.98px){.submission-page .page-hero{padding:21px}.submission-page .page-hero h2{font-size:22px}.submission-page .hero-icon{display:none}.submission-page .stat-card{margin-bottom:12px;height:auto}.submission-page .menu-heading{align-items:flex-start}.submission-page .menu-label{display:none}.submission-page .action-card{height:auto}.submission-page .submission-card>.card-header{align-items:flex-start;flex-direction:column}.submission-page .submission-card>.card-body{padding:0 13px 15px}}
</style>
<section class="content submission-page">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-hero"><div><h2>Pengajuan Toko</h2><p>Ajukan customer atau toko baru, pantau proses verifikasi, dan kelola penutupan toko dari satu halaman.</p></div><div class="hero-icon"><i class="fas fa-file-signature"></i></div></div>
        <div class="row">
          <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon"><i class="fas fa-file-alt"></i></div><div><span class="stat-label">Total Pengajuan</span><strong class="stat-value"><?= number_format($total_pengajuan, 0, ',', '.') ?></strong></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon amber"><i class="fas fa-clock"></i></div><div><span class="stat-label">Dalam Proses</span><strong class="stat-value"><?= number_format($total_proses, 0, ',', '.') ?></strong></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon green"><i class="fas fa-check"></i></div><div><span class="stat-label">Selesai</span><strong class="stat-value"><?= number_format($total_selesai, 0, ',', '.') ?></strong></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon red"><i class="fas fa-times"></i></div><div><span class="stat-label">Ditolak</span><strong class="stat-value"><?= number_format($total_ditolak, 0, ',', '.') ?></strong></div></div></div>
        </div>
        <div class="info-banner"><i class="fas fa-info-circle"></i><div><strong>Pengajuan kini sepenuhnya digital</strong>Proses toko baru dilakukan melalui ABSI sehingga Anda tidak perlu lagi membuat pengajuan manual.</div></div>
        <div class="menu-panel">
          <div class="menu-heading">
            <div class="menu-title"><span class="menu-title-icon"><i class="fas fa-th-large"></i></span><div><h3>Menu Pengajuan</h3><p>Pilih layanan sesuai kebutuhan pengajuan Anda.</p></div></div>
            <span class="menu-label">Mulai di sini</span>
          </div>
          <div class="row action-grid">
            <div class="col-md-4"><a class="action-card" href="<?= base_url('spv/Toko/customer') ?>"><span class="action-icon"><i class="fas fa-building"></i></span><div><strong>Customer &amp; Toko Baru</strong><small>Daftarkan customer sekaligus toko pertamanya</small></div><i class="fas fa-chevron-right arrow"></i></a></div>
            <div class="col-md-4"><a class="action-card" href="<?= base_url('spv/Toko/toko') ?>"><span class="action-icon"><i class="fas fa-store"></i></span><div><strong>Toko Baru</strong><small>Tambahkan toko untuk customer terdaftar</small></div><i class="fas fa-chevron-right arrow"></i></a></div>
            <div class="col-md-4"><a class="action-card danger" href="#" data-toggle="modal" data-target="#exampleModalCenter"><span class="action-icon"><i class="fas fa-ban"></i></span><div><strong>Penutupan Toko</strong><small>Ajukan proses penutupan toko aktif</small></div><i class="fas fa-chevron-right arrow"></i></a></div>
          </div>
        </div>
        <div class="card submission-card">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-list-ul mr-2 text-primary"></i>Riwayat Pengajuan</h3><small><?= number_format($total_pengajuan, 0, ',', '.') ?> data ditemukan</small>
          </div>
          <div class="card-body">
            <div class="row d-none" style="align-items: center;">
              <div class="col-md-9">
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <i class="icon fas fa-check"></i>
                  <small>Proses pengajuan Toko baru sekarang hanya melalui ABSI, anda tidak perlu lagi membuat pengajuan secara manual. </small>
                </div>
              </div>
              <div class="col-md-3 text-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-outline-success btn-sm"> <i class="fas fa-plus"></i> Pengajuan Toko</button>
                  <button type="button" class="btn btn-success btn-sm dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="<?= base_url('spv/Toko/customer') ?>">Tambah Customer Baru</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= base_url('spv/Toko/toko') ?>"> Tambah Toko Baru</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModalCenter"> Tutup Toko</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive"><table id="table_toko" class="table">
              <thead>
                <tr>
                  <th class="text-center" style="width:4%">No</th>
                  <th style="width:14%">No Pengajuan</th>
                  <th>Toko</th>
                  <th>Kategori</th>
                  <th class="text-center">Status</th>
                  <th class="text-center" style="width:12%">Menu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                if (!empty($pengajuan)) :
                  foreach ($pengajuan as $t) :
                  $no++
                ?>
                  <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td>
                      <small>
                        <strong class="submission-number"><?= html_escape($t->nomor) ?></strong>
                      </small>
                    </td>
                    <td>
                      <small>
                        <strong class="store-name"><?= html_escape($t->nama_toko) ?></strong>
                        <address><i class="fas fa-map-marker-alt mr-1"></i><?= html_escape($t->alamat) ?></address>
                      </small>
                    </td>
                    <td>
                      <small>
                        <strong><?= kategori_pengajuan($t->kategori) ?></strong>
                      </small>
                    </td>
                    <td class="text-center">
                      <?= status_pengajuan($t->status) ?>
                    </td>
                    <td class="text-center">
                      <div class="row-actions">
                        <?php if ((int) $t->kategori === 3) { ?>
                          <a class="row-action" href="<?= base_url('spv/Toko/detail_tutup/' . (int) $t->id) ?>"><i class="fas fa-eye"></i>Detail</a>
                        <?php } else { ?>
                          <a class="row-action" href="<?= base_url('spv/Toko/detail/' . (int) $t->id) ?>"><i class="fas fa-eye"></i>Detail</a>
                          <?php if ((int) $t->status === 4) { ?>
                            <a class="row-action print-action" href="<?= base_url('adm/Toko/fpo/' . (int) $t->id) ?>" target="_blank" rel="noopener" title="Cetak FPO1" aria-label="Cetak FPO1"><i class="fas fa-print"></i></a>
                          <?php } ?>
                        <?php } ?>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; else : ?>
                  <tr><td colspan="6" class="empty-row"><i class="fas fa-inbox fa-2x d-block mb-2"></i>Belum ada riwayat pengajuan.</td></tr>
                <?php endif; ?>
              </tbody>
            </table></div>
          </div>
        </div>
      </div>

    </div>
  </div>
  </div>
</section>
<!-- Modal -->
<div class="modal fade submission-modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="exampleModalLongTitle">Pengajuan Tutup Toko</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <strong>Alur verifikasi penutupan toko</strong>
        <p class="text-muted small mb-0">Pengajuan akan melalui tahapan berikut sebelum diproses.</p>
        <ol class="verification-list">
          <li><span class="step-number">1</span>Verifikasi Manager Marketing</li>
          <li><span class="step-number">2</span>Verifikasi Marketing Verification</li>
          <li><span class="step-number">3</span>Verifikasi Direksi</li>
        </ol>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
        <a href="<?= base_url('spv/Toko/form_tutup'); ?>" class="btn btn-danger btn-sm">Ya, Lanjutkan</a>
      </div>
    </div>
  </div>
</div>
<!-- end modal -->
<script>
  <?php if ($this->session->flashdata('clear_customer_toko_draft')) : ?>
    localStorage.removeItem('absi_customer_toko_draft_<?= (int) $this->session->userdata('id') ?>');
  <?php endif; ?>
  $(document).ready(function() {

    $('#table_toko').DataTable({
      order: [
        [0, 'asc']
      ],
      responsive: true,
      lengthChange: false,
      autoWidth: false,
    });


  })
</script>

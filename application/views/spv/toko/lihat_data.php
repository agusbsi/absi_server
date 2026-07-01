<?php
$total_toko = is_array($toko) ? count($toko) : 0;
$toko_aktif = $proses_suspend = $leader_terkait = 0;
if (!empty($toko)) foreach ($toko as $item) {
  if ((int) $item->status === 1) $toko_aktif++;
  if ((int) $item->status === 7) $proses_suspend++;
  if (!empty($item->nama_user)) $leader_terkait++;
}
?>
<style>
  .active-store-page{--primary:#2563eb;--muted:#64748b;--line:#e2e8f0;color:#0f172a}.active-store-page .page-hero{display:flex;align-items:center;justify-content:space-between;padding:25px 27px;margin-bottom:18px;border-radius:19px;color:#fff;background:linear-gradient(125deg,#172554,#1d4ed8 75%,#38bdf8 140%);box-shadow:0 13px 32px rgba(30,64,175,.17)}.active-store-page .page-hero h2{margin:0 0 6px;font-size:25px;font-weight:700}.active-store-page .page-hero p{margin:0;color:rgba(255,255,255,.78);font-size:13px}.active-store-page .hero-icon{display:flex;width:60px;height:60px;align-items:center;justify-content:center;border-radius:17px;background:rgba(255,255,255,.13);font-size:25px}
  .active-store-page .stat-card{display:flex;align-items:center;height:100%;min-height:88px;padding:16px 18px;border:1px solid var(--line);border-radius:15px;background:#fff;box-shadow:0 4px 16px rgba(15,23,42,.04)}.active-store-page .stat-icon{display:flex;width:43px;height:43px;align-items:center;justify-content:center;margin-right:12px;border-radius:12px;color:#2563eb;background:#eff6ff}.active-store-page .stat-icon.green{color:#059669;background:#ecfdf5}.active-store-page .stat-icon.amber{color:#d97706;background:#fffbeb}.active-store-page .stat-icon.cyan{color:#0891b2;background:#ecfeff}.active-store-page .stat-label{display:block;color:var(--muted);font-size:11px;font-weight:600}.active-store-page .stat-value{display:block;font-size:21px;line-height:1.2}
  .active-store-page .submission-note{display:flex;align-items:center;justify-content:space-between;padding:15px 17px;margin:18px 0;border:1px solid #bfdbfe;border-radius:14px;background:#eff6ff}.active-store-page .note-copy{display:flex;align-items:center;color:#475569;font-size:12px}.active-store-page .note-copy>i{margin-right:11px;color:#2563eb;font-size:19px}.active-store-page .note-copy strong{display:block;color:#1e3a8a}.active-store-page .submission-note .btn{flex-shrink:0;margin-left:15px;padding:8px 12px;border-radius:9px;font-size:11px;font-weight:700}
  .active-store-page .store-card{overflow:hidden;border:1px solid var(--line);border-radius:16px;box-shadow:0 5px 18px rgba(15,23,42,.05)}.active-store-page .store-card>.card-header{display:flex;align-items:center;justify-content:space-between;padding:19px 21px;border:0;color:#0f172a;background:#fff}.active-store-page .store-card .card-title{margin:0;font-size:16px;font-weight:700}.active-store-page .store-card>.card-header small{color:var(--muted)}.active-store-page .store-card>.card-body{padding:0 20px 20px}.active-store-page .table thead th{padding:13px 11px;border-width:1px 0;border-color:var(--line);color:#475569;background:#f8fafc;font-size:11px;font-weight:700;text-transform:uppercase}.active-store-page .table tbody td{padding:15px 11px;border-color:#f1f5f9;vertical-align:middle}.active-store-page .store-name{display:block;margin-bottom:4px;color:#0f172a;font-size:13px;font-weight:700}.active-store-page .store-type{display:inline-block;padding:4px 8px;border-radius:20px;color:#1d4ed8;background:#eff6ff;font-size:10px;font-weight:600}.active-store-page .store-address{display:block;max-width:430px;color:var(--muted);font-size:11px;line-height:1.5}.active-store-page .leader-name{color:#334155;font-size:12px;font-weight:600}.active-store-page td .badge{padding:6px 9px;border-radius:20px;font-size:10px}.active-store-page .detail-action{display:inline-flex;height:34px;align-items:center;padding:0 12px;border:1px solid #bfdbfe;border-radius:9px;color:#1d4ed8;background:#eff6ff;font-size:11px;font-weight:700}.active-store-page .detail-action:hover{color:#fff;background:#2563eb;text-decoration:none}.active-store-page .empty-row{padding:38px!important;color:var(--muted);text-align:center}
  @media(max-width:767.98px){.active-store-page .page-hero{padding:21px}.active-store-page .page-hero h2{font-size:22px}.active-store-page .hero-icon{display:none}.active-store-page .stat-card{margin-bottom:12px;height:auto}.active-store-page .submission-note{align-items:flex-start;flex-direction:column}.active-store-page .submission-note .btn{margin:12px 0 0 30px}.active-store-page .store-card>.card-header{align-items:flex-start;flex-direction:column}.active-store-page .store-card>.card-body{padding:0 13px 15px}}
</style>
<section class="content active-store-page">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-hero"><div><h2>Toko Aktif</h2><p>Pantau seluruh toko, penanggung jawab, dan status operasional dalam pengelolaan Anda.</p></div><div class="hero-icon"><i class="fas fa-store"></i></div></div>
        <div class="row">
          <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon"><i class="fas fa-store-alt"></i></div><div><span class="stat-label">Total Toko</span><strong class="stat-value"><?= number_format($total_toko, 0, ',', '.') ?></strong></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon green"><i class="fas fa-check-circle"></i></div><div><span class="stat-label">Toko Aktif</span><strong class="stat-value"><?= number_format($toko_aktif, 0, ',', '.') ?></strong></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon cyan"><i class="fas fa-user-check"></i></div><div><span class="stat-label">Leader Terkait</span><strong class="stat-value"><?= number_format($leader_terkait, 0, ',', '.') ?></strong></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon amber"><i class="fas fa-pause-circle"></i></div><div><span class="stat-label">Proses Suspend</span><strong class="stat-value"><?= number_format($proses_suspend, 0, ',', '.') ?></strong></div></div></div>
        </div>
        <div class="submission-note"><div class="note-copy"><i class="fas fa-info-circle"></i><div><strong>Ingin menambah customer atau toko?</strong>Penambahan data baru sekarang dilakukan melalui menu Pengajuan Toko.</div></div><a href="<?= base_url('spv/Toko/pengajuanToko') ?>" class="btn btn-primary"><i class="fas fa-arrow-right mr-1"></i>Buka Pengajuan</a></div>
        <div class="card store-card">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-list-ul mr-2 text-primary"></i>Daftar Toko</h3><small><?= number_format($total_toko, 0, ',', '.') ?> toko ditemukan</small>
          </div>
          <div class="card-body">
            <div class="alert alert-success alert-dismissible d-none">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <i class="icon fas fa-check"></i>
              <small>Menu Tambah Customer / Toko sekarang berada di fitur "Pengajuan Toko".</small>
            </div>
            <div class="table-responsive"><table id="table_toko" class="table">
                <thead>
                  <tr class="text-center">
                    <th style="width:5%">No</th>
                    <th style="width:20%">Nama Toko</th>
                    <th style="width:30%">Alamat</th>
                    <th>Team Leader</th>
                    <th>Status</th>
                    <th style="width:10%">Menu</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  if (!empty($toko)) : foreach ($toko as $t) :
                    $no++
                  ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td>
                        <small>
                          <strong class="store-name"><?= html_escape($t->nama_toko) ?></strong>
                          <span class="store-type"><?= jenis_toko($t->jenis_toko) ?></span>
                        </small>
                      </td>
                      <td>
                        <span class="store-address"><i class="fas fa-map-marker-alt mr-1"></i><?= html_escape($t->alamat) ?></span>
                      </td>
                      <td class="text-center">
                        <small><?php
                                if ($t->nama_user == "") {
                                  echo "<span class='badge badge-warning'> Belum dikaitkan</span>";
                                } else {
                                  echo '<span class="leader-name">' . html_escape($t->nama_user) . '</span>';
                                }
                                ?></small>
                      </td>
                      <td class="text-center">
                        <?= status_toko($t->status) ?>
                      </td>
                      <td>
                        <a href="<?= base_url('spv/Toko/profil/' . (int) $t->id) ?>" class="detail-action"><i class="fas fa-eye mr-1"></i>Detail</a>
                      </td>
                    </tr>
                  <?php endforeach; else : ?><tr><td colspan="6" class="empty-row"><i class="fas fa-store fa-2x d-block mb-2"></i>Belum ada toko dalam pengelolaan Anda.</td></tr><?php endif; ?>
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

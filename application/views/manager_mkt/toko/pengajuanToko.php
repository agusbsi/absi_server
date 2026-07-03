<?php
$total_pengajuan = count($pengajuan);
$perlu_proses = $selesai = $ditolak = 0;
foreach ($pengajuan as $item) {
  if ((int) $item->status === 0) $perlu_proses++;
  elseif ((int) $item->status === 4) $selesai++;
  elseif ((int) $item->status === 5) $ditolak++;
}
?>
<style>
  .store-submission{--primary:#0f766e;--soft:#ecfdf5;--ink:#172033;--muted:#718096;--line:#e7edf3;padding-bottom:28px;color:var(--ink)}
  .store-submission .submission-hero{position:relative;overflow:hidden;margin-bottom:20px;padding:26px 30px;color:#fff;background:linear-gradient(120deg,#115e59 0%,#0f766e 55%,#14b8a6 125%);border-radius:18px;box-shadow:0 14px 34px rgba(15,118,110,.18)}
  .store-submission .submission-hero:after{position:absolute;top:-100px;right:-45px;width:245px;height:245px;content:'';border:1px solid rgba(255,255,255,.16);border-radius:50%}.store-submission .hero-content{position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between}.store-submission .hero-eyebrow{display:block;margin-bottom:7px;color:rgba(255,255,255,.78);font-size:11px;font-weight:700;letter-spacing:.09em;text-transform:uppercase}.store-submission .submission-hero h1{margin:0 0 7px;font-size:26px;font-weight:700}.store-submission .submission-hero p{margin:0;color:rgba(255,255,255,.82);font-size:13px}.store-submission .hero-icon{display:flex;width:60px;height:60px;align-items:center;justify-content:center;background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.2);border-radius:17px;font-size:23px}
  .store-submission .summary-card{display:flex;min-height:94px;align-items:center;gap:14px;margin-bottom:18px;padding:17px;background:#fff;border:1px solid var(--line);border-radius:15px;box-shadow:0 5px 18px rgba(34,45,70,.04)}.store-submission .summary-icon{display:flex;width:43px;height:43px;align-items:center;justify-content:center;color:var(--color);background:var(--bg);border-radius:12px}.store-submission .summary-value{margin:0 0 4px;color:#111827;font-size:23px;font-weight:700;line-height:1}.store-submission .summary-label{margin:0;color:var(--muted);font-size:12px}
  .store-submission .modern-card{overflow:hidden;border:1px solid var(--line);border-radius:17px;box-shadow:0 6px 20px rgba(34,45,70,.045)}.store-submission .modern-card .card-header{display:flex;align-items:center;justify-content:space-between;padding:18px 21px;background:#fff;border-bottom:1px solid var(--line)}.store-submission .modern-card .card-title{color:var(--ink);font-size:16px;font-weight:700}.store-submission .header-subtitle{display:block;margin-top:4px;color:var(--muted);font-size:11px;font-weight:400}.store-submission .search-box{position:relative;width:280px}.store-submission .search-box i{position:absolute;top:50%;left:13px;color:#94a3b8;transform:translateY(-50%)}.store-submission .search-box input{width:100%;height:39px;padding:8px 12px 8px 37px;background:#f8fafc;border:1px solid #dfe6ee;border-radius:10px;outline:none;font-size:12px}.store-submission .search-box input:focus{background:#fff;border-color:#5eead4;box-shadow:0 0 0 3px rgba(20,184,166,.1)}
  .store-submission .modern-note{display:flex;gap:10px;margin-bottom:18px;padding:13px 15px;color:#285e61;background:#f0fdfa;border:1px solid #ccfbf1;border-radius:12px;font-size:12px}.store-submission .modern-note i{margin-top:2px;color:var(--primary)}.store-submission table{width:100%!important}.store-submission table thead th{padding:13px 10px;color:#64748b;border-top:0;border-bottom:1px solid var(--line);font-size:10px;letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}.store-submission table tbody td{padding:14px 10px;vertical-align:middle;border-color:#eef2f6;font-size:12px}.store-submission table tbody tr:hover{background:#fbfefd}.store-submission address{max-width:360px;margin:3px 0 0;overflow:hidden;color:var(--muted);font-size:11px;text-overflow:ellipsis;white-space:nowrap}.store-submission .table strong{color:#253047;font-size:12px}.store-submission .table .badge{padding:7px 9px;border-radius:999px;font-size:10px}.store-submission .btn-sm{padding:7px 11px;border:0;border-radius:9px;font-size:11px;font-weight:700}.store-submission .btn-success,.store-submission .btn-info{background:var(--primary);box-shadow:none}.store-submission .dataTables_filter,.store-submission .dataTables_length{display:none}.store-submission .dataTables_info,.store-submission .dataTables_paginate{padding-top:14px!important;color:var(--muted);font-size:11px}
  @media(max-width:767.98px){.store-submission .submission-hero{padding:22px 20px;border-radius:15px}.store-submission .submission-hero h1{font-size:22px}.store-submission .hero-icon{display:none}.store-submission .modern-card .card-header{align-items:flex-start;flex-direction:column;gap:13px}.store-submission .search-box{width:100%}}
</style>
<section class="content store-submission">
  <div class="container-fluid">
    <div class="submission-hero"><div class="hero-content"><div><span class="hero-eyebrow"><i class="fas fa-layer-group mr-1"></i> Manajemen Toko</span><h1>Pengajuan Toko</h1><p>Tinjau dan pantau seluruh proses pengajuan toko dari satu halaman yang ringkas.</p></div><span class="hero-icon"><i class="fas fa-store"></i></span></div></div>
    <div class="row">
      <?php $summary = array(array('Total pengajuan',$total_pengajuan,'fa-file-alt','#475569','#f1f5f9'),array('Perlu diproses',$perlu_proses,'fa-bell','#d97706','#fff7ed'),array('Pengajuan selesai',$selesai,'fa-check-circle','#16a34a','#f0fdf4'),array('Pengajuan ditolak',$ditolak,'fa-times-circle','#dc2626','#fef2f2')); foreach ($summary as $s) : ?>
        <div class="col-xl-3 col-sm-6"><article class="summary-card" style="--color:<?= $s[3] ?>;--bg:<?= $s[4] ?>"><span class="summary-icon"><i class="fas <?= $s[2] ?>"></i></span><div><h2 class="summary-value"><?= number_format($s[1]) ?></h2><p class="summary-label"><?= $s[0] ?></p></div></article></div>
      <?php endforeach; ?>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card modern-card">
          <div class="card-header">
            <h3 class="card-title">Daftar pengajuan<span class="header-subtitle">Pilih pengajuan yang perlu diproses untuk melakukan verifikasi.</span></h3>
            <label class="search-box" for="submission-search"><i class="fas fa-search"></i><input type="search" id="submission-search" placeholder="Cari nomor, toko, atau alamat..." autocomplete="off"></label>
          </div>
          <div class="card-body">
            <div class="modern-note"><i class="fas fa-info-circle"></i><span>Pengajuan toko baru kini diproses langsung melalui ABSI. Tim Marketing tidak perlu lagi membuat dokumen pengajuan secara manual.</span></div>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th class="text-center" style="width:4%">No</th>
                  <th style="width:14%">No Pengajuan</th>
                  <th>Toko</th>
                  <th>Kategori</th>
                  <th class="text-center">Status</th>
                  <th class="text-center" style="width:10%">Menu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($pengajuan as $t) :
                  $no++
                ?>
                  <tr>
                    <td class="text-center text-muted"><?= $no ?></td>
                    <td>
                      <small>
                        <strong><?= html_escape($t->nomor) ?></strong>
                      </small>
                    </td>
                    <td>
                      <small>
                        <strong><i class="fas fa-store text-muted mr-1"></i><?= html_escape($t->nama_toko) ?></strong>
                        <address title="<?= html_escape($t->alamat) ?>"><i class="fas fa-map-marker-alt mr-1"></i><?= html_escape($t->alamat) ?></address>
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
                    <td>
                      <?php if ($t->kategori == 3) { ?>
                        <a href="<?= base_url('mng_mkt/Toko/toko_tutup_d/' . $t->id) ?>" class="btn btn-<?= $t->status == 0 ? "success" : "info" ?> btn-sm "> <i class="fas fa-<?= $t->status == 0 ? "arrow-right" : "eye" ?>"></i> <?= $t->status == 0 ? "Proses" : "Detail" ?> </a>
                      <?php } else { ?>
                        <a href="<?= base_url('mng_mkt/Toko/detail/' . $t->id) ?>" class="btn btn-<?= $t->status == 0 ? "success" : "info" ?> btn-sm "> <i class="fas fa-<?= $t->status == 0 ? "arrow-right" : "eye" ?>"></i> <?= $t->status == 0 ? "Proses" : "Detail" ?> </a>
                      <?php } ?>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<script>
  $(function() {
    $('#submission-search').on('input', function() {
      if ($.fn.dataTable && $.fn.dataTable.isDataTable('#example1')) {
        $('#example1').DataTable().search(this.value).draw();
      } else {
        var keyword = this.value.toLowerCase();
        $('#example1 tbody tr').each(function() { $(this).toggle($(this).text().toLowerCase().indexOf(keyword) !== -1); });
      }
    });
  });
</script>

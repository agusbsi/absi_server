<?php
$total_customer = is_array($customer) ? count($customer) : 0;
$total_toko = 0;
if (!empty($customer)) {
  foreach ($customer as $item) {
    $total_toko += (int) $item->total_toko;
  }
}
?>

<style>
  .customer-page{--primary:#2563eb;--navy:#172554;--muted:#64748b;--line:#e2e8f0;color:#0f172a}.customer-page .page-hero{display:flex;align-items:center;justify-content:space-between;padding:24px 26px;margin-bottom:18px;border-radius:18px;color:#fff;background:linear-gradient(125deg,#172554,#1d4ed8);box-shadow:0 12px 30px rgba(30,64,175,.16)}.customer-page .page-hero h2{margin:0 0 6px;font-size:25px;font-weight:700;letter-spacing:-.02em}.customer-page .page-hero p{margin:0;color:rgba(255,255,255,.78);font-size:13px}.customer-page .hero-icon{display:flex;width:58px;height:58px;align-items:center;justify-content:center;border-radius:16px;background:rgba(255,255,255,.13);font-size:24px}
  .customer-page .summary-card{display:flex;align-items:center;height:100%;min-height:92px;padding:17px 19px;border:1px solid var(--line);border-radius:15px;background:#fff;box-shadow:0 4px 16px rgba(15,23,42,.04)}.customer-page .summary-icon{display:flex;width:46px;height:46px;align-items:center;justify-content:center;margin-right:13px;border-radius:13px;color:#2563eb;background:#eff6ff;font-size:18px}.customer-page .summary-icon.green{color:#059669;background:#ecfdf5}.customer-page .summary-label{display:block;color:var(--muted);font-size:12px;font-weight:600}.customer-page .summary-value{display:block;font-size:23px;line-height:1.2}
  .customer-page .submission-info{display:flex;align-items:center;justify-content:space-between;padding:16px 18px;margin:18px 0;border:1px solid #bfdbfe;border-radius:14px;background:#eff6ff}.customer-page .submission-copy{display:flex;align-items:center}.customer-page .submission-copy>i{margin-right:13px;color:#2563eb;font-size:22px}.customer-page .submission-copy strong{display:block;margin-bottom:2px;color:#1e3a8a;font-size:14px}.customer-page .submission-copy span{color:#475569;font-size:12px}.customer-page .submission-info .btn{flex-shrink:0;margin-left:15px;padding:8px 13px;border:0;border-radius:9px;background:#2563eb;font-size:12px;font-weight:700}
  .customer-page .customer-card{overflow:hidden;border:1px solid var(--line);border-radius:16px;box-shadow:0 5px 18px rgba(15,23,42,.05)}.customer-page .customer-card .card-header{display:flex;align-items:center;justify-content:space-between;padding:19px 21px;border:0;background:#fff}.customer-page .customer-card .card-title{margin:0;color:#0f172a;font-size:16px;font-weight:700}.customer-page .customer-card .card-header small{color:var(--muted)}.customer-page .customer-card .card-body{padding:0 20px 20px}.customer-page table.dataTable{margin-top:0!important;border-collapse:separate!important;border-spacing:0}.customer-page .table thead th{padding:13px 11px;border-width:1px 0;border-color:var(--line);color:#475569;background:#f8fafc;font-size:11px;font-weight:700;letter-spacing:.04em;text-transform:uppercase}.customer-page .table tbody td{padding:15px 11px;border-color:#f1f5f9;vertical-align:middle}.customer-page .customer-name{display:block;margin-bottom:4px;color:#0f172a;font-size:14px;font-weight:700}.customer-page .customer-address{display:block;max-width:440px;color:var(--muted);font-size:12px;line-height:1.5}.customer-page .phone-link{color:#475569;font-size:12px}.customer-page .phone-link:hover{color:#2563eb}.customer-page .store-badge{display:inline-flex;min-width:35px;align-items:center;justify-content:center;padding:5px 9px;border-radius:20px;color:#047857;background:#ecfdf5;font-size:12px;font-weight:700}.customer-page .detail-btn{padding:7px 11px;border:1px solid #bfdbfe;border-radius:9px;color:#1d4ed8;background:#eff6ff;font-size:11px;font-weight:700}.customer-page .detail-btn:hover{color:#fff;background:#2563eb}.customer-page .empty-row{padding:36px!important;color:var(--muted);text-align:center}
  @media(max-width:767.98px){.customer-page .page-hero{padding:21px}.customer-page .page-hero h2{font-size:22px}.customer-page .hero-icon{display:none}.customer-page .summary-card{margin-bottom:12px;height:auto}.customer-page .submission-info{align-items:flex-start;flex-direction:column}.customer-page .submission-info .btn{margin:13px 0 0 35px}.customer-page .customer-card .card-header{align-items:flex-start;flex-direction:column}.customer-page .customer-card .card-header small{margin-top:4px}.customer-page .customer-card .card-body{padding:0 14px 15px}}
</style>

<section class="content customer-page">
  <div class="container-fluid">
    <div class="page-hero">
      <div><h2>Data Customer</h2><p>Lihat customer beserta jumlah toko yang berada dalam pengelolaan Anda.</p></div>
      <div class="hero-icon"><i class="fas fa-building"></i></div>
    </div>

    <div class="row">
      <div class="col-sm-6 mb-3 mb-sm-0"><div class="summary-card"><div class="summary-icon"><i class="fas fa-building"></i></div><div><span class="summary-label">Total Customer</span><strong class="summary-value"><?= number_format($total_customer, 0, ',', '.') ?></strong></div></div></div>
      <div class="col-sm-6"><div class="summary-card"><div class="summary-icon green"><i class="fas fa-store"></i></div><div><span class="summary-label">Total Toko Terdaftar</span><strong class="summary-value"><?= number_format($total_toko, 0, ',', '.') ?></strong></div></div></div>
    </div>

    <div class="submission-info" role="note">
      <div class="submission-copy"><i class="fas fa-info-circle"></i><div><strong>Ingin menambahkan customer baru?</strong><span>Penambahan customer baru dilakukan melalui menu <b>Pengajuan Toko</b>.</span></div></div>
      <a href="<?= base_url('spv/Toko/pengajuanToko') ?>" class="btn btn-primary"><i class="fas fa-arrow-right mr-1"></i> Buka Pengajuan Toko</a>
    </div>

    <div class="card customer-card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-list-ul mr-2 text-primary"></i>Daftar Customer</h3><small><?= number_format($total_customer, 0, ',', '.') ?> customer ditemukan</small></div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="example1" class="table">
            <thead><tr><th class="text-center" style="width:55px">No.</th><th>Customer &amp; Alamat</th><th>Telepon</th><th class="text-center">Jumlah Toko</th><th class="text-center" style="width:100px">Aksi</th></tr></thead>
            <tbody>
              <?php if (!empty($customer)) : $no = 0; foreach ($customer as $dd) : $no++; ?>
                <tr>
                  <td class="text-center text-muted"><?= $no ?></td>
                  <td><span class="customer-name"><?= html_escape($dd->nama_cust) ?></span><span class="customer-address"><i class="fas fa-map-marker-alt mr-1"></i><?= html_escape($dd->alamat_cust) ?></span></td>
                  <td><a href="tel:<?= html_escape($dd->telp) ?>" class="phone-link"><i class="fas fa-phone-alt mr-1"></i><?= html_escape($dd->telp) ?></a></td>
                  <td class="text-center"><span class="store-badge"><?= number_format($dd->total_toko, 0, ',', '.') ?></span></td>
                  <td class="text-center"><a href="<?= base_url('spv/Customer/detail/' . (int) $dd->id) ?>" class="btn detail-btn">Detail <i class="fas fa-chevron-right ml-1"></i></a></td>
                </tr>
              <?php endforeach; else : ?>
                <tr><td colspan="5" class="empty-row"><i class="fas fa-inbox fa-2x d-block mb-2"></i>Belum ada data customer.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

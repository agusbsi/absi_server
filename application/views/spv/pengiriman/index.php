<?php
$total_do = is_array($list_data) ? count($list_data) : 0;
$belum_approve = $dikirim = $selesai = $selisih = 0;
if (!empty($list_data)) foreach ($list_data as $item) {
  $status = (int) $item->status;
  if ($status === 0) $belum_approve++;
  elseif ($status === 1) $dikirim++;
  elseif ($status === 2) $selesai++;
  else $selisih++;
}
?>
<style>
  .delivery-page{--primary:#2563eb;--muted:#64748b;--line:#e2e8f0;color:#0f172a}.delivery-page .page-hero{display:flex;align-items:center;justify-content:space-between;padding:25px 27px;margin-bottom:18px;border-radius:19px;color:#fff;background:linear-gradient(125deg,#172554,#1d4ed8 75%,#38bdf8 140%);box-shadow:0 13px 32px rgba(30,64,175,.17)}.delivery-page .page-hero h2{margin:0 0 6px;font-size:25px;font-weight:700}.delivery-page .page-hero p{margin:0;color:rgba(255,255,255,.78);font-size:12px}.delivery-page .hero-icon{display:flex;width:60px;height:60px;align-items:center;justify-content:center;border-radius:17px;background:rgba(255,255,255,.13);font-size:25px}
  .delivery-page .stat-card{display:flex;align-items:center;height:100%;min-height:88px;padding:16px 18px;border:1px solid var(--line);border-radius:15px;background:#fff;box-shadow:0 4px 16px rgba(15,23,42,.04)}.delivery-page .stat-icon{display:flex;width:43px;height:43px;align-items:center;justify-content:center;margin-right:12px;border-radius:12px;color:#2563eb;background:#eff6ff}.delivery-page .stat-icon.amber{color:#d97706;background:#fffbeb}.delivery-page .stat-icon.cyan{color:#0891b2;background:#ecfeff}.delivery-page .stat-icon.green{color:#059669;background:#ecfdf5}.delivery-page .stat-label{display:block;color:var(--muted);font-size:11px;font-weight:600}.delivery-page .stat-value{display:block;font-size:21px;line-height:1.2}
  .delivery-page .flow-note{display:flex;align-items:flex-start;padding:13px 15px;margin:5px 0 18px;border:1px solid #bfdbfe;border-radius:12px;color:#475569;background:#eff6ff;font-size:11px}.delivery-page .flow-note i{margin:2px 9px 0 0;color:#2563eb}.delivery-page .flow-note strong{color:#1e3a8a}.delivery-page .delivery-card{overflow:hidden;border:1px solid var(--line);border-radius:16px;box-shadow:0 5px 18px rgba(15,23,42,.05)}.delivery-page .delivery-card>.card-header{display:flex;align-items:center;justify-content:space-between;padding:19px 21px;border:0;color:#0f172a;background:#fff}.delivery-page .delivery-card .card-title{margin:0;font-size:16px;font-weight:700}.delivery-page .delivery-card>.card-header small{color:var(--muted)}.delivery-page .delivery-card>.card-body{padding:0 20px 20px}.delivery-page .table thead th{padding:13px 11px;border-width:1px 0;border-color:var(--line);color:#475569;background:#f8fafc;font-size:10px;font-weight:700;text-transform:uppercase}.delivery-page .table tbody td{padding:14px 11px;border-color:#f1f5f9;vertical-align:middle}.delivery-page .do-number{color:#1d4ed8;font-size:11px;font-weight:700}.delivery-page .po-number{color:#475569;font-size:11px;font-weight:600}.delivery-page .store-name{display:block;margin-bottom:4px;color:#0f172a;font-size:12px;font-weight:700}.delivery-page .spg-badge{display:inline-flex;align-items:center;padding:4px 8px;border-radius:20px;color:#92400e;background:#fffbeb;font-size:9px;font-weight:600}.delivery-page .created-date{color:#475569;font-size:10px;white-space:nowrap}.delivery-page td .badge{padding:6px 9px;border-radius:20px;font-size:9px}.delivery-page .detail-action{display:inline-flex;height:34px;align-items:center;padding:0 12px;border:1px solid #bfdbfe;border-radius:9px;color:#1d4ed8;background:#eff6ff;font-size:11px;font-weight:700}.delivery-page .detail-action:hover{color:#fff;background:#2563eb;text-decoration:none}.delivery-page .empty-row{padding:38px!important;color:var(--muted);text-align:center}
  @media(max-width:767.98px){.delivery-page .page-hero{padding:21px}.delivery-page .page-hero h2{font-size:22px}.delivery-page .hero-icon{display:none}.delivery-page .stat-card{margin-bottom:12px;height:auto}.delivery-page .delivery-card>.card-header{align-items:flex-start;flex-direction:column}.delivery-page .delivery-card>.card-body{padding:0 13px 15px}}
</style>
<section class="content delivery-page">
       <div class="container-fluid">
         <div class="page-hero"><div><h2>Pengiriman (DO)</h2><p>Pantau Delivery Order, relasi Purchase Order, dan progres pengiriman ke setiap toko.</p></div><div class="hero-icon"><i class="fas fa-truck"></i></div></div>
         <div class="row">
           <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon"><i class="fas fa-file-invoice"></i></div><div><span class="stat-label">Total DO</span><strong class="stat-value"><?= number_format($total_do, 0, ',', '.') ?></strong></div></div></div>
           <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon amber"><i class="fas fa-clock"></i></div><div><span class="stat-label">Belum Disetujui</span><strong class="stat-value"><?= number_format($belum_approve, 0, ',', '.') ?></strong></div></div></div>
           <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon cyan"><i class="fas fa-shipping-fast"></i></div><div><span class="stat-label">Dalam Pengiriman</span><strong class="stat-value"><?= number_format($dikirim, 0, ',', '.') ?></strong></div></div></div>
           <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon green"><i class="fas fa-check-circle"></i></div><div><span class="stat-label">Selesai</span><strong class="stat-value"><?= number_format($selesai, 0, ',', '.') ?></strong></div></div></div>
         </div>
         <div class="flow-note"><i class="fas fa-info-circle"></i><div><strong>Informasi:</strong> setiap Delivery Order terhubung dengan nomor PO asal dan diperbarui mengikuti proses pengiriman barang.</div></div>
         <div class="card delivery-card">
           <div class="card-header">
             <h3 class="card-title"><i class="fas fa-list-ul mr-2 text-primary"></i>Daftar Delivery Order</h3><small><?= number_format($total_do, 0, ',', '.') ?> data ditemukan</small>
           </div>
           <!-- /.card-header -->
           <div class="card-body">

             <div class="table-responsive"><table id="example1" class="table">
               <thead>
                 <tr>
                   <th style="width: 2%">#</th>
                   <th>Nomor</th>
                   <th>No PO</th>
                   <th>Toko</th>
                   <th class="text-center">Tanggal</th>
                   <th class="text-center">Status</th>
                   <th class="text-center">Menu</th>
                 </tr>
               </thead>
               <tbody>
                   <?php if (!empty($list_data)) { ?>
                     <?php $no = 1; ?>
                     <?php foreach ($list_data as $dd) : ?><tr>
                       <td class="text-center"><?= $no ?></td>
                       <td class="text-center"><span class="do-number"><?= html_escape($dd->id) ?></span></td>
                       <td><span class="po-number"><?= html_escape($dd->id_permintaan) ?></span></td>
                       <td>
                         <small>
                           <span class="store-name"><?= html_escape($dd->nama_toko) ?></span>
                           <span class="spg-badge"><i class="far fa-user mr-1"></i><?= $dd->spg ? html_escape($dd->spg) : "Belum ada SPG" ?></span>
                         </small>
                       </td>
                       <td class="text-center"><span class="created-date"><?= date('d M Y, H:i', strtotime($dd->created_at)) ?></span></td>
                       <td class="text-center"><?= status_pengiriman($dd->status) ?></td>
                       <td class="text-center"><a href="<?= base_url('spv/Pengiriman/detail/' . rawurlencode($dd->id)) ?>" class="detail-action"><i class="fas fa-eye mr-1"></i>Detail</a></td>
                 </tr>
                 <?php $no++; ?>
               <?php endforeach; ?>
             <?php } else { ?>
               <tr><td colspan="7" class="empty-row"><i class="fas fa-truck fa-2x d-block mb-2"></i>Belum ada data pengiriman.</td></tr>
             <?php } ?>
               </tbody>
             </table></div>

           </div>
           <!-- /.card-body -->
         </div>
       </div>
       <!-- /.container-fluid -->
     </section>

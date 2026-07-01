<?php
$total_permintaan = is_array($list_data) ? count($list_data) : 0;
$total_proses = $total_logistik = $total_selesai = 0;
if (!empty($list_data)) foreach ($list_data as $item) {
  $status = (int) $item->status;
  if (in_array($status, array(0, 1), true)) $total_proses++;
  elseif (in_array($status, array(2, 3, 4), true)) $total_logistik++;
  elseif ($status === 6) $total_selesai++;
}
?>
<style>
  .request-page{--primary:#2563eb;--muted:#64748b;--line:#e2e8f0;color:#0f172a}.request-page .page-hero{display:flex;align-items:center;justify-content:space-between;padding:25px 27px;margin-bottom:18px;border-radius:19px;color:#fff;background:linear-gradient(125deg,#172554,#1d4ed8 75%,#38bdf8 140%);box-shadow:0 13px 32px rgba(30,64,175,.17)}.request-page .page-hero h2{margin:0 0 6px;font-size:25px;font-weight:700}.request-page .page-hero p{margin:0;color:rgba(255,255,255,.78);font-size:12px}.request-page .hero-icon{display:flex;width:60px;height:60px;align-items:center;justify-content:center;border-radius:17px;background:rgba(255,255,255,.13);font-size:25px}
  .request-page .stat-card{display:flex;align-items:center;height:100%;min-height:88px;padding:16px 18px;border:1px solid var(--line);border-radius:15px;background:#fff;box-shadow:0 4px 16px rgba(15,23,42,.04)}.request-page .stat-icon{display:flex;width:43px;height:43px;align-items:center;justify-content:center;margin-right:12px;border-radius:12px;color:#2563eb;background:#eff6ff}.request-page .stat-icon.amber{color:#d97706;background:#fffbeb}.request-page .stat-icon.cyan{color:#0891b2;background:#ecfeff}.request-page .stat-icon.green{color:#059669;background:#ecfdf5}.request-page .stat-label{display:block;color:var(--muted);font-size:11px;font-weight:600}.request-page .stat-value{display:block;font-size:21px;line-height:1.2}
  .request-page .flow-note{display:flex;align-items:flex-start;padding:13px 15px;margin:5px 0 18px;border:1px solid #bfdbfe;border-radius:12px;color:#475569;background:#eff6ff;font-size:11px}.request-page .flow-note i{margin:2px 9px 0 0;color:#2563eb}.request-page .flow-note strong{color:#1e3a8a}.request-page .request-card{overflow:hidden;border:1px solid var(--line);border-radius:16px;box-shadow:0 5px 18px rgba(15,23,42,.05)}.request-page .request-card>.card-header{display:flex;align-items:center;justify-content:space-between;padding:19px 21px;border:0;color:#0f172a;background:#fff}.request-page .request-card .card-title{margin:0;font-size:16px;font-weight:700}.request-page .request-card>.card-header small{color:var(--muted)}.request-page .request-card>.card-body{padding:0 20px 20px}.request-page .table thead th{padding:13px 11px;border-width:1px 0;border-color:var(--line);color:#475569;background:#f8fafc;font-size:10px;font-weight:700;text-transform:uppercase}.request-page .table tbody td{padding:14px 11px;border-color:#f1f5f9;vertical-align:middle}.request-page .po-number{color:#1d4ed8;font-size:11px;font-weight:700}.request-page .store-name{display:block;margin-bottom:3px;color:#0f172a;font-size:12px;font-weight:700}.request-page .spg-name{color:var(--muted);font-size:10px}.request-page .created-date{color:#475569;font-size:10px;white-space:nowrap}.request-page td .badge{padding:6px 9px;border-radius:20px;font-size:9px}.request-page .detail-action{display:inline-flex;height:34px;align-items:center;padding:0 12px;border:1px solid #bfdbfe;border-radius:9px;color:#1d4ed8;background:#eff6ff;font-size:11px;font-weight:700}.request-page .detail-action:hover{color:#fff;background:#2563eb;text-decoration:none}.request-page .empty-row{padding:38px!important;color:var(--muted);text-align:center}
  @media(max-width:767.98px){.request-page .page-hero{padding:21px}.request-page .page-hero h2{font-size:22px}.request-page .hero-icon{display:none}.request-page .stat-card{margin-bottom:12px;height:auto}.request-page .request-card>.card-header{align-items:flex-start;flex-direction:column}.request-page .request-card>.card-body{padding:0 13px 15px}}
</style>
<section class="content request-page">
       <div class="container-fluid">
         <div class="row">
           <div class="col-12">
             <div class="page-hero"><div><h2>Permintaan Barang</h2><p>Pantau purchase order dan progres pemenuhan permintaan barang setiap toko.</p></div><div class="hero-icon"><i class="fas fa-clipboard-list"></i></div></div>
             <div class="row">
               <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon"><i class="fas fa-file-alt"></i></div><div><span class="stat-label">Total Permintaan</span><strong class="stat-value"><?= number_format($total_permintaan, 0, ',', '.') ?></strong></div></div></div>
               <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon amber"><i class="fas fa-clock"></i></div><div><span class="stat-label">Verifikasi</span><strong class="stat-value"><?= number_format($total_proses, 0, ',', '.') ?></strong></div></div></div>
               <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon cyan"><i class="fas fa-truck-loading"></i></div><div><span class="stat-label">Proses Logistik</span><strong class="stat-value"><?= number_format($total_logistik, 0, ',', '.') ?></strong></div></div></div>
               <div class="col-6 col-lg-3 mb-3"><div class="stat-card"><div class="stat-icon green"><i class="fas fa-check-circle"></i></div><div><span class="stat-label">Selesai</span><strong class="stat-value"><?= number_format($total_selesai, 0, ',', '.') ?></strong></div></div></div>
             </div>
             <div class="flow-note"><i class="fas fa-info-circle"></i><div><strong>Alur permintaan:</strong> verifikasi Leader dan MV, persetujuan, penyiapan barang, pengiriman, lalu selesai.</div></div>
             <div class="card request-card">
               <div class="card-header">
                 <h3 class="card-title"><i class="fas fa-list-ul mr-2 text-primary"></i>Daftar Permintaan</h3><small><?= number_format($total_permintaan, 0, ',', '.') ?> data ditemukan</small>
               </div>
               <div class="card-body">
                 <div class="table-responsive"><table id="table_minta" class="table">
                   <thead>
                     <tr class="text-center">
                       <th>#</th>
                       <th style="width: 18%;">Nomor PO</th>
                       <th style="width: 35%;">Nama Toko</th>
                       <th>Tanggal dibuat</th>
                       <th>Status</th>
                       <th>Menu</th>
                     </tr>
                   </thead>
                   <tbody>
                       <?php if (!empty($list_data)) :
                        $no = 0;
                        foreach ($list_data as $dd) :
                          $no++; ?>
                         <tr>
                         <td class="text-center"><?= $no ?></td>
                         <td class="text-center"><span class="po-number"><?= html_escape($dd->id) ?></span></td>
                         <td>
                           <small>
                             <strong class="store-name"><?= html_escape($dd->nama_toko) ?></strong>
                             <span class="spg-name"><i class="far fa-user mr-1"></i><?= html_escape($dd->spg) ?></span>
                           </small>
                         </td>
                         <td class="text-center">
                           <span class="created-date"><?= date('d M Y, H:i', strtotime($dd->created_at)) ?></span>
                         </td>
                         <td class="text-center">
                           <?= status_permintaan($dd->status); ?>
                         </td>
                         <td class="text-center">
                           <a class="detail-action" href="<?= base_url('spv/permintaan/detail_p/' . rawurlencode($dd->id)) ?>"><i class="fa fa-eye mr-1"></i>Detail</a>
                         </td>

                     </tr>

                   <?php endforeach; else : ?><tr><td colspan="6" class="empty-row"><i class="fas fa-inbox fa-2x d-block mb-2"></i>Belum ada permintaan barang.</td></tr><?php endif; ?>
                   </tbody>

                 </table></div>
               </div>
               <!-- /.card-body -->
             </div>
             <!-- /.card -->
           </div>
           <!-- /.col -->
         </div>
         <!-- /.row -->
       </div>
       <!-- /.container-fluid -->
     </section>
     <!-- /.content -->
     <!-- Modal Edit Product-->
     <form action="<?= base_url('adm_gudang/Permintaan/proses_approve') ?>" method="POST">
       <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">
                 <li class="fas fa-exclamation-triangle"></li> Konfirmasi Data Permintaan Terpending !
               </h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <div class="modal-body">
               <div class="form-group">
                 <label>ID Permintaan # :</label>
                 <input type="text" class="form-control id" name="id" readonly>
               </div>
               <div class="form-group">
                 <label>Nama Toko :</label>
                 <input type="text" class="form-control nama_toko" name="nama_toko" readonly>
               </div>

               <div class="form-group">
                 <label>Catatan :</label>
                 <textarea class="form-control" name="catatan" cols="10" rows="5" placeholder=" Contoh : Stok Artikel 001 habis" required></textarea>
                 <span>* Anda perlu memberikan catatan untuk barang yang tidak bisa di kirim.</span>
               </div>

             </div>
             <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">
                 <li class="fas fa-times-circle"></li> Cancel
               </button>
               <input type="hidden" name="id" class="id">
               <button type="submit" class="btn btn-success">
                 <li class="fas fa-save"></li> Approve
               </button>
             </div>

           </div>
         </div>
       </div>
     </form>
     <!-- End Modal Edit Product-->
     <!-- end modal -->
     <script>
       $(document).ready(function() {
         // tabel
         $('#table_minta').DataTable({
           order: [
             [1, 'desc']
           ],
           responsive: true,
           lengthChange: false,
           autoWidth: false,
         });
         // get Edit Product
         $('.btn-edit').on('click', function() {
           // get data from button edit
           const id = $(this).data('id');
           const nama_toko = $(this).data('nama_toko');

           // Set data to Form Edit
           $('.id').val(id);
           $('.nama_toko').val(nama_toko);
           // Call Modal Edit
           $('#editModal').modal('show');
         });



       })
     </script>

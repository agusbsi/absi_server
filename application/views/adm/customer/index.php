<?php
$customer_list = !empty($customer) ? $customer : array();
$total_customer = count($customer_list);
$total_toko = 0;
$total_artikel = 0;
$customer_aktif = 0;
foreach ($customer_list as $item) {
  $jumlah_toko = (int) ($item->total_toko ?? 0);
  $jumlah_artikel = (int) ($item->total_produk ?? 0);
  $total_toko += $jumlah_toko;
  $total_artikel += $jumlah_artikel;
  if ($jumlah_toko > 0 || $jumlah_artikel > 0) $customer_aktif++;
}
?>

<style>
  .customer-page{--primary:#2563eb;--ink:#172033;--muted:#718096;--line:#e7edf5;padding-bottom:26px;color:var(--ink)}
  .customer-page .customer-hero{position:relative;display:flex;overflow:hidden;align-items:center;justify-content:space-between;gap:24px;margin-bottom:20px;padding:27px 30px;color:#fff;background:linear-gradient(120deg,#1e40af 0%,#2563eb 58%,#38bdf8 135%);border-radius:19px;box-shadow:0 14px 34px rgba(37,99,235,.2)}
  .customer-page .customer-hero:before,.customer-page .customer-hero:after{position:absolute;content:'';border:1px solid rgba(255,255,255,.15);border-radius:50%}.customer-page .customer-hero:before{top:-110px;right:-45px;width:255px;height:255px}.customer-page .customer-hero:after{right:175px;bottom:-110px;width:190px;height:190px}
  .customer-page .hero-copy,.customer-page .hero-insight{position:relative;z-index:1}.customer-page .hero-eyebrow{display:block;margin-bottom:8px;color:rgba(255,255,255,.8);font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase}.customer-page .customer-hero h1{margin:0 0 7px;font-size:27px;font-weight:700;letter-spacing:-.02em}.customer-page .customer-hero p{max-width:620px;margin:0;color:rgba(255,255,255,.82);font-size:14px}
  .customer-page .hero-insight{display:flex;min-width:195px;align-items:center;gap:12px;padding:13px 15px;background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.17);border-radius:13px;backdrop-filter:blur(7px)}.customer-page .hero-insight>i{font-size:22px}.customer-page .hero-insight span,.customer-page .hero-insight small{display:block;color:rgba(255,255,255,.76);font-size:10px}.customer-page .hero-insight strong{display:block;margin:1px 0;font-size:20px;line-height:1.1}
  .customer-page .stat-card{display:flex;min-height:91px;align-items:center;gap:13px;margin-bottom:18px;padding:16px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 5px 16px rgba(34,45,70,.04)}.customer-page .stat-icon{display:flex;width:43px;height:43px;flex:0 0 43px;align-items:center;justify-content:center;color:var(--color);background:var(--soft);border-radius:12px;font-size:16px}.customer-page .stat-value{margin:0;color:#111827;font-size:22px;font-weight:700;line-height:1.1}.customer-page .stat-label{margin:4px 0 0;color:var(--muted);font-size:11px}
  .customer-page .list-card{overflow:hidden;background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 7px 22px rgba(34,45,70,.05)}.customer-page .list-header{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:19px 21px;border-bottom:1px solid var(--line)}.customer-page .list-title{margin:0 0 3px;font-size:16px;font-weight:700}.customer-page .list-subtitle{margin:0;color:var(--muted);font-size:12px}.customer-page .toolbar{display:flex;align-items:center;gap:8px}.customer-page .search-box{position:relative;width:280px}.customer-page .search-box i{position:absolute;top:50%;left:13px;color:#9aa7b8;font-size:12px;transform:translateY(-50%)}.customer-page .search-box input{height:39px;padding-left:36px;background:#f8fafc;border:1px solid var(--line);border-radius:9px;font-size:12px}.customer-page .search-box input:focus{background:#fff;border-color:#93c5fd;box-shadow:0 0 0 3px rgba(37,99,235,.08)}.customer-page .export-tools .btn{height:39px;color:#526070;background:#fff;border:1px solid var(--line);border-radius:8px;font-size:11px}.customer-page .export-tools .btn:hover{color:var(--primary);background:#eff6ff;border-color:#bfdbfe}
  .customer-page .table-responsive{overflow:visible}.customer-page .customer-table{width:100%!important;margin:0!important;font-size:12px}.customer-page .customer-table thead th{padding:12px 15px;color:#64748b;background:#f8fafc;border-top:0;border-bottom:1px solid var(--line);font-size:10px;font-weight:700;letter-spacing:.055em;text-transform:uppercase;white-space:nowrap}.customer-page .customer-table tbody td{padding:14px 15px;vertical-align:middle;border-top:1px solid #f0f3f8}.customer-page .customer-table tbody tr:hover{background:#fbfdff}
  .customer-page .customer-info{display:flex;min-width:240px;align-items:center;gap:11px}.customer-page .customer-avatar{display:flex;width:43px;height:43px;flex:0 0 43px;align-items:center;justify-content:center;color:#2563eb;background:#eff6ff;border-radius:12px;font-size:15px;font-weight:700}.customer-page .customer-name{display:block;max-width:250px;overflow:hidden;margin-bottom:3px;color:#1f2937;font-size:13px;font-weight:700;text-overflow:ellipsis;white-space:nowrap}.customer-page .customer-code{display:inline-flex;align-items:center;gap:5px;color:#64748b;font-size:10px}.customer-page .customer-code i{font-size:7px}.customer-page .contact-line{display:block;max-width:300px;overflow:hidden;margin:3px 0;color:#475569;text-overflow:ellipsis;white-space:nowrap}.customer-page .contact-line i{width:17px;color:#a0aec0;font-size:10px}
  .customer-page .count-pill{display:inline-flex;min-width:65px;align-items:center;justify-content:center;gap:6px;padding:7px 9px;border-radius:999px;font-size:11px;font-weight:700}.customer-page .count-pill.store{color:#0369a1;background:#f0f9ff}.customer-page .count-pill.product{color:#15803d;background:#f0fdf4}.customer-page .actions{display:flex;justify-content:flex-end;gap:5px;white-space:nowrap}.customer-page .action-btn{display:inline-flex;width:32px;height:32px;align-items:center;justify-content:center;padding:0;color:#64748b;background:#f8fafc;border:1px solid var(--line);border-radius:8px;cursor:pointer;transition:.15s}.customer-page .action-btn:hover{color:var(--primary);background:#eff6ff;border-color:#bfdbfe}.customer-page .action-btn.danger:hover{color:#dc2626;background:#fef2f2;border-color:#fecaca}
  .customer-page .dataTables_wrapper>.row:first-child{display:none}.customer-page .dataTables_wrapper>.row:last-child{align-items:center;margin:0;padding:13px 19px;border-top:1px solid var(--line)}.customer-page .dataTables_info,.customer-page .dataTables_paginate{padding-top:0!important;color:var(--muted);font-size:11px}.customer-page .pagination .page-link{margin:0 2px;color:#64748b;border:0;border-radius:7px;font-size:11px}.customer-page .pagination .page-item.active .page-link{color:#fff;background:var(--primary)}.customer-page .dataTables_empty{height:150px;color:var(--muted)!important;text-align:center}
  .legacy-customer-list{display:none!important}.customer-modal .modal-content{overflow:hidden;border:0;border-radius:16px;box-shadow:0 20px 55px rgba(15,23,42,.2)}.customer-modal .modal-header{padding:19px 22px;color:#fff;background:linear-gradient(120deg,#1d4ed8,#38bdf8)!important;border:0}.customer-modal .modal-header .close{color:#fff;opacity:.85;text-shadow:none}.customer-modal .modal-body{padding:22px}.customer-modal label{color:#475569;font-size:11px;font-weight:700}.customer-modal .form-control{min-height:39px;border-color:#dfe6ef;border-radius:8px;font-size:12px}.customer-modal textarea.form-control{min-height:92px}.customer-modal .modal-footer{padding:14px 22px;background:#f8fafc;border-top-color:#e7edf5}
  @media(max-width:991.98px){.customer-page .list-header{align-items:flex-start;flex-direction:column}.customer-page .toolbar,.customer-page .search-box{width:100%}.customer-page .search-box{flex:1}.customer-page .table-responsive{overflow-x:auto}}
  @media(max-width:575.98px){.customer-page .customer-hero{align-items:flex-start;padding:22px;flex-direction:column}.customer-page .customer-hero h1{font-size:22px}.customer-page .hero-insight{width:100%;min-width:0}.customer-page .list-header{padding:17px}.customer-page .stat-card{min-height:84px;padding:13px}.customer-page .stat-value{font-size:19px}}
</style>

<section class="content customer-page"><div class="container-fluid">
  <div class="customer-hero"><div class="hero-copy"><span class="hero-eyebrow"><i class="fas fa-building mr-1"></i> Manajemen relasi bisnis</span><h1>Data Customer</h1><p>Temukan profil customer, pantau cakupan toko dan artikel, lalu kelola informasinya dari satu halaman.</p></div><div class="hero-insight"><i class="fas fa-chart-pie"></i><div><span>Customer dengan relasi</span><strong><?= number_format($customer_aktif) ?></strong><small>dari <?= number_format($total_customer) ?> customer</small></div></div></div>
  <div class="row">
    <?php $cards=array(array($total_customer,'users','Total customer','#2563eb','#eff6ff'),array($total_toko,'store','Total toko terhubung','#0284c7','#f0f9ff'),array($total_artikel,'boxes','Total artikel terdaftar','#16a34a','#f0fdf4')); foreach($cards as $card): ?>
      <div class="col-6 col-lg-4"><div class="stat-card" style="--color:<?= $card[3] ?>;--soft:<?= $card[4] ?>"><span class="stat-icon"><i class="fas fa-<?= $card[1] ?>"></i></span><div><p class="stat-value"><?= number_format($card[0]) ?></p><p class="stat-label"><?= $card[2] ?></p></div></div></div>
    <?php endforeach; ?>
  </div>
  <div class="list-card"><div class="list-header"><div><h2 class="list-title">Daftar customer</h2><p class="list-subtitle">Klik detail untuk melihat toko dan artikel yang terhubung.</p></div><div class="toolbar"><div class="search-box"><i class="fas fa-search"></i><input type="search" id="customerSearch" class="form-control" placeholder="Cari nama, kode, telepon..." aria-label="Cari customer"></div><div id="customerExport" class="export-tools"></div></div></div>
    <div class="table-responsive"><table id="customerTable" class="table customer-table"><thead><tr><th style="width:55px">No.</th><th>Customer</th><th>Kontak &amp; alamat</th><th class="text-center">Toko</th><th class="text-center">Artikel</th><th class="text-right">Aksi</th></tr></thead><tbody>
      <?php foreach($customer_list as $index=>$dd): $nama=(string)($dd->nama_cust??''); $kode=(string)($dd->kode_customer??''); $telp=(string)($dd->telp??''); $alamat=(string)($dd->alamat_cust??''); $initial=$nama!==''?strtoupper(substr($nama,0,1)):'C'; ?>
        <tr><td class="text-center text-muted"><?= $index+1 ?></td><td><div class="customer-info"><span class="customer-avatar"><?= html_escape($initial) ?></span><div><span class="customer-name"><?= html_escape($nama?:'Tanpa nama') ?></span><span class="customer-code"><i class="fas fa-circle"></i><?= html_escape($kode?:'Kode belum tersedia') ?></span></div></div></td>
        <td><span class="contact-line"><i class="fas fa-phone-alt"></i><?= html_escape($telp?:'Telepon belum tersedia') ?></span><span class="contact-line" title="<?= html_escape($alamat) ?>"><i class="fas fa-map-marker-alt"></i><?= html_escape($alamat!==''?ucwords(strtolower($alamat)):'Alamat belum tersedia') ?></span></td><td class="text-center"><span class="count-pill store"><i class="fas fa-store"></i><?= number_format((int)$dd->total_toko) ?></span></td><td class="text-center"><span class="count-pill product"><i class="fas fa-box"></i><?= number_format((int)$dd->total_produk) ?></span></td>
        <td><div class="actions"><a href="<?= base_url('adm/Customer/detail/'.$dd->id) ?>" class="action-btn" title="Lihat detail"><i class="fas fa-eye"></i></a><button type="button" class="action-btn btn-edit" title="Edit customer" data-id="<?= html_escape($dd->id) ?>" data-kode="<?= html_escape($kode) ?>" data-nama="<?= html_escape($nama) ?>" data-telp="<?= html_escape($telp) ?>" data-alamat="<?= html_escape($alamat) ?>" data-toggle="modal" data-target="#modal-update"><i class="fas fa-pen"></i></button><button type="button" class="action-btn danger btn_hapus" data-id="<?= html_escape($dd->id) ?>" data-nama="<?= html_escape($nama) ?>" title="Hapus customer"><i class="fas fa-trash-alt"></i></button></div></td></tr>
      <?php endforeach; ?>
    </tbody></table></div>
  </div>
</div></section>

     <?php if (false): // Legacy markup retained temporarily as a rollback reference. ?>
     <!-- Legacy table -->
     <section class="content legacy-customer-list" aria-hidden="true">
       <div class="container-fluid">
         <div class="row">
           <div class="col-12">

             <!-- /.card -->

             <div class="card card-info">
               <div class="card-header">
                 <h3 class="card-title">
                   <li class="fas fa-hospital"></li> Data Customer
                 </h3>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                 <table id="legacyExample1" class="table table-bordered table-striped">
                   <thead>
                     <tr class="text-center">
                       <th rowspan="2" style="width: 2%">No</th>
                       <th rowspan="2">Kode</th>
                       <th rowspan="2">Customer</th>
                       <th colspan="2">Jumlah</th>
                       <th rowspan="2" style="width: 13%;">Menu</th>
                     </tr>
                     <tr>
                       <th>Toko</th>
                       <th>Artikel</th>
                     </tr>
                   </thead>
                   <tbody>
                     <tr>
                       <?php if (!empty($customer)) { ?>
                         <?php $no = 1; ?>
                         <?php foreach ($customer as $dd) : ?>
                           <td><?= $no ?></td>
                           <td><small><b><?= $dd->kode_customer ?></b></small></td>
                           <td>
                             <small><b><?= $dd->nama_cust ?></b>
                               <br>
                               Alamat : <?= ucwords(strtolower($dd->alamat_cust)) ?>
                               <br>
                               Telp : <?= $dd->telp ?>
                             </small>
                           </td>
                           <td class="text-center"><?= $dd->total_toko ?></td>
                           <td class="text-center"><?= $dd->total_produk ?></td>
                           <td>
                             <a href="<?= base_url('adm/Customer/detail/' . $dd->id) ?>" class="btn btn-info btn-sm" title="Detail"><i class="fa fa-eye"></i></a>
                             <button class="btn btn-warning btn-sm btn-edit" title="Update" data-id="<?= $dd->id ?>" data-kode="<?= $dd->kode_customer ?>" data-nama="<?= $dd->nama_cust ?>" data-telp="<?= $dd->telp ?>" data-alamat="<?= $dd->alamat_cust ?>" data-toggle="modal" data-target="#modal-update"><i class="fa fa-edit"></i></button>
                             <button class="btn btn-danger btn-sm btn_hapus" data-id="<?= $dd->id ?>" title="Hapus"><i class="fa fa-trash"></i></button>
                           </td>
                     </tr>
                     <?php $no++; ?>
                   <?php endforeach; ?>
                 <?php } else { ?>
                   <td colspan="6" align="center"><strong>Data Kosong</strong></td>
                 <?php } ?>
                   </tbody>
                 </table>

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
     <?php endif; ?>
     <div class="modal fade customer-modal" id="modal-update" tabindex="-1" role="dialog" aria-labelledby="updateCustomerTitle" aria-hidden="true">
       <div class="modal-dialog modal-lg">
         <div class="modal-content">
           <div class="modal-header">
             <h5 class="modal-title" id="updateCustomerTitle"><i class="fas fa-user-edit mr-2"></i>
               Edit Customer
             </h5><button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
           </div>
           <form method="post" action="<?php echo base_url('adm/Customer/update'); ?>">
             <div class="modal-body">

               <div class="row">
                 <div class="col-md-12">
                   <div class="form-group">
                     <label for="file">Kode Customer</label>
                     <input type="hidden" name="id" class="form-control form-control-sm id">
                     <input type="text" name="kode" class="form-control form-control-sm kode" placeholder="kode customer...." required>
                   </div>
                   <div class="form-group">
                     <label for="file">Nama Customer</label>
                     <input type="text" name="nama" class="form-control form-control-sm nama" placeholder="nama customer...." required>
                   </div>
                   <div class="form-group">
                     <label for="file">Telp</label>
                     <input type="text" name="telp" class="form-control form-control-sm telp" placeholder="Telp customer....">
                   </div>
                   <div class="form-group">
                     <label>Alamat</label> </br>
                     <textarea class="form-control alamat" name="alamat"> </textarea>
                   </div>

                 </div>

               </div>
               <!-- end konten -->
             </div>
             <div class="modal-footer right">
               <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
                 <li class="fas fa-times-circle"></li> Cancel
               </button>
               <button type="submit" class="btn btn-sm btn-success">
                 <li class="fas fa-save"></li> Simpan
               </button>
             </div>
           </form>
         </div>
       </div>
     </div>
     <script>
       $(function() {
         var customerTable = $('#customerTable').DataTable({
           order: [[0, 'asc']],
           responsive: true,
           lengthChange: false,
           autoWidth: false,
           pageLength: 10,
           dom: 'Brt<"row align-items-center"<"col-sm-6"i><"col-sm-6"p>>',
           buttons: [
             { extend: 'excel', text: '<i class="fas fa-file-excel mr-1"></i> Excel', titleAttr: 'Ekspor Excel' },
             { extend: 'print', text: '<i class="fas fa-print"></i>', titleAttr: 'Cetak data' }
           ],
           language: {
             emptyTable: 'Belum ada data customer',
             zeroRecords: 'Customer yang dicari tidak ditemukan',
             info: 'Menampilkan _START_–_END_ dari _TOTAL_ customer',
             infoEmpty: 'Menampilkan 0 customer',
             infoFiltered: '(difilter dari _MAX_ customer)',
             paginate: { previous: '<i class="fas fa-chevron-left"></i>', next: '<i class="fas fa-chevron-right"></i>' }
           },
           columnDefs: [{ targets: 5, orderable: false, searchable: false }]
         });
         customerTable.buttons().container().appendTo('#customerExport');
         $('#customerSearch').on('input', function() { customerTable.search(this.value).draw(); });
       });

       $('.btn-edit').on('click', function() {
         // get data from button edit
         const id = $(this).data('id');
         const nama = $(this).data('nama');
         const telp = $(this).data('telp');
         const alamat = $(this).data('alamat');
         const kode = $(this).data('kode');

         // Set data to Form Edit
         $('.id').val(id);
         $('.nama').val(nama);
         $('.kode').val(kode);
         $('.telp').val(telp);
         $('.alamat').val(alamat);

         // Call Modal Edit
         $('#modal-update').modal('show');
       });
       $('.btn_hapus').click(function(e) {
         var id = $(this).data('id');
         Swal.fire({
           title: 'Apakah anda yakin?',
           text: "Data Customer akan dihapus dari database.",
           icon: 'info',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           cancelButtonText: 'Batal',
           confirmButtonText: 'Yakin'
         }).then((result) => {
           if (result.isConfirmed) {
             window.location.href = "<?= base_url('adm/Customer/hapus_cust') ?>/" + id;
           }
         })
       });
     </script>

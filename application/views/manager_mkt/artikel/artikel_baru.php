<?php
$artikel_baru = !empty($list_data) && is_array($list_data) ? $list_data : array();
$total_artikel = count($artikel_baru);
$total_qty = 0;
$toko_pengaju = array();
foreach ($artikel_baru as $artikel_item) {
  $total_qty += (int) ($artikel_item->qty ?? 0);
  if (isset($artikel_item->id_toko)) $toko_pengaju[(string) $artikel_item->id_toko] = true;
}
?>

<style>
  .new-article-page{--primary:#0f766e;--primary-dark:#115e59;--soft:#ecfdf5;--ink:#172033;--muted:#718096;--line:#e8edf5;padding-bottom:30px;color:var(--ink)}
  .new-article-page .article-hero{position:relative;display:flex;overflow:hidden;align-items:center;justify-content:space-between;gap:24px;margin-bottom:19px;padding:27px 30px;color:#fff;background:linear-gradient(120deg,#115e59 0%,#0f766e 55%,#14b8a6 135%);border-radius:19px;box-shadow:0 14px 34px rgba(15,118,110,.2)}
  .new-article-page .article-hero:before,.new-article-page .article-hero:after{position:absolute;content:'';border:1px solid rgba(255,255,255,.15);border-radius:50%}.new-article-page .article-hero:before{top:-115px;right:-52px;width:270px;height:270px}.new-article-page .article-hero:after{right:175px;bottom:-115px;width:195px;height:195px}
  .new-article-page .hero-copy,.new-article-page .hero-action{position:relative;z-index:1}.new-article-page .hero-eyebrow{display:block;margin-bottom:8px;color:rgba(255,255,255,.78);font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase}.new-article-page .article-hero h1{margin:0 0 7px;font-size:27px;font-weight:700;letter-spacing:-.02em}.new-article-page .article-hero p{max-width:650px;margin:0;color:rgba(255,255,255,.82);font-size:13px}.new-article-page .hero-action{display:inline-flex;min-width:132px;align-items:center;justify-content:center;gap:8px;padding:11px 15px;color:#fff;background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.19);border-radius:11px;font-size:12px;font-weight:700;white-space:nowrap}.new-article-page .hero-action:hover{color:#fff;background:rgba(255,255,255,.2)}
  .new-article-page .summary-card{display:flex;min-height:88px;align-items:center;gap:13px;margin-bottom:18px;padding:15px 16px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 5px 16px rgba(34,45,70,.04)}.new-article-page .summary-icon{display:flex;width:43px;height:43px;flex:0 0 43px;align-items:center;justify-content:center;color:var(--color);background:var(--summary-soft);border-radius:12px;font-size:16px}.new-article-page .summary-value{margin:0;color:#111827;font-size:22px;font-weight:700;line-height:1.1}.new-article-page .summary-label{margin:4px 0 0;color:var(--muted);font-size:11px}
  .new-article-page .guide-card{display:flex;align-items:flex-start;gap:13px;margin-bottom:18px;padding:15px 17px;color:#5f4a13;background:#fffbeb;border:1px solid #fde7ae;border-radius:13px}.new-article-page .guide-icon{display:flex;width:34px;height:34px;flex:0 0 34px;align-items:center;justify-content:center;color:#b7791f;background:#fef3c7;border-radius:9px}.new-article-page .guide-card strong{display:block;margin-bottom:3px;color:#704f08;font-size:12px}.new-article-page .guide-card p{margin:0;color:#80651e;font-size:11px;line-height:1.55}.new-article-page .guide-card .badge{padding:4px 7px;border-radius:999px;font-size:9px}
  .new-article-page .list-card{overflow:hidden;background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 7px 22px rgba(34,45,70,.05)}.new-article-page .list-header{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:18px 20px;border-bottom:1px solid var(--line)}.new-article-page .list-title{margin:0 0 3px;font-size:16px;font-weight:700}.new-article-page .list-subtitle{margin:0;color:var(--muted);font-size:11px}.new-article-page .list-toolbar{display:flex;align-items:center;gap:9px}.new-article-page .search-box{position:relative;width:285px}.new-article-page .search-box i{position:absolute;top:50%;left:13px;color:#9aa7b8;font-size:12px;transform:translateY(-50%)}.new-article-page .search-box input{height:39px;padding-left:36px;background:#f8fafc;border:1px solid var(--line);border-radius:9px;font-size:12px}.new-article-page .selected-pill{display:inline-flex;height:39px;align-items:center;gap:7px;padding:0 12px;color:#64748b;background:#f8fafc;border:1px solid var(--line);border-radius:9px;font-size:11px;font-weight:700;white-space:nowrap}.new-article-page .selected-pill.active{color:var(--primary);background:var(--soft);border-color:#99f6e4}
  .new-article-page .article-table{width:100%!important;margin:0!important;font-size:12px}.new-article-page .article-table thead th{padding:12px 14px;color:#64748b;background:#f8fafc;border-top:0;border-bottom:1px solid var(--line);font-size:10px;font-weight:700;letter-spacing:.055em;text-transform:uppercase;white-space:nowrap}.new-article-page .article-table tbody td{padding:13px 14px;vertical-align:middle;border-top:1px solid #f0f3f8}.new-article-page .article-table tbody tr:hover,.new-article-page .article-table tbody tr.row-selected{background:#f5fffc}.new-article-page .article-check,.new-article-page .check-all{width:16px;height:16px;accent-color:var(--primary);cursor:pointer}.new-article-page .store-link{color:#0f766e;font-weight:700}.new-article-page .product-code{color:#334155;font-weight:700;white-space:nowrap}.new-article-page .product-name{min-width:175px;color:#1f2937;font-weight:700}.new-article-page .qty-badge{display:inline-flex;min-width:37px;justify-content:center;padding:5px 8px;color:#475569;background:#f1f5f9;border-radius:7px;font-weight:700}.new-article-page .price{color:#253047;font-weight:700;white-space:nowrap}
  .new-article-page .action-bar{display:flex;align-items:center;justify-content:space-between;gap:15px;padding:14px 19px;background:#fbfcfe;border-top:1px solid var(--line)}.new-article-page .check-all-wrap{display:flex;align-items:center;gap:9px;margin:0;color:#526070;font-size:11px;font-weight:700;cursor:pointer}.new-article-page .action-buttons{display:flex;gap:9px}.new-article-page .action-buttons .btn{min-width:112px;padding:8px 14px;border:0;border-radius:9px;font-size:11px;font-weight:700;box-shadow:none}.new-article-page .btn-reject{color:#b42318;background:#feeceb}.new-article-page .btn-reject:hover{color:#fff;background:#dc3545}.new-article-page .btn-approve{color:#fff;background:var(--primary)}.new-article-page .btn-approve:hover{color:#fff;background:var(--primary-dark)}.new-article-page .action-buttons .btn:disabled{cursor:not-allowed;opacity:.5}
  .new-article-page .empty-state{padding:60px 20px;text-align:center}.new-article-page .empty-icon{display:flex;width:58px;height:58px;align-items:center;justify-content:center;margin:0 auto 14px;color:#0f766e;background:#ecfdf5;border-radius:17px;font-size:22px}.new-article-page .empty-state h3{margin:0 0 5px;color:#334155;font-size:15px;font-weight:700}.new-article-page .empty-state p{margin:0;color:var(--muted);font-size:12px}
  .new-article-page .dataTables_wrapper>.row:first-child{display:none}.new-article-page .dataTables_wrapper>.row:last-child{align-items:center;margin:0;padding:13px 19px;border-top:1px solid var(--line)}.new-article-page .dataTables_info,.new-article-page .dataTables_paginate{padding-top:0!important;color:var(--muted);font-size:11px}.new-article-page .pagination .page-link{margin:0 2px;color:#64748b;border:0;border-radius:7px;font-size:11px}.new-article-page .pagination .page-item.active .page-link{color:#fff;background:var(--primary)}
  @media(max-width:991.98px){.new-article-page .list-header{align-items:flex-start;flex-direction:column}.new-article-page .list-toolbar{width:100%}.new-article-page .search-box{flex:1}.new-article-page .table-responsive{overflow-x:auto}}
  @media(max-width:575.98px){.new-article-page .article-hero{align-items:flex-start;padding:22px;flex-direction:column}.new-article-page .article-hero h1{font-size:22px}.new-article-page .hero-action{width:100%}.new-article-page .list-toolbar{align-items:stretch;flex-direction:column}.new-article-page .search-box{width:100%}.new-article-page .selected-pill{justify-content:center}.new-article-page .action-bar{align-items:stretch;flex-direction:column}.new-article-page .action-buttons .btn{flex:1}}
</style>

     <!-- Main content -->
     <section class="content new-article-page">
      <div class="container-fluid">
        <div class="article-hero">
          <div class="hero-copy"><span class="hero-eyebrow"><i class="fas fa-box-open mr-1"></i> Persetujuan katalog</span><h1>Artikel Baru</h1><p>Tinjau pengajuan artikel dari toko, lalu setujui atau tolak beberapa item sekaligus.</p></div>
          <a href="<?= base_url('mng_mkt/Dashboard') ?>" class="hero-action"><i class="fas fa-arrow-left"></i> Dashboard</a>
        </div>
        <div class="row">
          <?php $ringkasan = array(array($total_artikel,'clipboard-list','Menunggu keputusan','#d97706','#fff7ed'),array(count($toko_pengaju),'store','Toko mengajukan','#0284c7','#f0f9ff'),array($total_qty,'boxes','Total kuantitas','#0f766e','#ecfdf5')); foreach ($ringkasan as $item_ringkasan): ?>
            <div class="col-12 col-sm-4"><div class="summary-card" style="--color:<?= $item_ringkasan[3] ?>;--summary-soft:<?= $item_ringkasan[4] ?>"><span class="summary-icon"><i class="fas fa-<?= $item_ringkasan[1] ?>"></i></span><div><p class="summary-value"><?= number_format($item_ringkasan[0]) ?></p><p class="summary-label"><?= $item_ringkasan[2] ?></p></div></div></div>
          <?php endforeach; ?>
        </div>
        <div class="guide-card"><span class="guide-icon"><i class="fas fa-lightbulb"></i></span><div><strong>Panduan singkat</strong><p>Artikel baru berstatus <span class="badge badge-danger">Belum aktif</span> dan belum dapat digunakan untuk transaksi. Pilih <span class="badge badge-success">Setujui</span> untuk menambahkannya ke katalog toko, atau <span class="badge badge-danger">Tolak</span> jika data belum sesuai.</p></div></div>
        <div class="row">
          <div class="col-12">
    
            <!-- /.card -->
         
            <div class="list-card">
              <div class="list-header">
                <div><h2 class="list-title">Daftar pengajuan</h2><p class="list-subtitle">Periksa toko, kode, nama, kuantitas, dan harga sebelum mengambil keputusan.</p></div>
                <?php if ($total_artikel > 0): ?><div class="list-toolbar"><div class="search-box"><i class="fas fa-search"></i><input type="search" id="articleSearch" class="form-control" placeholder="Cari toko, kode, atau artikel..." aria-label="Cari artikel"></div><span class="selected-pill" id="selectedCount"><i class="fas fa-check-square"></i> <span>0 dipilih</span></span></div><?php endif; ?>
              </div>
              <!-- /.card-header -->
              <div class="table-responsive">
                <?php if(!empty($list_data)){ ?>
                <table id ="table_artikel" class="table article-table">
                
                  <thead>
                    <tr>
                        <th>
                          Pilih
                        </th>
                        <th>Toko</th>
                        <th style="width:15%">Kode Artikel#</th>
                        <th style="width:25%">Nama Artikel</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Harga</th>
                        <th class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no = 0;
                    foreach($list_data as $dd):
                    $no++; ?>
                        <tr>
                        <td class="text-center"><input type="checkbox" class="article-check centang" value="<?= html_escape($dd->id) ?>" name="check[]" aria-label="Pilih artikel <?= html_escape($dd->nama_produk) ?>"></td>
                        <td><a class="store-link" href="<?= base_url('mng_mkt/Toko/profil/'.$dd->id_toko) ?>"><i class="fas fa-store mr-1"></i><?= html_escape($dd->nama_toko) ?></a></td>
                        <td><span class="product-code"><?= html_escape($dd->kode) ?></span></td>
                        <td><span class="product-name"><?= html_escape($dd->nama_produk) ?></span></td>
                        <td class="text-center"><span class="qty-badge"><?= number_format((int) $dd->qty) ?></span></td>
                        <td class="text-right">
                          <?php
                          if($dd->het == 1){
                            echo '<span class="price">Rp ' . number_format($dd->harga_jawa, 0, ',', '.') . '</span>';
                          }else {
                            echo '<span class="price">Rp ' . number_format($dd->harga_indobarat, 0, ',', '.') . '</span>';
                          }
                          ?>
                        </td>
                        <td class="text-center"><?= status_artikel($dd->status) ?></td>
                        </tr>
                    <?php endforeach;?>
                    
                     
                  </tbody>
                </table>
                <?php } else {?>
                    <div class="empty-state"><span class="empty-icon"><i class="fas fa-check"></i></span><h3>Tidak ada pengajuan baru</h3><p>Semua artikel telah ditinjau. Pengajuan berikutnya akan muncul di halaman ini.</p></div>
                    <?php } ?>
              </div>
              <!-- /.card-body -->
              <?php if ($total_artikel > 0): ?><div class="action-bar"><label class="check-all-wrap"><input type="checkbox" id="check-all" class="check-all check_btn"> Pilih semua pada halaman ini</label><div class="action-buttons"><button type="button" class="btn btn-reject btn_reject" disabled><i class="fas fa-times-circle mr-1"></i> Tolak</button><button type="button" class="btn btn-approve btn_terima" disabled><i class="fas fa-check-circle mr-1"></i> Setujui</button></div></div><?php endif; ?>
            </div>
          
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

  
    <!-- jQuery -->
    <script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/app/js/alert.js"></script>

 
      <script>
    $(document).ready(function(){
      if ($('#table_artikel').length) {
      $('#table_artikel').DataTable({
          order: [[1, 'asc']],
          responsive: true,
          lengthChange: false,
          autoWidth: false,
          pageLength: 10,
          dom: 'rt<"row align-items-center"<"col-sm-6"i><"col-sm-6"p>>',
          columnDefs: [{ orderable: false, targets: [0, 6] }],
          language: {
            emptyTable: 'Belum ada pengajuan artikel',
            zeroRecords: 'Artikel yang dicari tidak ditemukan',
            info: 'Menampilkan _START_-_END_ dari _TOTAL_ artikel',
            infoEmpty: 'Menampilkan 0 artikel',
            infoFiltered: '(difilter dari _MAX_ artikel)',
            paginate: { previous: '<i class="fas fa-chevron-left"></i>', next: '<i class="fas fa-chevron-right"></i>' }
          }
      });
      }

    })
  </script>
  <!-- fungsi check all -->
  <script>
    $(function() {
      if (!$('#table_artikel').length) return;

      var table = $('#table_artikel').DataTable();

      function selectedIds() {
        return table.rows().nodes().to$().find('.centang:checked').map(function() { return this.value; }).get();
      }

      function updateSelection() {
        var count = selectedIds().length;
        $('#selectedCount span').text(count + ' dipilih');
        $('#selectedCount').toggleClass('active', count > 0);
        $('.btn_terima, .btn_reject').prop('disabled', count === 0);
        table.rows().nodes().to$().find('.centang').each(function() { $(this).closest('tr').toggleClass('row-selected', this.checked); });

        var visibleChecks = table.rows({ page: 'current', search: 'applied' }).nodes().to$().find('.centang');
        $('#check-all').prop('checked', visibleChecks.length > 0 && visibleChecks.filter(':checked').length === visibleChecks.length);
      }

      $('#articleSearch').on('input', function() { table.search(this.value).draw(); });
      table.on('draw', updateSelection);
      $(document).off('change.articleSelection', '.centang').on('change.articleSelection', '.centang', updateSelection);
      $('.check_btn').off('change').on('change', function() {
        var checked = this.checked;
        table.rows({ page: 'current', search: 'applied' }).nodes().to$().find('.centang').prop('checked', checked);
        updateSelection();
      });

      function processArticles(action) {
        var ids = selectedIds();
        var approve = action === 'approve';
        if (!ids.length) return;

        Swal.fire({
          title: approve ? 'Setujui artikel?' : 'Tolak artikel?',
          text: ids.length + ' artikel yang dipilih akan ' + (approve ? 'ditambahkan ke katalog toko.' : 'ditolak.'),
          icon: approve ? 'question' : 'warning',
          type: approve ? 'question' : 'warning',
          showCancelButton: true,
          confirmButtonColor: approve ? '#0f766e' : '#dc3545',
          cancelButtonColor: '#94a3b8',
          confirmButtonText: approve ? 'Ya, setujui' : 'Ya, tolak',
          cancelButtonText: 'Batal'
        }).then(function(result) {
          if (!result.value && !result.isConfirmed) return;

          $('.btn_terima, .btn_reject').prop('disabled', true);
          Swal.fire({ title: 'Memproses...', text: 'Mohon tunggu sebentar.', allowOutsideClick: false, onOpen: function() { Swal.showLoading(); }, didOpen: function() { Swal.showLoading(); } });

          $.ajax({
            url: '<?= base_url('mng_mkt/Artikel/') ?>' + action,
            method: 'POST',
            dataType: 'text',
            data: { id: ids }
          }).done(function() {
            Swal.fire({ title: 'Berhasil', text: ids.length + ' artikel berhasil ' + (approve ? 'disetujui.' : 'ditolak.'), icon: 'success', type: 'success', confirmButtonColor: '#0f766e' })
              .then(function() { location.reload(); });
          }).fail(function() {
            Swal.fire({ title: 'Proses gagal', text: 'Terjadi gangguan saat menyimpan keputusan. Silakan coba kembali.', icon: 'error', type: 'error' });
            updateSelection();
          });
        });
      }

      $('.btn_terima').off('click').on('click', function() { processArticles('approve'); });
      $('.btn_reject').off('click').on('click', function() { processArticles('reject'); });
      updateSelection();
    });
  </script>

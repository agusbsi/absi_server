<?php
$assets = is_array($list_data) ? $list_data : array();
$summary = array('stores' => count($assets), 'assets' => 0, 'updated' => 0, 'pending' => 0);
$month_names = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
$month_short = array('Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des');
foreach ($assets as $asset) {
  $summary['assets'] += (int) $asset->total_aset;
  ((int) $asset->status_aset === 1) ? $summary['updated']++ : $summary['pending']++;
}
?>

<style>
  .asset-page{--primary:#2563eb;--ink:#172033;--muted:#718096;--line:#e6edf5;padding-bottom:30px;color:var(--ink)}
  .asset-page .asset-hero{position:relative;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:24px;margin-bottom:20px;padding:26px 29px;color:#fff;background:linear-gradient(120deg,#0f4c81 0%,#1678b9 58%,#22b8cf 140%);border-radius:18px;box-shadow:0 14px 34px rgba(15,91,145,.2)}
  .asset-page .asset-hero:before,.asset-page .asset-hero:after{position:absolute;content:'';border:1px solid rgba(255,255,255,.14);border-radius:50%}.asset-page .asset-hero:before{top:-108px;right:11%;width:240px;height:240px}.asset-page .asset-hero:after{right:-45px;bottom:-95px;width:190px;height:190px;background:rgba(255,255,255,.04)}
  .asset-page .hero-copy,.asset-page .hero-meta{position:relative;z-index:1}.asset-page .hero-eyebrow{display:block;margin-bottom:6px;color:rgba(255,255,255,.75);font-size:11px;font-weight:700;letter-spacing:.09em;text-transform:uppercase}.asset-page .asset-hero h1{margin:0 0 5px;font-size:25px;font-weight:700;letter-spacing:-.02em}.asset-page .asset-hero p{margin:0;color:rgba(255,255,255,.82);font-size:13px}
  .asset-page .hero-meta{display:flex;align-items:center;gap:10px;padding:10px 13px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);border-radius:11px;backdrop-filter:blur(5px)}.asset-page .hero-meta i{font-size:18px}.asset-page .hero-meta span{display:block;color:rgba(255,255,255,.72);font-size:10px}.asset-page .hero-meta strong{display:block;font-size:12px;white-space:nowrap}
  .asset-page .stat-card{display:flex;min-height:94px;align-items:center;gap:13px;margin-bottom:16px;padding:17px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 5px 16px rgba(34,45,70,.04)}.asset-page .stat-icon{display:flex;width:43px;height:43px;flex:0 0 43px;align-items:center;justify-content:center;color:var(--color);background:var(--soft);border-radius:12px;font-size:16px}.asset-page .stat-value{margin:0;color:#111827;font-size:23px;font-weight:700;line-height:1.1}.asset-page .stat-label{margin:4px 0 0;color:var(--muted);font-size:12px}
  .asset-page .list-card{overflow:hidden;background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 7px 22px rgba(34,45,70,.05)}.asset-page .list-header{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:19px 21px;border-bottom:1px solid var(--line)}.asset-page .list-title{margin:0 0 3px;font-size:16px;font-weight:700}.asset-page .list-subtitle{margin:0;color:var(--muted);font-size:12px}
  .asset-page .toolbar{display:flex;align-items:center;gap:9px}.asset-page .search-box{position:relative;min-width:240px}.asset-page .search-box i{position:absolute;top:50%;left:12px;color:#9aa7b8;font-size:12px;transform:translateY(-50%)}.asset-page .search-box input{height:38px;padding-left:34px;background:#f8fafc;border:1px solid var(--line);border-radius:9px;font-size:12px}.asset-page .filter-select{width:auto;min-width:145px;height:38px;background:#f8fafc;border-color:var(--line);border-radius:9px;font-size:12px}
  .asset-page .export-actions .dt-buttons{display:flex;gap:7px}.asset-page .export-actions .btn{display:inline-flex;align-items:center;gap:6px;height:38px;margin:0;padding:0 11px;background:#fff;border:1px solid var(--line);border-radius:9px;color:#475569;font-size:11px;font-weight:700;box-shadow:none}.asset-page .export-actions .btn:hover{color:#1d4ed8;background:#eff6ff;border-color:#bfdbfe}.asset-page .export-actions .btn.excel-btn:hover{color:#15803d;background:#ecfdf3;border-color:#bbf7d0}
  .asset-page .table-responsive{overflow:visible}.asset-page .asset-table{width:100%!important;margin:0!important;table-layout:fixed;font-size:12px}.asset-page .asset-table thead th{padding:12px 12px;color:#64748b;background:#f8fafc;border-top:0;border-bottom:1px solid var(--line);font-size:10px;font-weight:700;letter-spacing:.045em;text-transform:uppercase;white-space:normal}.asset-page .asset-table tbody td{padding:14px 12px;vertical-align:middle;border-top:1px solid #f0f3f8;overflow-wrap:anywhere}.asset-page .asset-table tbody tr:hover{background:#fbfdff}.asset-page .row-number{color:#94a3b8;font-weight:700}
  .asset-page .store-cell{display:flex;min-width:0;align-items:center;gap:10px}.asset-page .store-cell>div{min-width:0}.asset-page .store-icon{display:flex;width:40px;height:40px;flex:0 0 40px;align-items:center;justify-content:center;color:#1678b9;background:#eef8ff;border-radius:11px;font-size:15px}.asset-page .store-name{display:block;margin-bottom:3px;color:#1f2937;font-size:13px;font-weight:700}.asset-page .store-address{display:-webkit-box;overflow:hidden;color:var(--muted);font-size:11px;line-height:1.35;-webkit-box-orient:vertical;-webkit-line-clamp:2}.asset-page .store-address i{margin-right:5px;color:#a8b3c2}
  .asset-page .asset-count{display:inline-flex;align-items:baseline;gap:4px;color:#1f2937;font-size:16px;font-weight:700}.asset-page .asset-count small{color:var(--muted);font-size:10px;font-weight:600}.asset-page .empty-count{display:inline-flex;align-items:center;gap:6px;color:#b45309;font-size:11px;font-weight:700}.asset-page .status-pill{display:inline-flex;align-items:center;gap:7px;padding:6px 10px;border-radius:999px;font-size:10px;font-weight:700;white-space:nowrap}.asset-page .status-pill i{font-size:6px}.asset-page .status-pill.updated{color:#15803d;background:#ecfdf3}.asset-page .status-pill.pending{color:#b45309;background:#fff7ed}.asset-page .update-date{display:block;color:#334155;font-weight:600;white-space:nowrap}.asset-page .update-note{display:block;margin-top:3px;color:var(--muted);font-size:10px}
  .asset-page .detail-btn{display:inline-flex;align-items:center;gap:7px;padding:7px 11px;color:#1d4ed8;background:#eff6ff;border:1px solid #dbeafe;border-radius:8px;font-size:11px;font-weight:700;white-space:nowrap;transition:.15s}.asset-page .detail-btn:hover{color:#fff;background:#2563eb;border-color:#2563eb;box-shadow:0 5px 12px rgba(37,99,235,.18);transform:translateY(-1px)}
  .asset-page .empty-state{padding:42px 20px!important;text-align:center}.asset-page .empty-state i{display:flex;width:48px;height:48px;align-items:center;justify-content:center;margin:0 auto 10px;color:#94a3b8;background:#f1f5f9;border-radius:14px;font-size:18px}.asset-page .empty-state strong{display:block;margin-bottom:3px;color:#475569}.asset-page .empty-state span{color:#94a3b8;font-size:11px}
  .asset-page .table-footer{display:flex;align-items:center;justify-content:space-between;padding:13px 19px;border-top:1px solid var(--line)}.asset-page .dataTables_info,.asset-page .dataTables_paginate{padding-top:0!important}.asset-page .dataTables_info{color:var(--muted);font-size:11px}.asset-page .pagination .page-link{margin:0 2px;color:#64748b;border:0;border-radius:7px;font-size:11px}.asset-page .pagination .page-item.active .page-link{color:#fff;background:var(--primary)}
  @media(min-width:992px) and (max-width:1199.98px){.asset-page .asset-table thead th,.asset-page .asset-table tbody td{padding-left:8px;padding-right:8px}.asset-page .store-icon{width:34px;height:34px;flex-basis:34px}.asset-page .detail-btn{gap:5px;padding:7px 8px}.asset-page .status-pill{padding:6px 8px}}
  @media(max-width:991.98px){.asset-page .list-header{align-items:flex-start;flex-direction:column}.asset-page .toolbar{width:100%}.asset-page .search-box{min-width:0;flex:1}.asset-page .table-responsive{overflow-x:auto}.asset-page .asset-table{min-width:900px}}
  @media(max-width:575.98px){.asset-page .asset-hero{align-items:flex-start;padding:21px;flex-direction:column}.asset-page .asset-hero h1{font-size:21px}.asset-page .hero-meta{width:100%}.asset-page .toolbar{align-items:stretch;flex-direction:column}.asset-page .filter-select{width:100%}.asset-page .export-actions .dt-buttons,.asset-page .export-actions .btn{width:100%}.asset-page .export-actions .btn{justify-content:center}.asset-page .list-header{padding:17px}}
</style>

<section class="content asset-page"><div class="container-fluid">
  <div class="asset-hero">
    <div class="hero-copy"><span class="hero-eyebrow"><i class="fas fa-cubes mr-1"></i> Inventaris operasional</span><h1>Data Aset Toko</h1><p>Pantau jumlah aset dan progres pembaruan inventaris setiap toko.</p></div>
    <div class="hero-meta"><i class="far fa-calendar-check"></i><div><span>Periode pemantauan</span><strong><?= $month_names[(int)date('n')-1].' '.date('Y') ?></strong></div></div>
  </div>

  <div class="row">
    <?php $cards = array(array('stores','store','Total toko','#2563eb','#eff6ff'),array('assets','boxes','Total unit aset','#7c3aed','#f5f3ff'),array('updated','check-circle','Sudah diperbarui','#16a34a','#ecfdf3'),array('pending','clock','Perlu diperbarui','#d97706','#fff7ed')); foreach ($cards as $card) { ?>
      <div class="col-6 col-lg-3"><div class="stat-card" style="--color:<?= $card[3] ?>;--soft:<?= $card[4] ?>"><span class="stat-icon"><i class="fas fa-<?= $card[1] ?>"></i></span><div><p class="stat-value"><?= number_format($summary[$card[0]],0,',','.') ?></p><p class="stat-label"><?= $card[2] ?></p></div></div></div>
    <?php } ?>
  </div>

  <div class="list-card">
    <div class="list-header"><div><h2 class="list-title">Daftar toko</h2><p class="list-subtitle">Temukan toko dan buka rincian aset yang ingin diperiksa.</p></div>
      <div class="toolbar"><div class="search-box"><i class="fas fa-search"></i><input type="search" id="assetSearch" class="form-control" placeholder="Cari toko atau alamat..." aria-label="Cari toko"></div><select id="assetStatusFilter" class="form-control filter-select" aria-label="Filter status pembaruan"><option value="">Semua status</option><option value="Sudah diperbarui">Sudah diperbarui</option><option value="Perlu diperbarui">Perlu diperbarui</option></select><div id="assetExportButtons" class="export-actions" aria-label="Ekspor data aset"></div></div>
    </div>
    <div class="table-responsive"><table id="assetStoreTable" class="table asset-table">
      <colgroup><col style="width:5%"><col style="width:36%"><col style="width:12%"><col style="width:16%"><col style="width:17%"><col style="width:14%"></colgroup>
      <thead><tr><th class="text-center">No.</th><th>Toko</th><th class="text-center">Jumlah aset</th><th>Status</th><th>Pembaruan terakhir</th><th class="text-right">Aksi</th></tr></thead>
      <tbody>
        <?php if (!empty($assets)) { $no=1; foreach ($assets as $dd) { $is_updated=((int)$dd->status_aset===1); $has_date=!empty($dd->tanggal)&&strtotime($dd->tanggal)!==false; $detail_period=($has_date&&date('Y-m',strtotime($dd->tanggal))===date('Y-m'))?date('Y-m',strtotime($dd->tanggal)):'empty'; ?>
          <tr>
            <td class="text-center"><span class="row-number"><?= $no++ ?></span></td>
            <td><div class="store-cell"><span class="store-icon"><i class="fas fa-store"></i></span><div><span class="store-name"><?= html_escape($dd->nama_toko) ?></span><span class="store-address"><i class="fas fa-map-marker-alt"></i><?= !empty($dd->alamat)?html_escape($dd->alamat):'Alamat belum tersedia' ?></span></div></div></td>
            <td class="text-center"><?php if((int)$dd->total_aset>0){ ?><span class="asset-count"><?= number_format((int)$dd->total_aset,0,',','.') ?><small>unit</small></span><?php }else{ ?><span class="empty-count"><i class="fas fa-exclamation-circle"></i>Belum ada aset</span><?php } ?></td>
            <td><span class="status-pill <?= $is_updated?'updated':'pending' ?>"><i class="fas fa-circle"></i><?= $is_updated?'Sudah diperbarui':'Perlu diperbarui' ?></span></td>
            <td><?php if($has_date){ $update_time=strtotime($dd->tanggal); ?><span class="update-date"><?= date('d',$update_time).' '.$month_short[(int)date('n',$update_time)-1].' '.date('Y',$update_time) ?></span><span class="update-note"><?= date('H:i',$update_time) ?> WIB</span><?php }else{ ?><span class="update-date">Belum ada pembaruan</span><span class="update-note">Data belum dilaporkan</span><?php } ?></td>
            <td class="text-right"><a href="<?= base_url('adm/So/detail_aset/'.rawurlencode($dd->id_toko).'/'.$detail_period) ?>" class="detail-btn" title="Lihat detail aset <?= html_escape($dd->nama_toko) ?>"><i class="fas fa-eye"></i>Lihat detail</a></td>
          </tr>
        <?php }}else{ ?><tr><td colspan="6" class="empty-state"><i class="fas fa-box-open"></i><strong>Belum ada data aset toko</strong><span>Data akan tampil di sini ketika sudah tersedia.</span></td></tr><?php } ?>
      </tbody>
    </table></div>
  </div>
</div></section>

<script>
$(function(){
  if(!$.fn.DataTable||$('#assetStoreTable .empty-state').length)return;
  var exportConfig={columns:[0,1,2,3,4],format:{body:function(data,row,column,node){var cell=$(node);if(column===1)return cell.find('.store-name').text()+' - '+cell.find('.store-address').text();if(column===2)return cell.find('.asset-count,.empty-count').text().replace(/\s+/g,' ').trim();if(column===3)return cell.find('.status-pill').text().trim();if(column===4)return cell.find('.update-date').text()+' - '+cell.find('.update-note').text();return cell.text().replace(/\s+/g,' ').trim()}}};
  var table=$('#assetStoreTable').DataTable({order:[],responsive:false,lengthChange:false,autoWidth:false,pageLength:10,dom:'Brt<"table-footer"ip>',buttons:[{extend:'excelHtml5',text:'<i class="fas fa-file-excel"></i> Excel',className:'btn excel-btn',title:'Data Aset Toko - <?= $month_names[(int)date('n')-1].' '.date('Y') ?>',filename:'data-aset-toko-<?= date('Y-m') ?>',exportOptions:exportConfig},{extend:'print',text:'<i class="fas fa-print"></i> Print',className:'btn print-btn',title:'Data Aset Toko',messageTop:'Periode: <?= $month_names[(int)date('n')-1].' '.date('Y') ?>',exportOptions:exportConfig,customize:function(win){$(win.document.body).css('font-size','11px');$(win.document.body).find('h1').css({'font-size':'20px','margin-bottom':'5px'});$(win.document.body).find('table').addClass('compact').css('font-size','10px')}}],language:{emptyTable:'Belum ada data aset toko',zeroRecords:'Toko yang dicari tidak ditemukan',info:'Menampilkan _START_-_END_ dari _TOTAL_ toko',infoEmpty:'Menampilkan 0 toko',infoFiltered:'(difilter dari _MAX_ toko)',paginate:{previous:'<i class="fas fa-chevron-left"></i>',next:'<i class="fas fa-chevron-right"></i>'}},columnDefs:[{targets:[0,5],orderable:false},{targets:5,searchable:false}]});
  table.buttons().container().appendTo('#assetExportButtons');
  $('#assetSearch').on('input',function(){table.search(this.value).draw()});
  $('#assetStatusFilter').on('change',function(){var v=$.fn.dataTable.util.escapeRegex(this.value);table.column(3).search(v?'^'+v+'$':'',true,false).draw()});
});
</script>

<?php
$retur_items = is_array($list_data) ? $list_data : array();
$total_retur = count($retur_items);
$need_action = $in_progress = $completed = 0;
$status_options = array();
$status_labels = array(1=>'Verifikasi OPR',2=>'Verifikasi MM',3=>'Disetujui',4=>'Selesai',5=>'Ditolak',6=>'Menunggu penjemputan',7=>'Proses pengambilan');
foreach ($retur_items as $item) {
  $status = (int) $item->status;
  if ($status === 2) $need_action++;
  if (in_array($status, array(1,2,3,6,7), true)) $in_progress++;
  if ($status === 4) $completed++;
  $status_options[$status] = isset($status_labels[$status]) ? $status_labels[$status] : 'Status '.$status;
}
ksort($status_options);
?>

<style>
.retur-page{--primary:#0f766e;--ink:#172033;--muted:#718096;--line:#e8edf5;padding-bottom:28px;color:var(--ink)}
.retur-page .retur-hero{position:relative;display:flex;overflow:hidden;align-items:center;justify-content:space-between;gap:24px;margin-bottom:20px;padding:27px 30px;color:#fff;background:linear-gradient(120deg,#115e59 0%,#0f766e 55%,#14b8a6 135%);border-radius:19px;box-shadow:0 14px 34px rgba(15,118,110,.2)}
.retur-page .retur-hero:before,.retur-page .retur-hero:after{position:absolute;content:'';border:1px solid rgba(255,255,255,.15);border-radius:50%}.retur-page .retur-hero:before{top:-110px;right:-45px;width:255px;height:255px}.retur-page .retur-hero:after{right:175px;bottom:-110px;width:190px;height:190px}
.retur-page .hero-copy,.retur-page .hero-insight{position:relative;z-index:1}.retur-page .hero-eyebrow{display:block;margin-bottom:8px;color:rgba(255,255,255,.78);font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase}.retur-page .retur-hero h1{margin:0 0 7px;font-size:27px;font-weight:700}.retur-page .retur-hero p{max-width:620px;margin:0;color:rgba(255,255,255,.82);font-size:14px}
.retur-page .hero-insight{display:flex;min-width:225px;align-items:center;gap:12px;padding:13px 15px;background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.17);border-radius:13px;backdrop-filter:blur(7px)}.retur-page .hero-insight>i{font-size:22px}.retur-page .hero-insight span,.retur-page .hero-insight small{display:block;color:rgba(255,255,255,.76);font-size:10px}.retur-page .hero-insight strong{display:block;margin:1px 0;font-size:20px;line-height:1.1}
.retur-page .stat-card{display:flex;min-height:91px;align-items:center;gap:13px;margin-bottom:18px;padding:16px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 5px 16px rgba(34,45,70,.04)}.retur-page .stat-icon{display:flex;width:43px;height:43px;flex:0 0 43px;align-items:center;justify-content:center;color:var(--color);background:var(--stat-soft);border-radius:12px;font-size:16px}.retur-page .stat-value{margin:0;color:#111827;font-size:22px;font-weight:700;line-height:1.1}.retur-page .stat-label{margin:4px 0 0;color:var(--muted);font-size:11px}
.retur-page .list-card{overflow:hidden;background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 7px 22px rgba(34,45,70,.05)}.retur-page .list-header{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:19px 21px;border-bottom:1px solid var(--line)}.retur-page .list-title{margin:0 0 3px;font-size:16px;font-weight:700}.retur-page .list-subtitle{margin:0;color:var(--muted);font-size:12px}.retur-page .toolbar{display:flex;align-items:center;gap:8px}.retur-page .search-box{position:relative;width:265px}.retur-page .search-box i{position:absolute;top:50%;left:13px;color:#9aa7b8;font-size:12px;transform:translateY(-50%)}.retur-page .search-box input,.retur-page .status-filter{height:39px;background:#f8fafc;border:1px solid var(--line);border-radius:9px;font-size:12px}.retur-page .search-box input{padding-left:36px}.retur-page .status-filter{min-width:175px;padding:0 30px 0 11px;color:#526070}.retur-page .search-box input:focus,.retur-page .status-filter:focus{background:#fff;border-color:#5eead4;box-shadow:0 0 0 3px rgba(20,184,166,.09)}
.retur-page .table-responsive{overflow-x:auto}.retur-page .retur-table{width:100%!important;margin:0!important;font-size:12px}.retur-page .retur-table thead th{padding:12px 15px;color:#64748b;background:#f8fafc;border-top:0;border-bottom:1px solid var(--line);font-size:10px;font-weight:700;letter-spacing:.055em;text-transform:uppercase;white-space:nowrap}.retur-page .retur-table tbody td{padding:14px 15px;vertical-align:middle;border-top:1px solid #f0f3f8}.retur-page .retur-table tbody tr:hover{background:#fbfefd}.retur-page .retur-number{color:#94a3b8;font-weight:600;text-align:center}.retur-page .retur-id{display:inline-flex;align-items:center;gap:7px;color:#0f766e;font-weight:800;white-space:nowrap}.retur-page .store-name{display:block;max-width:250px;overflow:hidden;margin-bottom:4px;color:#1f2937;font-size:13px;font-weight:700;text-overflow:ellipsis;white-space:nowrap}.retur-page .store-spg{display:block;color:#718096;font-size:10px}.retur-page .store-spg i{width:16px;color:#a0aec0;font-size:9px}.retur-page .date-line{display:block;color:#334155;font-size:11px;font-weight:600;white-space:nowrap}.retur-page .date-line+.date-line{margin-top:5px;color:#718096;font-weight:400}.retur-page .date-line i{width:17px;color:#94a3b8;font-size:9px}.retur-page .status-cell .badge{display:inline-flex;align-items:center;padding:7px 10px;border-radius:999px;font-size:10px;font-weight:700;line-height:1.2;white-space:normal}.retur-page .action-btn{display:inline-flex;min-width:88px;align-items:center;justify-content:center;gap:7px;padding:8px 12px;border:0;border-radius:9px;font-size:11px;font-weight:700}.retur-page .action-btn.btn-success{background:#0f766e}.retur-page .action-btn.btn-success:hover{background:#115e59}.retur-page .action-btn.btn-primary{color:#475569;background:#f1f5f9}.retur-page .action-btn.btn-primary:hover{color:#0f766e;background:#ccfbf1}
.retur-page .dataTables_wrapper>.row:first-child{display:none}.retur-page .dataTables_wrapper>.row:last-child{align-items:center;margin:0;padding:13px 19px;border-top:1px solid var(--line)}.retur-page .dataTables_info,.retur-page .dataTables_paginate{padding-top:0!important;color:var(--muted);font-size:11px}.retur-page .pagination .page-link{margin:0 2px;color:#64748b;border:0;border-radius:7px;font-size:11px}.retur-page .pagination .page-item.active .page-link{color:#fff;background:var(--primary)}.retur-page .dataTables_empty{height:150px;color:var(--muted)!important;text-align:center!important}
@media(max-width:991.98px){.retur-page .list-header{align-items:flex-start;flex-direction:column}.retur-page .toolbar{width:100%}.retur-page .search-box{flex:1;width:auto}}
@media(max-width:767.98px){.retur-page .retur-table thead{display:none}.retur-page .retur-table,.retur-page .retur-table tbody,.retur-page .retur-table tr,.retur-page .retur-table td{display:block;width:100%!important}.retur-page .retur-table tbody{padding:8px 13px}.retur-page .retur-table tbody tr{margin:10px 0;padding:13px 14px;background:#fff;border:1px solid var(--line);border-radius:13px}.retur-page .retur-table tbody td{display:grid;grid-template-columns:105px minmax(0,1fr);align-items:center;padding:8px 0;border:0;text-align:left!important}.retur-page .retur-table tbody td:before{content:attr(data-label);color:#94a3b8;font-size:9px;font-weight:700;text-transform:uppercase}.retur-page .retur-table tbody td:first-child{display:none}.retur-page .retur-table tbody td:last-child{padding-top:11px;border-top:1px solid #f0f3f8}.retur-page .action-btn{width:100%}.retur-page .store-name{max-width:none}.retur-page .dataTables_empty{display:block!important;height:auto!important;padding:55px 10px!important}.retur-page .dataTables_empty:before{display:none}}
@media(max-width:575.98px){.retur-page .retur-hero{align-items:flex-start;padding:22px;flex-direction:column}.retur-page .retur-hero h1{font-size:22px}.retur-page .hero-insight{width:100%;min-width:0}.retur-page .list-header{padding:17px}.retur-page .stat-card{min-height:84px;padding:13px}.retur-page .stat-value{font-size:19px}.retur-page .toolbar{align-items:stretch;flex-direction:column}.retur-page .search-box,.retur-page .status-filter{width:100%}.retur-page .dataTables_wrapper>.row:last-child>div{text-align:center!important}.retur-page .dataTables_paginate .pagination{justify-content:center!important}}
</style>
<section class="content retur-page"><div class="container-fluid">
  <div class="retur-hero">
    <div class="hero-copy"><span class="hero-eyebrow"><i class="fas fa-exchange-alt mr-1"></i> Monitoring pengembalian barang</span><h1>Data Retur</h1><p>Pantau pengajuan, jadwal penjemputan, dan progres retur barang dari seluruh toko.</p></div>
    <div class="hero-insight"><i class="fas fa-clipboard-check"></i><div><span>Perlu tindakan Anda</span><strong><?= number_format($need_action) ?> pengajuan</strong><small>menunggu verifikasi Manager Marketing</small></div></div>
  </div>

  <div class="row">
    <?php $cards=array(array($total_retur,'clipboard-list','Total retur','#0f766e','#ecfdf5'),array($need_action,'hourglass-half','Perlu diproses','#d97706','#fffbeb'),array($in_progress,'truck-loading','Dalam proses','#2563eb','#eff6ff'),array($completed,'check-circle','Retur selesai','#16a34a','#f0fdf4')); foreach($cards as $card): ?>
      <div class="col-6 col-lg-3"><div class="stat-card" style="--color:<?= $card[3] ?>;--stat-soft:<?= $card[4] ?>"><span class="stat-icon"><i class="fas fa-<?= $card[1] ?>"></i></span><div><p class="stat-value"><?= number_format($card[0]) ?></p><p class="stat-label"><?= $card[2] ?></p></div></div></div>
    <?php endforeach; ?>
  </div>

  <div class="list-card">
    <div class="list-header">
      <div><h2 class="list-title">Daftar pengajuan retur</h2><p class="list-subtitle">Gunakan pencarian atau filter status untuk menemukan pengajuan lebih cepat.</p></div>
      <div class="toolbar"><div class="search-box"><i class="fas fa-search"></i><input type="search" id="returSearch" class="form-control" placeholder="Cari nomor, toko, atau SPG..." aria-label="Cari data retur"></div><select id="returStatus" class="form-control status-filter" aria-label="Filter status retur"><option value="">Semua status</option><?php foreach($status_options as $label): ?><option value="<?= html_escape($label) ?>"><?= html_escape($label) ?></option><?php endforeach; ?></select></div>
    </div>
    <div class="table-responsive"><table id="returTable" class="table retur-table">
      <thead><tr><th style="width:55px">No.</th><th>No. Retur</th><th>Toko &amp; SPG</th><th>Jadwal</th><th>Status</th><th style="width:110px">Aksi</th></tr></thead>
      <tbody>
        <?php foreach($retur_items as $index=>$data): $created_time=!empty($data->created_at)?strtotime($data->created_at):false; $pickup_time=!empty($data->tgl_jemput)?strtotime($data->tgl_jemput):false; $status=(int)$data->status; $status_label=isset($status_labels[$status])?$status_labels[$status]:'Status '.$status; ?>
          <tr>
            <td class="retur-number" data-label="No."><?= $index+1 ?></td>
            <td data-label="No. Retur"><span class="retur-id"><i class="fas fa-hashtag"></i><?= html_escape($data->id) ?></span></td>
            <td data-label="Toko &amp; SPG"><span class="store-name"><?= html_escape($data->nama_toko) ?></span><span class="store-spg"><i class="fas fa-user-tag"></i><?= html_escape($data->spg) ?></span></td>
            <td data-label="Jadwal" data-order="<?= $created_time!==false?$created_time:0 ?>"><span class="date-line"><i class="far fa-calendar-plus"></i>Dibuat <?= $created_time!==false?date('d M Y',$created_time):'-' ?></span><span class="date-line"><i class="fas fa-truck"></i>Jemput <?= $pickup_time!==false?date('d M Y',$pickup_time):'Belum dijadwalkan' ?></span></td>
            <td class="status-cell" data-label="Status" data-search="<?= html_escape($status_label) ?>"><?php status_retur($data->status); ?></td>
            <td data-label="Aksi"><?php if($status===2): ?><a class="btn btn-success action-btn" href="<?= base_url('mng_mkt/retur/detail_retur/'.$data->id) ?>" name="btn_proses"><span>Proses</span><i class="fas fa-arrow-right"></i></a><?php else: ?><a class="btn btn-primary action-btn" href="<?= base_url('mng_mkt/retur/detail_retur/'.$data->id) ?>" name="btn_detail"><i class="far fa-eye"></i><span>Detail</span></a><?php endif; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table></div>
  </div>
</div></section>

<script>
$(function(){
  var returTable=$('#returTable').DataTable({order:[[0,'asc']],responsive:false,lengthChange:false,autoWidth:false,pageLength:10,dom:'rt<"row align-items-center"<"col-sm-6"i><"col-sm-6"p>>',columnDefs:[{targets:5,orderable:false,searchable:false}],language:{emptyTable:'Belum ada pengajuan retur',zeroRecords:'Data retur yang dicari tidak ditemukan',info:'Menampilkan _START_-_END_ dari _TOTAL_ pengajuan',infoEmpty:'Menampilkan 0 pengajuan',infoFiltered:'(difilter dari _MAX_ pengajuan)',paginate:{previous:'<i class="fas fa-chevron-left"></i>',next:'<i class="fas fa-chevron-right"></i>'}}});
  $('#returSearch').on('input',function(){returTable.search(this.value).draw();});
  $('#returStatus').on('change',function(){returTable.column(4).search(this.value?'^'+$.fn.dataTable.util.escapeRegex(this.value)+'$':'',true,false).draw();});
});
</script>

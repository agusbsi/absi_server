<?php
$nama_user = html_escape($this->session->userdata('nama_user'));
$nama_bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
$periode_bulan = $nama_bulan[(int) date('n') - 1] . ' ' . date('Y');
$periode_ranking = $nama_bulan[(int) date('n', strtotime('last month')) - 1] . ' ' . date('Y', strtotime('last month'));
$total_toko = (int) ($t_toko->total ?? 0);
$total_user = (int) ($t_user->total ?? 0);
$total_stok = (int) ($t_stok->total ?? 0);
$total_minta = (int) ($t_minta->total ?? 0);
$total_kirim = (int) ($t_kirim->total ?? 0);
$total_jual = (int) ($t_jual->total ?? 0);
$total_retur = (int) ($t_retur->total ?? 0);
$total_aktivitas = $total_minta + $total_kirim + $total_jual + $total_retur;
?>

<style>
  .mkt-dashboard { --primary:#0f766e; --soft:#ecfdf5; --ink:#172033; --muted:#718096; --line:#e8edf5; padding-bottom:28px; color:var(--ink); }
  .mkt-dashboard .dashboard-hero { position:relative; overflow:hidden; margin-bottom:25px; padding:28px 32px; color:#fff; background:linear-gradient(120deg,#115e59 0%,#0f766e 52%,#14b8a6 125%); border-radius:20px; box-shadow:0 14px 34px rgba(15,118,110,.2); }
  .mkt-dashboard .dashboard-hero::before,.mkt-dashboard .dashboard-hero::after { position:absolute; content:''; border:1px solid rgba(255,255,255,.14); border-radius:50%; }
  .mkt-dashboard .dashboard-hero::before { top:-115px; right:-55px; width:280px; height:280px; }
  .mkt-dashboard .dashboard-hero::after { right:150px; bottom:-115px; width:205px; height:205px; }
  .mkt-dashboard .hero-content { position:relative; z-index:1; display:flex; align-items:center; justify-content:space-between; gap:24px; }
  .mkt-dashboard .hero-eyebrow { display:inline-flex; align-items:center; gap:8px; margin-bottom:10px; color:rgba(255,255,255,.8); font-size:12px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; }
  .mkt-dashboard .dashboard-hero h1 { margin:0 0 8px; font-size:28px; font-weight:700; letter-spacing:-.02em; }
  .mkt-dashboard .dashboard-hero p { max-width:620px; margin:0; color:rgba(255,255,255,.8); font-size:14px; }
  .mkt-dashboard .hero-summary { min-width:205px; padding:15px 18px; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.18); border-radius:14px; backdrop-filter:blur(6px); }
  .mkt-dashboard .hero-summary span,.mkt-dashboard .hero-summary small { display:block; color:rgba(255,255,255,.76); }
  .mkt-dashboard .hero-summary strong { display:block; margin:3px 0 1px; font-size:25px; line-height:1.15; }
  .mkt-dashboard .section-heading { display:flex; align-items:flex-end; justify-content:space-between; gap:16px; margin:27px 0 14px; }
  .mkt-dashboard .section-heading h2 { margin:0 0 3px; font-size:18px; font-weight:700; }
  .mkt-dashboard .section-heading p { margin:0; color:var(--muted); font-size:13px; }
  .mkt-dashboard .period-pill { flex:0 0 auto; padding:7px 11px; color:#526070; background:#fff; border:1px solid var(--line); border-radius:999px; font-size:12px; font-weight:600; }
  .mkt-dashboard .period-pill i { margin-right:5px; color:var(--primary); }
  .mkt-dashboard .overview-card,.mkt-dashboard .activity-card,.mkt-dashboard .panel-card { height:calc(100% - 16px); margin-bottom:16px; background:#fff; border:1px solid var(--line); border-radius:16px; box-shadow:0 5px 18px rgba(34,45,70,.045); }
  .mkt-dashboard .overview-card { position:relative; display:flex; min-height:126px; flex-direction:column; padding:18px; transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease; }
  .mkt-dashboard .overview-card:hover { border-color:#bfddd9; box-shadow:0 11px 25px rgba(34,45,70,.085); transform:translateY(-2px); }
  .mkt-dashboard .overview-icon,.mkt-dashboard .activity-icon { display:inline-flex; width:42px; height:42px; align-items:center; justify-content:center; border-radius:12px; }
  .mkt-dashboard .overview-icon { margin-bottom:14px; color:var(--primary); background:var(--soft); font-size:17px; }
  .mkt-dashboard .overview-value { margin:0; color:#111827; font-size:25px; font-weight:700; line-height:1; }
  .mkt-dashboard .overview-label { margin:6px 0 0; color:var(--muted); font-size:13px; }
  .mkt-dashboard .overview-link { position:absolute; top:18px; right:18px; display:inline-flex; width:31px; height:31px; align-items:center; justify-content:center; color:#91a1b3; background:#f7f9fc; border-radius:50%; transition:.18s ease; }
  .mkt-dashboard .overview-link:hover { color:#fff; background:var(--primary); }
  .mkt-dashboard .activity-card { position:relative; min-height:126px; padding:19px; overflow:hidden; }
  .mkt-dashboard .activity-card::after { position:absolute; right:-24px; bottom:-32px; width:92px; height:92px; content:''; background:var(--activity-soft); border-radius:50%; }
  .mkt-dashboard .activity-top { display:flex; align-items:center; gap:12px; margin-bottom:14px; }
  .mkt-dashboard .activity-icon { color:var(--activity-color); background:var(--activity-soft); }
  .mkt-dashboard .activity-label { margin:0; color:var(--muted); font-size:12px; font-weight:700; letter-spacing:.03em; text-transform:uppercase; }
  .mkt-dashboard .activity-value { position:relative; z-index:1; margin:0; color:#111827; font-size:23px; font-weight:700; }
  .mkt-dashboard .activity-value small { color:var(--muted); font-size:12px; font-weight:500; }
  .mkt-dashboard .panel-card { overflow:hidden; }
  .mkt-dashboard .panel-header { display:flex; min-height:67px; align-items:center; justify-content:space-between; gap:12px; padding:16px 20px; border-bottom:1px solid var(--line); }
  .mkt-dashboard .panel-title { margin:0; font-size:15px; font-weight:700; }
  .mkt-dashboard .panel-subtitle { display:block; margin-top:3px; color:var(--muted); font-size:12px; font-weight:400; }
  .mkt-dashboard .panel-badge { flex:0 0 auto; padding:6px 9px; color:var(--primary); background:var(--soft); border-radius:999px; font-size:11px; font-weight:700; }
  .mkt-dashboard .panel-body { padding:20px; }
  .mkt-dashboard .panel-footer-note { padding:11px 20px; color:var(--muted); background:#fbfcfe; border-top:1px solid var(--line); font-size:11px; }
  .mkt-dashboard .chart-wrap { position:relative; height:310px; }
  .mkt-dashboard .chart-state { position:absolute; z-index:2; inset:0; display:flex; align-items:center; justify-content:center; color:var(--muted); background:rgba(255,255,255,.86); font-size:13px; }
  .mkt-dashboard .ranking-list { padding:0; margin:0; list-style:none; }
  .mkt-dashboard .ranking-item { display:grid; grid-template-columns:34px minmax(0,1fr) auto; align-items:center; gap:11px; padding:13px 0; border-bottom:1px solid #f0f3f8; }
  .mkt-dashboard .ranking-item:first-child { padding-top:0; }.mkt-dashboard .ranking-item:last-child { padding-bottom:0; border-bottom:0; }
  .mkt-dashboard .rank-number { display:flex; width:32px; height:32px; align-items:center; justify-content:center; color:var(--primary); background:var(--soft); border-radius:10px; font-size:12px; font-weight:700; }
  .mkt-dashboard .rank-info { min-width:0; }.mkt-dashboard .rank-name { overflow:hidden; margin:0 0 3px; color:#253047; font-size:13px; font-weight:700; text-overflow:ellipsis; white-space:nowrap; }
  .mkt-dashboard .rank-meta { display:block; overflow:hidden; color:var(--muted); font-size:11px; text-overflow:ellipsis; white-space:nowrap; }
  .mkt-dashboard .rank-value { color:#253047; text-align:right; font-size:12px; font-weight:700; white-space:nowrap; }
  .mkt-dashboard .empty-state { padding:31px 12px; color:var(--muted); text-align:center; }.mkt-dashboard .empty-state i { display:block; margin-bottom:9px; color:#cbd5e1; font-size:27px; }
  @media (max-width:767.98px) { .mkt-dashboard .dashboard-hero{padding:23px 20px;border-radius:16px}.mkt-dashboard .hero-content{align-items:flex-start;flex-direction:column}.mkt-dashboard .dashboard-hero h1{font-size:23px}.mkt-dashboard .hero-summary{width:100%;min-width:0}.mkt-dashboard .section-heading{align-items:flex-start;flex-direction:column;gap:8px}.mkt-dashboard .chart-wrap{height:270px}.mkt-dashboard .panel-body{padding:16px} }
  @media (prefers-reduced-motion:reduce) { .mkt-dashboard .overview-card,.mkt-dashboard .overview-link{transition:none} }
</style>

<section class="content mkt-dashboard">
  <div class="container-fluid">
    <div class="dashboard-hero"><div class="hero-content">
      <div><span class="hero-eyebrow"><i class="fas fa-chart-line"></i> Dashboard Manager Marketing</span><h1>Selamat datang, <?= $nama_user ?>!</h1><p>Pantau aktivitas transaksi, performa penjualan, dan posisi stok seluruh toko dalam satu tampilan.</p></div>
      <div class="hero-summary"><span>Aktivitas bulan ini</span><strong><?= number_format($total_aktivitas) ?></strong><small>artikel diproses &bull; <?= $periode_bulan ?></small></div>
    </div></div>

    <div class="section-heading"><div><h2>Ringkasan operasional</h2><p>Data utama jaringan toko dan posisi stok terkini.</p></div><span class="period-pill"><i class="fas fa-sync-alt"></i> Data saat ini</span></div>
    <div class="row">
      <?php
      $overviews = array(
        array('label' => 'Toko aktif', 'value' => $total_toko, 'icon' => 'fas fa-store', 'url' => base_url('mng_mkt/Toko')),
        array('label' => 'User aktif', 'value' => $total_user, 'icon' => 'fas fa-users', 'url' => base_url('mng_mkt/User')),
        array('label' => 'Total stok seluruh toko', 'value' => $total_stok, 'icon' => 'fas fa-boxes', 'url' => '')
      );
      foreach ($overviews as $overview) : ?>
        <div class="col-lg-4 col-md-6"><article class="overview-card"><span class="overview-icon"><i class="<?= $overview['icon'] ?>"></i></span><h3 class="overview-value"><?= number_format($overview['value']) ?></h3><p class="overview-label"><?= $overview['label'] ?></p><?php if ($overview['url']) : ?><a href="<?= $overview['url'] ?>" class="overview-link" aria-label="Lihat <?= $overview['label'] ?>" title="Lihat data"><i class="fas fa-arrow-right"></i></a><?php endif; ?></article></div>
      <?php endforeach; ?>
    </div>

    <div class="section-heading"><div><h2>Aktivitas bulan ini</h2><p>Jumlah artikel pada setiap alur transaksi.</p></div><span class="period-pill"><i class="far fa-calendar-alt"></i> <?= $periode_bulan ?></span></div>
    <div class="row">
      <?php
      $activities = array(
        array('label' => 'Permintaan', 'value' => $total_minta, 'icon' => 'fas fa-clipboard-list', 'color' => '#d97706', 'soft' => '#fff7ed'),
        array('label' => 'Pengiriman', 'value' => $total_kirim, 'icon' => 'fas fa-truck', 'color' => '#0284c7', 'soft' => '#f0f9ff'),
        array('label' => 'Penjualan', 'value' => $total_jual, 'icon' => 'fas fa-shopping-cart', 'color' => '#16a34a', 'soft' => '#f0fdf4'),
        array('label' => 'Retur', 'value' => $total_retur, 'icon' => 'fas fa-undo-alt', 'color' => '#dc2626', 'soft' => '#fef2f2')
      );
      foreach ($activities as $activity) : ?>
        <div class="col-xl-3 col-md-6"><article class="activity-card" style="--activity-color:<?= $activity['color'] ?>;--activity-soft:<?= $activity['soft'] ?>"><div class="activity-top"><span class="activity-icon"><i class="<?= $activity['icon'] ?>"></i></span><p class="activity-label"><?= $activity['label'] ?></p></div><p class="activity-value"><?= number_format($activity['value']) ?> <small>artikel</small></p></article></div>
      <?php endforeach; ?>
    </div>

    <div class="section-heading"><div><h2>Tren transaksi</h2><p>Perbandingan penjualan, pengiriman, dan retur sepanjang tahun.</p></div><span class="period-pill"><i class="fas fa-chart-bar"></i> Jan&ndash;<?= $nama_bulan[(int) date('n') - 1] ?></span></div>
    <div class="panel-card"><div class="panel-header"><h3 class="panel-title">Transaksi semua toko<span class="panel-subtitle">Akumulasi jumlah artikel per bulan</span></h3><span class="panel-badge">Tahun <?= date('Y') ?></span></div><div class="panel-body"><div class="chart-wrap"><div class="chart-state" id="transaksi-chart-state"><i class="fas fa-circle-notch fa-spin mr-2"></i> Memuat grafik...</div><canvas id="grafikTransaksi" aria-label="Grafik transaksi semua toko" role="img"></canvas></div></div></div>

    <div class="section-heading"><div><h2>Performa &amp; distribusi stok</h2><p>Peringkat penjualan bulan sebelumnya dan posisi stok terbaru.</p></div><span class="period-pill"><i class="fas fa-trophy"></i> <?= $periode_ranking ?></span></div>
    <div class="row">
      <div class="col-xl-6"><div class="panel-card"><div class="panel-header"><h3 class="panel-title">Toko dengan penjualan tertinggi<span class="panel-subtitle">Top 5 berdasarkan jumlah artikel</span></h3><span class="panel-badge">Teratas</span></div><div class="panel-body">
        <div id="ranking-toko" class="empty-state"><i class="fas fa-circle-notch fa-spin"></i>Memuat peringkat toko...</div>
      </div><div class="panel-footer-note">Periode penjualan: <?= $periode_ranking ?></div></div></div>
      <div class="col-xl-6"><div class="panel-card"><div class="panel-header"><h3 class="panel-title">Artikel paling banyak terjual<span class="panel-subtitle">Top 5 berdasarkan kuantitas terjual</span></h3><span class="panel-badge">Terlaris</span></div><div class="panel-body">
        <div id="ranking-artikel" class="empty-state"><i class="fas fa-circle-notch fa-spin"></i>Memuat peringkat artikel...</div>
      </div><div class="panel-footer-note">Periode penjualan: <?= $periode_ranking ?></div></div></div>
      <div class="col-12"><div class="panel-card"><div class="panel-header"><h3 class="panel-title">Toko dengan stok terbesar<span class="panel-subtitle">Top 5 posisi stok seluruh toko saat ini</span></h3><span class="panel-badge">Stok</span></div><div class="panel-body">
        <div id="ranking-stok" class="empty-state"><i class="fas fa-circle-notch fa-spin"></i>Memuat posisi stok...</div>
      </div><div class="panel-footer-note"><i class="fas fa-info-circle mr-1"></i> Posisi data diperbarui <?= date('d/m/Y H:i') ?></div></div></div>
    </div>
  </div>
</section>

<script src="<?= base_url('assets/plugins/chart.js/Chart.min.js') ?>"></script>
<script>
  $(function() {
    var formatter = new Intl.NumberFormat('id-ID');
    var months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'].slice(0, new Date().getMonth() + 1);

    function escapeHtml(value) {
      return $('<div>').text(value || '-').html();
    }

    function renderRanking(selector, items, type) {
      if (!items || !items.length) {
        $(selector).html('<i class="fas fa-inbox"></i>Belum ada data untuk ditampilkan.');
        return;
      }

      var rows = $.map(items, function(item, index) {
        var isProduct = type === 'artikel';
        var name = isProduct ? item.kode : item.nama_toko;
        var meta = isProduct ? item.nama_produk : item.spg;
        var unit = isProduct ? ' terjual' : ' artikel';
        return '<li class="ranking-item">' +
          '<span class="rank-number">' + (index + 1) + '</span>' +
          '<div class="rank-info"><p class="rank-name" title="' + escapeHtml(name) + '">' + escapeHtml(name) + '</p>' +
          '<span class="rank-meta">' + escapeHtml(meta) + '</span></div>' +
          '<span class="rank-value">' + formatter.format(parseInt(item.total, 10) || 0) + unit + '</span></li>';
      }).join('');

      $(selector).replaceWith('<ol class="ranking-list">' + rows + '</ol>');
    }

    $.ajax({ url:'<?= base_url('mng_mkt/Dashboard/ranking') ?>', dataType:'json', timeout:15000 }).done(function(data) {
      renderRanking('#ranking-toko', data.top_toko, 'toko');
      renderRanking('#ranking-artikel', data.top_artikel, 'artikel');
      renderRanking('#ranking-stok', data.top_stok, 'stok');
    }).fail(function() {
      $('#ranking-toko, #ranking-artikel, #ranking-stok').html('<i class="fas fa-exclamation-circle text-danger"></i>Data gagal dimuat.');
    });

    $.ajax({ url:'<?= base_url('mng_mkt/Dashboard/transaksi') ?>', dataType:'json', timeout:15000 }).done(function(data) {
      $('#transaksi-chart-state').remove();
      new Chart($('#grafikTransaksi').get(0).getContext('2d'), { type:'bar', data:{ labels:months, datasets:[
        { label:'Penjualan', data:data.jual || [], backgroundColor:'#0f766e' },
        { label:'Pengiriman', data:data.kirim || [], backgroundColor:'#38bdf8' },
        { label:'Retur', data:data.retur || [], backgroundColor:'#f87171' }
      ]}, options:{ responsive:true, maintainAspectRatio:false, animation:{ duration:450 }, legend:{ position:'bottom', labels:{ usePointStyle:true, padding:20, fontColor:'#64748b' } }, tooltips:{ mode:'index', intersect:false, callbacks:{ label:function(item,chart){ return ' ' + chart.datasets[item.datasetIndex].label + ': ' + formatter.format(item.yLabel) + ' artikel'; } } }, scales:{ xAxes:[{ gridLines:{ display:false }, ticks:{ fontColor:'#718096' }, barPercentage:.72, categoryPercentage:.68 }], yAxes:[{ gridLines:{ color:'#edf1f7', drawBorder:false }, ticks:{ beginAtZero:true, precision:0, fontColor:'#718096', callback:function(value){ return formatter.format(value); } } }] } } });
    }).fail(function() { $('#transaksi-chart-state').html('<span class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i> Grafik gagal dimuat. Silakan muat ulang halaman.</span>'); });
  });
</script>

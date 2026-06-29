<?php
$nama_user = html_escape($this->session->userdata('nama_user'));
$periode_bulan = date('M Y');
$periode_ranking = date('M Y', strtotime('last month'));
$total_bulan = (int) ($t_minta->total ?? 0) + (int) ($t_kirim->total ?? 0) + (int) ($t_jual->total ?? 0) + (int) ($t_retur->total ?? 0);
?>

<style>
  .adm-dashboard {
    --primary: #2563eb;
    --ink: #172033;
    --muted: #718096;
    --line: #e8edf5;
    padding-bottom: 24px;
    color: var(--ink);
  }

  .adm-dashboard .dashboard-hero {
    position: relative;
    overflow: hidden;
    margin-bottom: 24px;
    padding: 28px 32px;
    color: #fff;
    background: linear-gradient(120deg, #1d4ed8 0%, #2563eb 55%, #38bdf8 130%);
    border-radius: 20px;
    box-shadow: 0 14px 35px rgba(37, 99, 235, .22);
  }

  .adm-dashboard .dashboard-hero::before,
  .adm-dashboard .dashboard-hero::after {
    position: absolute;
    content: '';
    border: 1px solid rgba(255, 255, 255, .15);
    border-radius: 50%;
  }

  .adm-dashboard .dashboard-hero::before { top: -105px; right: -65px; width: 280px; height: 280px; }
  .adm-dashboard .dashboard-hero::after { right: 135px; bottom: -115px; width: 210px; height: 210px; }

  .adm-dashboard .hero-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
  }

  .adm-dashboard .hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
    color: rgba(255, 255, 255, .82);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
  }

  .adm-dashboard .dashboard-hero h1 { margin: 0 0 8px; font-size: 28px; font-weight: 700; letter-spacing: -.02em; }
  .adm-dashboard .dashboard-hero p { max-width: 620px; margin: 0; color: rgba(255, 255, 255, .82); font-size: 15px; }

  .adm-dashboard .hero-summary {
    min-width: 190px;
    padding: 15px 18px;
    background: rgba(255, 255, 255, .13);
    border: 1px solid rgba(255, 255, 255, .18);
    border-radius: 14px;
    backdrop-filter: blur(7px);
  }

  .adm-dashboard .hero-summary span,
  .adm-dashboard .hero-summary small { display: block; color: rgba(255, 255, 255, .76); }
  .adm-dashboard .hero-summary strong { display: block; margin: 3px 0 1px; font-size: 24px; line-height: 1.15; }

  .adm-dashboard .section-heading {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 16px;
    margin: 28px 0 14px;
  }

  .adm-dashboard .section-heading h2 { margin: 0 0 3px; font-size: 18px; font-weight: 700; }
  .adm-dashboard .section-heading p { margin: 0; color: var(--muted); font-size: 13px; }

  .adm-dashboard .period-pill {
    flex: 0 0 auto;
    padding: 7px 11px;
    color: #526070;
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
  }

  .adm-dashboard .period-pill i { margin-right: 5px; color: var(--primary); }

  .adm-dashboard .overview-card,
  .adm-dashboard .activity-card,
  .adm-dashboard .panel-card {
    height: calc(100% - 16px);
    margin-bottom: 16px;
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 16px;
    box-shadow: 0 5px 18px rgba(34, 45, 70, .045);
  }

  .adm-dashboard .overview-card {
    position: relative;
    display: flex;
    min-height: 132px;
    flex-direction: column;
    padding: 18px;
    transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
  }

  .adm-dashboard .overview-card:hover { border-color: #cdd9ef; box-shadow: 0 12px 26px rgba(34, 45, 70, .09); transform: translateY(-2px); }

  .adm-dashboard .overview-icon,
  .adm-dashboard .activity-icon {
    display: inline-flex;
    width: 42px;
    height: 42px;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
  }

  .adm-dashboard .overview-icon { margin-bottom: 14px; color: var(--primary); background: #eff6ff; font-size: 17px; }
  .adm-dashboard .overview-value { margin: 0; color: #111827; font-size: 24px; font-weight: 700; line-height: 1; }
  .adm-dashboard .overview-label { margin: 6px 0 0; color: var(--muted); font-size: 13px; }

  .adm-dashboard .overview-link {
    position: absolute;
    top: 18px;
    right: 18px;
    display: inline-flex;
    width: 30px;
    height: 30px;
    align-items: center;
    justify-content: center;
    color: #9aa7b8;
    background: #f7f9fc;
    border-radius: 50%;
    transition: .2s ease;
  }

  .adm-dashboard .overview-link:hover { color: #fff; background: var(--primary); }

  .adm-dashboard .activity-card { position: relative; min-height: 132px; padding: 20px; overflow: hidden; }
  .adm-dashboard .activity-card::after { position: absolute; right: -22px; bottom: -30px; width: 90px; height: 90px; content: ''; background: var(--soft); border-radius: 50%; }
  .adm-dashboard .activity-top { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
  .adm-dashboard .activity-icon { color: var(--color); background: var(--soft); }
  .adm-dashboard .activity-label { margin: 0; color: var(--muted); font-size: 12px; font-weight: 600; letter-spacing: .03em; text-transform: uppercase; }
  .adm-dashboard .activity-value { position: relative; z-index: 1; margin: 0; color: #111827; font-size: 23px; font-weight: 700; }
  .adm-dashboard .activity-value small { color: var(--muted); font-size: 12px; font-weight: 500; }

  .adm-dashboard .panel-card { overflow: hidden; }
  .adm-dashboard .panel-header { display: flex; min-height: 68px; align-items: center; justify-content: space-between; gap: 12px; padding: 17px 20px; border-bottom: 1px solid var(--line); }
  .adm-dashboard .panel-title { margin: 0; font-size: 15px; font-weight: 700; }
  .adm-dashboard .panel-subtitle { display: block; margin-top: 3px; color: var(--muted); font-size: 12px; font-weight: 400; }
  .adm-dashboard .panel-badge { flex: 0 0 auto; padding: 6px 9px; color: #2563eb; background: #eff6ff; border-radius: 999px; font-size: 11px; font-weight: 700; }
  .adm-dashboard .panel-badge.danger { color: #dc2626; background: #fef2f2; }
  .adm-dashboard .panel-body { padding: 20px; }
  .adm-dashboard .panel-footer-note { padding: 12px 20px; color: var(--muted); background: #fbfcfe; border-top: 1px solid var(--line); font-size: 11px; }

  .adm-dashboard .chart-wrap { position: relative; height: 310px; }
  .adm-dashboard .chart-wrap.chart-small { height: 285px; }
  .adm-dashboard .chart-state { position: absolute; z-index: 2; inset: 0; display: flex; align-items: center; justify-content: center; color: var(--muted); background: rgba(255, 255, 255, .82); font-size: 13px; }

  .adm-dashboard .ranking-list { padding: 0; margin: 0; list-style: none; }
  .adm-dashboard .ranking-item { display: grid; grid-template-columns: 34px minmax(0, 1fr) auto; align-items: center; gap: 11px; padding: 13px 0; border-bottom: 1px solid #f0f3f8; }
  .adm-dashboard .ranking-item:first-child { padding-top: 0; }
  .adm-dashboard .ranking-item:last-child { padding-bottom: 0; border-bottom: 0; }
  .adm-dashboard .rank-number { display: flex; width: 32px; height: 32px; align-items: center; justify-content: center; color: var(--primary); background: #eff6ff; border-radius: 10px; font-size: 12px; font-weight: 700; }
  .adm-dashboard .ranking-list.negative .rank-number { color: #dc2626; background: #fef2f2; }
  .adm-dashboard .rank-info { min-width: 0; }
  .adm-dashboard .rank-name { overflow: hidden; margin: 0 0 3px; color: #253047; font-size: 13px; font-weight: 700; text-overflow: ellipsis; white-space: nowrap; }
  .adm-dashboard .rank-meta { display: block; overflow: hidden; color: var(--muted); font-size: 11px; text-overflow: ellipsis; white-space: nowrap; }
  .adm-dashboard .rank-value { text-align: right; font-size: 13px; font-weight: 700; white-space: nowrap; }
  .adm-dashboard .rank-trend { display: block; margin-top: 3px; font-size: 10px; font-weight: 600; }
  .adm-dashboard .empty-state { padding: 32px 12px; color: var(--muted); text-align: center; }
  .adm-dashboard .empty-state i { display: block; margin-bottom: 9px; color: #cbd5e1; font-size: 27px; }

  .adm-dashboard .stock-table { margin-bottom: 0; font-size: 12px; }
  .adm-dashboard .stock-table thead th { color: #64748b; background: #f8fafc; border-top: 0; border-bottom: 1px solid var(--line); font-weight: 700; white-space: nowrap; }
  .adm-dashboard .stock-table td, .adm-dashboard .stock-table th { padding: 11px 10px; vertical-align: middle; }
  .adm-dashboard .stock-table tfoot th { color: #253047; background: #f8fafc; border-top: 1px solid var(--line); }

  .adm-dashboard .calendar-panel .bootstrap-datetimepicker-widget { width: 100%; }
  .adm-dashboard .calendar-panel .table td, .adm-dashboard .calendar-panel .table th { border-top: 0; }
  .adm-dashboard .calendar-panel .bootstrap-datetimepicker-widget table td.active,
  .adm-dashboard .calendar-panel .bootstrap-datetimepicker-widget table td.active:hover { background: var(--primary); border-radius: 8px; }

  @media (max-width: 767.98px) {
    .adm-dashboard .dashboard-hero { padding: 24px 20px; border-radius: 16px; }
    .adm-dashboard .hero-content { align-items: flex-start; flex-direction: column; }
    .adm-dashboard .dashboard-hero h1 { font-size: 23px; }
    .adm-dashboard .hero-summary { width: 100%; min-width: 0; }
    .adm-dashboard .section-heading { align-items: flex-start; flex-direction: column; gap: 8px; }
    .adm-dashboard .overview-card { min-height: 122px; }
    .adm-dashboard .chart-wrap { height: 270px; }
    .adm-dashboard .ranking-item { grid-template-columns: 32px minmax(0, 1fr) auto; gap: 9px; }
    .adm-dashboard .panel-body { padding: 16px; }
  }
</style>

<section class="content adm-dashboard">
  <div class="container-fluid">
    <div class="dashboard-hero">
      <div class="hero-content">
        <div>
          <span class="hero-eyebrow"><i class="fas fa-chart-line"></i> Ringkasan operasional</span>
          <h1>Selamat datang, <?= $nama_user ?>!</h1>
          <p>Pantau transaksi, penjualan, dan posisi stok seluruh toko dari satu tampilan.</p>
        </div>
        <div class="hero-summary">
          <span>Aktivitas bulan ini</span>
          <strong><?= number_format($total_bulan) ?></strong>
          <small>total artikel diproses &bull; <?= $periode_bulan ?></small>
        </div>
      </div>
    </div>

    <div class="section-heading">
      <div><h2>Ringkasan data</h2><p>Akses cepat ke data master dan posisi stok terkini.</p></div>
      <span class="period-pill"><i class="fas fa-sync-alt"></i> Data saat ini</span>
    </div>
    <div class="row">
      <?php foreach ($box as $info_box) : ?>
        <div class="col-xl-3 col-md-4 col-6">
          <article class="overview-card">
            <span class="overview-icon"><i class="<?= html_escape($info_box->icon) ?>"></i></span>
            <h3 class="overview-value count"><?= number_format((int) $info_box->total) ?></h3>
            <p class="overview-label"><?= html_escape($info_box->title) ?></p>
            <a href="<?= base_url(strtolower($info_box->link)) ?>" class="overview-link" aria-label="Lihat <?= html_escape($info_box->title) ?>" title="Lihat data"><i class="fas fa-arrow-right"></i></a>
          </article>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="section-heading">
      <div><h2>Aktivitas bulan ini</h2><p>Jumlah artikel pada setiap alur transaksi.</p></div>
      <span class="period-pill"><i class="far fa-calendar-alt"></i> <?= $periode_bulan ?></span>
    </div>
    <div class="row">
      <?php
      $activities = array(
        array('label' => 'Permintaan', 'value' => $t_minta->total, 'icon' => 'fas fa-clipboard-list', 'color' => '#d97706', 'soft' => '#fff7ed'),
        array('label' => 'Pengiriman', 'value' => $t_kirim->total, 'icon' => 'fas fa-truck', 'color' => '#0284c7', 'soft' => '#f0f9ff'),
        array('label' => 'Penjualan', 'value' => $t_jual->total, 'icon' => 'fas fa-shopping-cart', 'color' => '#16a34a', 'soft' => '#f0fdf4'),
        array('label' => 'Retur', 'value' => $t_retur->total, 'icon' => 'fas fa-undo-alt', 'color' => '#dc2626', 'soft' => '#fef2f2')
      );
      foreach ($activities as $activity) : ?>
        <div class="col-xl-3 col-md-6">
          <article class="activity-card" style="--color: <?= $activity['color'] ?>; --soft: <?= $activity['soft'] ?>;">
            <div class="activity-top"><span class="activity-icon"><i class="<?= $activity['icon'] ?>"></i></span><p class="activity-label"><?= $activity['label'] ?></p></div>
            <p class="activity-value"><?= number_format((int) $activity['value']) ?> <small>artikel</small></p>
          </article>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="section-heading">
      <div><h2>Tren transaksi</h2><p>Perbandingan pengiriman, penjualan, dan retur sepanjang <?= date('Y') ?>.</p></div>
      <span class="period-pill"><i class="fas fa-chart-bar"></i> Jan&ndash;<?= date('M') ?></span>
    </div>
    <div class="panel-card">
      <div class="panel-header"><h3 class="panel-title">Transaksi semua toko<span class="panel-subtitle">Akumulasi artikel per bulan</span></h3><span class="panel-badge">Tahun <?= date('Y') ?></span></div>
      <div class="panel-body"><div class="chart-wrap"><div class="chart-state" id="transaksi-chart-state"><i class="fas fa-circle-notch fa-spin mr-2"></i> Memuat grafik...</div><canvas id="grafikTransaksi"></canvas></div></div>
    </div>

    <div class="section-heading">
      <div><h2>Performa penjualan</h2><p>Peringkat toko dan artikel berdasarkan periode bulan sebelumnya.</p></div>
      <span class="period-pill"><i class="fas fa-trophy"></i> <?= $periode_ranking ?></span>
    </div>
    <div class="row">
      <div class="col-xl-6">
        <div class="panel-card">
          <div class="panel-header"><h3 class="panel-title">Toko dengan penjualan tertinggi<span class="panel-subtitle">Top 5 berdasarkan jumlah artikel</span></h3><span class="panel-badge">Teratas</span></div>
          <div class="panel-body">
            <?php if (!empty($top_toko)) : ?><ol class="ranking-list">
              <?php foreach ($top_toko as $no => $dd) :
                $persen = ((int) $dd->total_bulan_lalu > 0) ? (((int) $dd->total_bulan_ini - (int) $dd->total_bulan_lalu) / (int) $dd->total_bulan_lalu) * 100 : 0; ?>
                <li class="ranking-item">
                  <span class="rank-number"><?= $no + 1 ?></span>
                  <div class="rank-info"><p class="rank-name" title="<?= html_escape($dd->nama_toko) ?>"><?= html_escape($dd->nama_toko) ?></p><span class="rank-meta"><i class="far fa-user mr-1"></i><?= html_escape($dd->spg) ?></span></div>
                  <div class="rank-value"><?= number_format((int) $dd->total_bulan_ini) ?> artikel<span class="rank-trend <?= $persen >= 0 ? 'text-success' : 'text-danger' ?>"><i class="fas fa-arrow-<?= $persen >= 0 ? 'up' : 'down' ?>"></i> <?= number_format(abs($persen), 1) ?>%</span></div>
                </li>
              <?php endforeach; ?>
            </ol><?php else : ?><div class="empty-state"><i class="fas fa-chart-bar"></i>Belum ada data penjualan toko.</div><?php endif; ?>
          </div>
        </div>
      </div>

      <div class="col-xl-6">
        <div class="panel-card">
          <div class="panel-header"><h3 class="panel-title">Artikel paling banyak terjual<span class="panel-subtitle">Top 5 berdasarkan kuantitas terjual</span></h3><span class="panel-badge">Terlaris</span></div>
          <div class="panel-body">
            <?php if (!empty($top_artikel)) : ?><ol class="ranking-list">
              <?php foreach ($top_artikel as $no => $dd) : ?><li class="ranking-item"><span class="rank-number"><?= $no + 1 ?></span><div class="rank-info"><p class="rank-name"><?= html_escape($dd->kode) ?></p><span class="rank-meta"><?= html_escape($dd->nama_produk) ?></span></div><span class="rank-value"><?= number_format((int) $dd->total) ?> artikel</span></li><?php endforeach; ?>
            </ol><?php else : ?><div class="empty-state"><i class="fas fa-box-open"></i>Belum ada data penjualan artikel.</div><?php endif; ?>
          </div>
        </div>
      </div>

      <div class="col-xl-6">
        <div class="panel-card">
          <div class="panel-header"><h3 class="panel-title">Toko dengan penjualan terendah<span class="panel-subtitle">5 toko yang memerlukan perhatian</span></h3><span class="panel-badge danger">Perhatian</span></div>
          <div class="panel-body">
            <?php if (!empty($low_toko)) : ?><ol class="ranking-list negative">
              <?php foreach ($low_toko as $no => $dd) : ?><li class="ranking-item"><span class="rank-number"><?= $no + 1 ?></span><div class="rank-info"><p class="rank-name"><?= html_escape($dd->nama_toko) ?></p><span class="rank-meta"><i class="far fa-user mr-1"></i><?= html_escape($dd->spg) ?></span></div><span class="rank-value"><?= number_format((int) $dd->total) ?> artikel</span></li><?php endforeach; ?>
            </ol><?php else : ?><div class="empty-state"><i class="fas fa-store-slash"></i>Belum ada data penjualan toko.</div><?php endif; ?>
          </div>
        </div>
      </div>

      <div class="col-xl-6">
        <div class="panel-card">
          <div class="panel-header"><h3 class="panel-title">Artikel dengan penjualan terendah<span class="panel-subtitle">5 artikel yang memerlukan perhatian</span></h3><span class="panel-badge danger">Perhatian</span></div>
          <div class="panel-body">
            <?php if (!empty($low_artikel)) : ?><ol class="ranking-list negative">
              <?php foreach ($low_artikel as $no => $dd) : ?><li class="ranking-item"><span class="rank-number"><?= $no + 1 ?></span><div class="rank-info"><p class="rank-name"><?= html_escape($dd->kode) ?></p><span class="rank-meta"><?= html_escape($dd->nama_produk) ?></span></div><span class="rank-value"><?= number_format((int) $dd->total) ?> artikel</span></li><?php endforeach; ?>
            </ol><?php else : ?><div class="empty-state"><i class="fas fa-box-open"></i>Belum ada data penjualan artikel.</div><?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="section-heading">
      <div><h2>Distribusi stok</h2><p>Pantau toko dengan stok terbesar dan distribusi berdasarkan supervisor.</p></div>
      <span class="period-pill"><i class="fas fa-boxes"></i> Posisi terkini</span>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="panel-card">
          <div class="panel-header"><h3 class="panel-title">Stok berdasarkan supervisor<span class="panel-subtitle">Kontribusi stok pada toko aktif</span></h3><span class="panel-badge">Distribusi</span></div>
          <div class="panel-body"><div class="row align-items-center">
            <div class="col-md-6 mb-3 mb-md-0"><div class="table-responsive"><table class="table stock-table" id="data-table">
              <thead><tr><th>Supervisor</th><th class="text-center">Toko</th><th class="text-right">Stok</th><th class="text-right">%</th></tr></thead>
              <tbody><tr><td colspan="4" class="text-center text-muted py-4"><i class="fas fa-circle-notch fa-spin mr-1"></i> Memuat data...</td></tr></tbody>
              <tfoot><tr><th>Total</th><th id="grand-total-toko" class="text-center">-</th><th id="grand-total-stok" class="text-right">-</th><th id="persen" class="text-right">-</th></tr></tfoot>
            </table></div></div>
            <div class="col-md-6"><div class="chart-wrap chart-small"><div class="chart-state" id="stok-chart-state"><i class="fas fa-circle-notch fa-spin mr-2"></i> Memuat grafik...</div><canvas id="grafikStokSPV"></canvas></div></div>
          </div></div>
          <div class="panel-footer-note"><i class="fas fa-info-circle mr-1"></i> Data berasal dari toko aktif yang sudah terhubung ke supervisor.</div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="panel-card">
          <div class="panel-header"><h3 class="panel-title">Toko dengan stok terbesar<span class="panel-subtitle">Top 5 posisi stok saat ini</span></h3></div>
          <div class="panel-body">
            <?php if (!empty($top_stok)) : ?><ol class="ranking-list">
              <?php foreach ($top_stok as $no => $dd) : ?><li class="ranking-item"><span class="rank-number"><?= $no + 1 ?></span><div class="rank-info"><p class="rank-name"><?= html_escape($dd->nama_toko) ?></p><span class="rank-meta"><?= html_escape($dd->spg) ?></span></div><span class="rank-value"><?= number_format((int) $dd->total) ?></span></li><?php endforeach; ?>
            </ol><?php else : ?><div class="empty-state"><i class="fas fa-warehouse"></i>Belum ada data stok toko.</div><?php endif; ?>
          </div>
          <div class="panel-footer-note">Diperbarui <?= date('d M Y, H:i') ?></div>
        </div>
      </div>
    </div>

    
  </div>
</section>

<script src="<?= base_url('assets/plugins/chart.js/Chart.min.js') ?>"></script>
<script>
  $(function() {
    var formatter = new Intl.NumberFormat('id-ID');
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'].slice(0, new Date().getMonth() + 1);

    $.ajax({ url: '<?= base_url('adm/Dashboard/transaksi') ?>', dataType: 'json' }).done(function(data) {
      $('#transaksi-chart-state').remove();
      new Chart($('#grafikTransaksi').get(0).getContext('2d'), {
        type: 'bar',
        data: { labels: months, datasets: [
          { label: 'Penjualan', data: data.jual || [], backgroundColor: '#2563eb' },
          { label: 'Pengiriman', data: data.kirim || [], backgroundColor: '#38bdf8' },
          { label: 'Retur', data: data.retur || [], backgroundColor: '#f87171' }
        ] },
        options: {
          responsive: true, maintainAspectRatio: false,
          legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, fontColor: '#64748b' } },
          tooltips: { mode: 'index', intersect: false, callbacks: { label: function(item, chart) { return ' ' + chart.datasets[item.datasetIndex].label + ': ' + formatter.format(item.yLabel) + ' artikel'; } } },
          scales: { xAxes: [{ gridLines: { display: false }, ticks: { fontColor: '#718096' }, barPercentage: .72, categoryPercentage: .68 }], yAxes: [{ gridLines: { color: '#edf1f7', drawBorder: false }, ticks: { beginAtZero: true, precision: 0, fontColor: '#718096', callback: function(value) { return formatter.format(value); } } }] }
        }
      });
    }).fail(function() { $('#transaksi-chart-state').html('<span class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i> Grafik gagal dimuat.</span>'); });

    $.ajax({ url: '<?= base_url('adm/Dashboard/stok_spv') ?>', dataType: 'json' }).done(function(data) {
      var labels = [], values = [], totalToko = 0, totalStok = 0, rows = '';
      $.each(data, function(_, item) {
        labels.push(item.nama); values.push(parseInt(item.total_stok, 10) || 0);
        totalToko += parseInt(item.total_toko, 10) || 0; totalStok += parseInt(item.total_stok, 10) || 0;
      });
      $.each(data, function(_, item) {
        var stok = parseInt(item.total_stok, 10) || 0;
        var pct = totalStok > 0 ? (stok / totalStok * 100).toFixed(1) : '0.0';
        rows += '<tr><td>' + $('<div>').text(item.nama || '-').html() + '</td><td class="text-center">' + formatter.format(parseInt(item.total_toko, 10) || 0) + '</td><td class="text-right">' + formatter.format(stok) + '</td><td class="text-right">' + pct + '%</td></tr>';
      });
      $('#data-table tbody').html(rows || '<tr><td colspan="4" class="text-center text-muted py-4">Belum ada data stok.</td></tr>');
      $('#grand-total-toko').text(formatter.format(totalToko)); $('#grand-total-stok').text(formatter.format(totalStok)); $('#persen').text(totalStok > 0 ? '100%' : '0%');
      if (!data.length) { $('#stok-chart-state').html('<span>Belum ada data untuk ditampilkan.</span>'); return; }
      $('#stok-chart-state').remove();
      new Chart($('#grafikStokSPV').get(0).getContext('2d'), {
        type: 'doughnut',
        data: { labels: labels, datasets: [{ data: values, backgroundColor: ['#2563eb', '#38bdf8', '#14b8a6', '#f59e0b', '#8b5cf6', '#f87171', '#64748b'], borderColor: '#fff', borderWidth: 3 }] },
        options: { maintainAspectRatio: false, responsive: true, cutoutPercentage: 68, legend: { position: 'bottom', labels: { usePointStyle: true, padding: 14, fontColor: '#64748b', boxWidth: 8 } }, tooltips: { callbacks: { label: function(item, chart) { return ' ' + chart.labels[item.index] + ': ' + formatter.format(chart.datasets[0].data[item.index]) + ' artikel'; } } } }
      });
    }).fail(function() {
      $('#data-table tbody').html('<tr><td colspan="4" class="text-center text-danger py-4">Data gagal dimuat.</td></tr>');
      $('#stok-chart-state').html('<span class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i> Grafik gagal dimuat.</span>');
    });
  });
</script>

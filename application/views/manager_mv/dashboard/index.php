<!-- Small boxes (Stat box) -->
<?php
$nama_user = html_escape((string) $this->session->userdata('nama_user'));
$total_stok = isset($t_stok->total) ? (int) $t_stok->total : 0;
$total_toko = isset($t_toko->total) ? (int) $t_toko->total : 0;
$total_permintaan = isset($t_minta->total) ? (int) $t_minta->total : 0;
$total_pengiriman = isset($t_kirim->total) ? (int) $t_kirim->total : 0;
$total_retur = isset($t_retur->total) ? (int) $t_retur->total : 0;
$total_selisih = isset($t_selisih->total) ? (int) $t_selisih->total : 0;
$total_transaksi = $total_permintaan + $total_pengiriman + $total_retur;
?>

<style>
  .manager-dashboard {
    --manager-ink: #172033;
    --manager-muted: #64748b;
    --manager-line: #e7edf4;
    padding: 18px 8px 30px;
    color: var(--manager-ink);
  }

  .manager-dashboard a:hover { text-decoration: none; }

  .manager-hero {
    position: relative;
    min-height: 218px;
    overflow: hidden;
    color: #fff;
    background: radial-gradient(circle at 82% 14%, rgba(196, 181, 253, .3), transparent 28%), linear-gradient(125deg, #0f172a 0%, #4338ca 58%, #6366f1 100%);
    border: 0;
    border-radius: 24px;
    box-shadow: 0 18px 38px rgba(79, 70, 229, .2);
  }

  .manager-hero::after {
    position: absolute;
    right: -70px;
    bottom: -145px;
    width: 250px;
    height: 250px;
    content: '';
    border: 1px solid rgba(255, 255, 255, .14);
    border-radius: 50%;
  }

  .manager-hero .card-body { position: relative; z-index: 1; padding: 32px 38px; }
  .manager-hero .row { min-height: 150px; align-items: center; }
  .manager-hero-copy { margin: 0; }
  .manager-eyebrow { display: inline-flex; align-items: center; gap: 7px; margin-bottom: 12px; padding: 6px 10px; color: #e0e7ff; background: rgba(255, 255, 255, .11); border: 1px solid rgba(255, 255, 255, .13); border-radius: 999px; font-size: 10px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; }
  .manager-hero h1 { margin: 0 0 10px; font-size: clamp(27px, 4vw, 38px); font-weight: 800; }
  .manager-hero p { max-width: 590px; margin: 0; color: rgba(255, 255, 255, .76); font-size: 14px; line-height: 1.65; }
  .manager-hero .img-dashboard { position: relative; top: auto; left: auto; display: block; width: 100%; max-width: 215px; max-height: 170px; margin: auto; object-fit: contain; filter: drop-shadow(0 13px 18px rgba(15, 23, 42, .22)); }

  .manager-section-heading { display: flex; align-items: flex-end; justify-content: space-between; gap: 12px; margin: 24px 2px 13px; }
  .manager-section-heading h2 { margin: 0 0 3px; font-size: 19px; font-weight: 800; }
  .manager-section-heading p { margin: 0; color: var(--manager-muted); font-size: 11px; }
  .manager-period { padding: 6px 10px; color: #4338ca; background: #eef2ff; border-radius: 999px; font-size: 10px; font-weight: 700; white-space: nowrap; }

  .manager-kpi-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 13px; }
  .manager-kpi-card { display: block; min-width: 0; padding: 17px; color: var(--manager-ink); background: #fff; border: 1px solid var(--manager-line); border-radius: 17px; box-shadow: 0 8px 24px rgba(15, 23, 42, .05); transition: transform .2s ease, box-shadow .2s ease; }
  .manager-kpi-card:hover,
  .manager-kpi-card:focus { color: var(--manager-ink); outline: none; transform: translateY(-3px); box-shadow: 0 14px 28px rgba(15, 23, 42, .09); }
  .manager-kpi-top { display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 12px; color: var(--manager-muted); font-size: 11px; font-weight: 700; }
  .manager-kpi-icon { display: inline-flex; width: 40px; height: 40px; flex: 0 0 40px; align-items: center; justify-content: center; color: var(--kpi-color); background: var(--kpi-bg); border-radius: 12px; font-size: 16px; }
  .manager-kpi-value { display: block; margin-bottom: 4px; overflow: hidden; font-size: 25px; font-weight: 800; line-height: 1.1; text-overflow: ellipsis; white-space: nowrap; }
  .manager-kpi-hint { color: #94a3b8; font-size: 10px; }
  .manager-kpi-card.stock { --kpi-color: #7c3aed; --kpi-bg: #ede9fe; }
  .manager-kpi-card.store { --kpi-color: #0369a1; --kpi-bg: #e0f2fe; }
  .manager-kpi-card.request { --kpi-color: #15803d; --kpi-bg: #dcfce7; }
  .manager-kpi-card.delivery { --kpi-color: #2563eb; --kpi-bg: #dbeafe; }
  .manager-kpi-card.return { --kpi-color: #dc2626; --kpi-bg: #fee2e2; }
  .manager-kpi-card.issue { --kpi-color: #d97706; --kpi-bg: #fef3c7; }

  .manager-insight {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    margin-top: 14px;
    padding: 15px 17px;
    color: #334155;
    background: #f8fafc;
    border: 1px solid var(--manager-line);
    border-radius: 15px;
  }

  .manager-insight-copy { display: flex; min-width: 0; align-items: center; gap: 11px; }
  .manager-insight-icon { display: inline-flex; width: 38px; height: 38px; flex: 0 0 38px; align-items: center; justify-content: center; color: #4338ca; background: #e0e7ff; border-radius: 11px; }
  .manager-insight strong { display: block; margin-bottom: 2px; font-size: 12px; }
  .manager-insight span { color: var(--manager-muted); font-size: 10px; }
  .manager-insight-total { color: #4338ca !important; font-size: 20px !important; font-weight: 800; white-space: nowrap; }

  .manager-chart-card { overflow: hidden; border: 1px solid var(--manager-line); border-radius: 20px; box-shadow: 0 8px 26px rgba(15, 23, 42, .05); }
  .manager-chart-card .card-header { padding: 20px 22px 14px; color: var(--manager-ink); background: #fff; border: 0; }
  .manager-chart-title { display: block; margin-bottom: 3px; font-size: 17px; font-weight: 800; }
  .manager-chart-subtitle { color: var(--manager-muted); font-size: 11px; }
  .manager-chart-card .card-body { padding: 8px 22px 20px; }
  .manager-chart { position: relative; height: 325px; }
  .manager-chart-state { position: absolute; z-index: 2; inset: 0; display: flex; align-items: center; justify-content: center; gap: 8px; color: var(--manager-muted); background: rgba(255, 255, 255, .92); font-size: 11px; }
  .manager-chart-card .card-footer { padding: 11px 22px; color: var(--manager-muted); background: #f8fafc; border-top: 1px solid var(--manager-line); font-size: 10px; }

  @media (max-width: 991.98px) {
    .manager-kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  }

  @media (max-width: 767.98px) {
    .manager-dashboard { padding: 10px 0 22px; }
    .manager-hero { min-height: auto; border-radius: 20px; }
    .manager-hero .card-body { padding: 25px 22px; }
    .manager-hero .row { min-height: 0; }
    .manager-hero .img-dashboard { max-width: 145px; margin-bottom: 18px; }
    .manager-chart-card .card-body { padding-right: 14px; padding-left: 14px; }
    .manager-chart { height: 285px; }
  }

  @media (max-width: 479.98px) {
    .manager-kpi-grid { gap: 9px; }
    .manager-kpi-card { padding: 14px; }
    .manager-kpi-value { font-size: 21px; }
    .manager-insight { align-items: flex-start; }
  }
</style>

<section class="content manager-dashboard">
  <div class="card manager-hero">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-4 order-lg-2">
          <img src="<?= base_url('assets/img/saran.svg') ?>" alt="Ilustrasi dashboard Manager MV" class="img-dashboard">
        </div>
        <div class="col-lg-8 order-lg-1">
          <div class="manager-hero-copy">
            <span class="manager-eyebrow"><i class="fas fa-chart-line"></i> Manager MV</span>
            <h1>Halo, <?= $nama_user ?>!</h1>
            <p>Pantau stok seluruh toko, aktivitas transaksi bulanan, dan tren operasional untuk mendukung keputusan yang lebih cepat.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="manager-section-heading">
    <div>
      <h2>Ringkasan operasional</h2>
      <p>Stok aktif dan aktivitas transaksi pada periode berjalan.</p>
    </div>
    <span class="manager-period"><i class="far fa-calendar-alt mr-1"></i><?= date('M Y') ?></span>
  </div>

  <div class="manager-kpi-grid">
    <div class="manager-kpi-card stock">
      <div class="manager-kpi-top"><span>Stok seluruh toko</span><span class="manager-kpi-icon"><i class="fas fa-boxes"></i></span></div>
      <strong class="manager-kpi-value"><?= number_format($total_stok, 0, ',', '.') ?></strong>
      <span class="manager-kpi-hint">Total unit artikel aktif</span>
    </div>
    <div class="manager-kpi-card store">
      <div class="manager-kpi-top"><span>Toko aktif</span><span class="manager-kpi-icon"><i class="fas fa-store"></i></span></div>
      <strong class="manager-kpi-value"><?= number_format($total_toko, 0, ',', '.') ?></strong>
      <span class="manager-kpi-hint">Toko yang sedang beroperasi</span>
    </div>
    <a href="<?= base_url('sup/Permintaan') ?>" class="manager-kpi-card request">
      <div class="manager-kpi-top"><span>Permintaan PO</span><span class="manager-kpi-icon"><i class="fas fa-file-alt"></i></span></div>
      <strong class="manager-kpi-value"><?= number_format($total_permintaan, 0, ',', '.') ?></strong>
      <span class="manager-kpi-hint">Transaksi bulan ini</span>
    </a>
    <a href="<?= base_url('sup/Pengiriman') ?>" class="manager-kpi-card delivery">
      <div class="manager-kpi-top"><span>Pengiriman DO</span><span class="manager-kpi-icon"><i class="fas fa-truck"></i></span></div>
      <strong class="manager-kpi-value"><?= number_format($total_pengiriman, 0, ',', '.') ?></strong>
      <span class="manager-kpi-hint">Pengiriman bulan ini</span>
    </a>
    <a href="<?= base_url('sup/Retur') ?>" class="manager-kpi-card return">
      <div class="manager-kpi-top"><span>Retur</span><span class="manager-kpi-icon"><i class="fas fa-exchange-alt"></i></span></div>
      <strong class="manager-kpi-value"><?= number_format($total_retur, 0, ',', '.') ?></strong>
      <span class="manager-kpi-hint">Retur aktif bulan ini</span>
    </a>
    <a href="<?= base_url('sup/Selisih') ?>" class="manager-kpi-card issue">
      <div class="manager-kpi-top"><span>Selisih pengiriman</span><span class="manager-kpi-icon"><i class="fas fa-exclamation-triangle"></i></span></div>
      <strong class="manager-kpi-value"><?= number_format($total_selisih, 0, ',', '.') ?></strong>
      <span class="manager-kpi-hint">Data yang perlu diperiksa</span>
    </a>
  </div>

  <div class="manager-insight">
    <div class="manager-insight-copy">
      <span class="manager-insight-icon"><i class="fas fa-chart-bar"></i></span>
      <div><strong>Aktivitas transaksi bulan ini</strong><span>Akumulasi permintaan, pengiriman, dan retur yang tercatat.</span></div>
    </div>
    <span class="manager-insight-total"><?= number_format($total_transaksi, 0, ',', '.') ?></span>
  </div>
  <div class="manager-section-heading">
    <div>
      <h2>Analitik transaksi</h2>
      <p>Perbandingan volume unit permintaan, pengiriman, dan retur per bulan.</p>
    </div>
    <span class="manager-period">Tahun <?= date('Y') ?></span>
  </div>

  <div class="card manager-chart-card">
    <div class="card-header">
      <span class="manager-chart-title">Tren transaksi seluruh toko</span>
      <span class="manager-chart-subtitle">Data ditampilkan hingga bulan berjalan.</span>
    </div>
    <div class="card-body">
      <div class="manager-chart">
        <div class="manager-chart-state" id="chartState"><i class="fas fa-circle-notch fa-spin"></i> Memuat data transaksi...</div>
        <canvas id="grafikTransaksi" aria-label="Grafik transaksi seluruh toko" role="img"></canvas>
      </div>
    </div>
    <div class="card-footer"><i class="far fa-clock mr-1"></i>Terakhir dimuat <?= date('d M Y, H:i') ?></div>
  </div>
</section>
<script src="<?php echo base_url() ?>/assets/plugins/chart.js/Chart.min.js"></script>
<script>
  $(document).ready(function() {
    $.ajax({
      url: '<?= base_url('sup/Dashboard/transaksi') ?>',
      method: 'GET',
      dataType: 'json',
      success: function(data) {
        $('#chartState').fadeOut(180);
        // Get the current month to limit the months displayed
        var currentMonth = new Date().getMonth() + 1; // getMonth() returns 0-11
        var bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'].slice(0, currentMonth);

        var transaksi = {
          labels: bulan,
          datasets: [{
              label: 'Permintaan',
              backgroundColor: '#22c55e',
              borderColor: '#16a34a',
              pointRadius: false,
              pointColor: 'rgba(210, 214, 222, 1)',
              pointStrokeColor: '#c1c7d1',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(220,220,220,1)',
              data: data.Permintaan
            },
            {
              label: 'Retur',
              backgroundColor: '#f97316',
              borderColor: '#ea580c',
              pointRadius: false,
              pointColor: 'rgba(210, 214, 222, 1)',
              pointStrokeColor: '#c1c7d1',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(220,220,220,1)',
              data: data.Retur
            },
            {
              label: 'Pengiriman',
              backgroundColor: '#3b82f6',
              borderColor: '#2563eb',
              pointRadius: false,
              pointColor: '#3b8bba',
              pointStrokeColor: 'rgba(60,141,188,1)',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data: data.Pengiriman
            }
          ]
        }
        var barChartCanvas = $('#grafikTransaksi').get(0).getContext('2d')

        var barChartOptions = {
          responsive: true,
          maintainAspectRatio: false,
          datasetFill: false,
          legend: {
            position: 'bottom',
            labels: { usePointStyle: true, boxWidth: 8, fontColor: '#64748b', padding: 18 }
          },
          tooltips: {
            mode: 'index',
            intersect: false,
            backgroundColor: '#0f172a',
            cornerRadius: 8
          },
          scales: {
            xAxes: [{
              gridLines: { display: false },
              ticks: { fontColor: '#64748b' },
              barPercentage: .72,
              categoryPercentage: .72
            }],
            yAxes: [{
              gridLines: { color: '#edf2f7', drawBorder: false },
              ticks: { beginAtZero: true, precision: 0, fontColor: '#64748b' }
            }]
          }
        }

        new Chart(barChartCanvas, {
          type: 'bar',
          data: transaksi,
          options: barChartOptions
        })
      },
      error: function() {
        $('#chartState').html('<i class="fas fa-exclamation-circle text-warning"></i> Data grafik belum dapat dimuat. Silakan muat ulang halaman.');
      }
    });
  });
</script>

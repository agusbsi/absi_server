<style>
  .spv-dashboard { --blue:#2563eb; --navy:#172554; --muted:#64748b; --line:#e2e8f0; color:#0f172a; }
  .spv-dashboard > .card:first-child { overflow:hidden; border:0; border-radius:20px; color:#fff; background:linear-gradient(125deg,#172554 0%,#1d4ed8 70%,#38bdf8 140%); box-shadow:0 14px 35px rgba(30,64,175,.18); }
  .spv-dashboard > .card:first-child .card-body { padding:30px 34px; }
  .spv-dashboard > .card:first-child .row { align-items:center; }
  .spv-dashboard .img-dashboard { display:block; max-width:100%; max-height:155px; margin:auto; filter:drop-shadow(0 12px 18px rgba(15,23,42,.25)); }
  .spv-dashboard .konten h2 { margin:0 0 10px; font-size:29px; font-weight:700; letter-spacing:-.03em; }
  .spv-dashboard .konten p { max-width:620px; margin:0; color:rgba(255,255,255,.82); line-height:1.65; }
  .spv-dashboard .konten a { color:#fff; font-weight:700; }
  .spv-dashboard > .row:first-of-type { margin-top:22px; }
  .spv-dashboard .info-box { min-height:132px; overflow:hidden; border:1px solid var(--line); border-radius:16px; background:#fff; box-shadow:0 5px 18px rgba(15,23,42,.05); transition:transform .2s ease,box-shadow .2s ease; }
  .spv-dashboard .info-box:hover { transform:translateY(-3px); box-shadow:0 12px 28px rgba(15,23,42,.09); }
  .spv-dashboard .info-box-icon { width:64px; margin:15px 0 15px 15px; border-radius:14px; box-shadow:none!important; font-size:21px; }
  .spv-dashboard .info-box-icon.bg-danger { color:#2563eb!important; background:#eff6ff!important; }
  .spv-dashboard .info-box-icon.bg-info { color:#0891b2!important; background:#ecfeff!important; }
  .spv-dashboard .info-box-icon.bg-success { color:#059669!important; background:#ecfdf5!important; }
  .spv-dashboard .info-box-icon.bg-warning { color:#d97706!important; background:#fffbeb!important; }
  .spv-dashboard .info-box-content { padding:18px 15px; }
  .spv-dashboard .info-box-text { color:var(--muted); font-size:12px; font-weight:600; }
  .spv-dashboard .info-box-number { margin:3px 0 8px; font-size:24px; line-height:1.15; }
  .spv-dashboard .info-box-content > a { margin-top:auto; color:var(--blue); font-size:12px; font-weight:700; }
  .spv-dashboard .callout { margin:12px 0 14px; padding:11px 16px; border:0; border-radius:12px; color:#475569; background:#eff6ff; }
  .spv-dashboard .callout p { margin:0; font-size:13px; }
  .spv-dashboard .card-success,.spv-dashboard .card-danger { border:1px solid var(--line); border-radius:16px; box-shadow:0 5px 18px rgba(15,23,42,.05); }
  .spv-dashboard .card-success > .card-header,.spv-dashboard .card-danger > .card-header { padding:18px 20px; border:0; border-radius:16px 16px 0 0; color:#0f172a; background:#fff; font-size:15px; font-weight:700; }
  .spv-dashboard .card-title { font-size:16px; font-weight:700; }
  .spv-dashboard .card-success .card-body,.spv-dashboard .card-danger .card-body { padding:20px; }
  .spv-dashboard .card-footer { padding:10px 20px; border-color:#f1f5f9; border-radius:0 0 16px 16px; color:var(--muted); background:#fff; }
  .spv-dashboard .products-list .item { padding:14px 0; border-color:#f1f5f9; }
  .spv-dashboard .product-img { display:flex; width:38px; height:38px; align-items:center; justify-content:center; border-radius:11px; color:#2563eb; background:#eff6ff; }
  .spv-dashboard .product-info { margin-left:50px; }
  .spv-dashboard .product-title { color:#0f172a; }
  .spv-dashboard .product-description { color:var(--muted); }
  .spv-dashboard .badge-warning { padding:6px 9px; border-radius:20px; color:#047857; background:#ecfdf5; }
  .spv-dashboard .col-md-6 .info-box[class*="bg-gradient"] { min-height:76px; color:#0f172a!important; background:#fff!important; }
  .spv-dashboard .col-md-6 .info-box[class*="bg-gradient"] .info-box-icon { width:48px; height:48px; margin:13px 0 13px 14px; color:#2563eb; background:#eff6ff; }
  .spv-dashboard .col-md-6 .info-box[class*="bg-gradient"] .info-box-content { padding:14px; }
  .spv-dashboard .progress { display:none; }
  @media(max-width:767.98px){.spv-dashboard > .card:first-child .card-body{padding:24px}.spv-dashboard .img-dashboard{display:none}.spv-dashboard .konten h2{font-size:24px}.spv-dashboard .info-box{min-height:108px}.spv-dashboard .info-box-icon{width:54px}}
</style>
<section class="content spv-dashboard">
  <div class="card card-primary card-outline">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-4">
          <img src="<?= base_url('assets/img/saran.svg') ?>" alt="dashboard" class="img-dashboard">
        </div>
        <div class="col-lg-8">
          <div class="konten text-left">
            <h2>Selamat datang, <?= html_escape($this->session->userdata('nama_user')) ?>!</h2>
            <p>Dashboard <a href="#">Supervisor</a> membantu Anda memantau toko, stok, tim, dan transaksi dalam satu tampilan ringkas.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-hospital"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Customer</span>
          <span class="info-box-number">
            <?php if ($t_cust->total == 0) {
              echo "0";
            } else {
              echo $t_cust->total;
            } ?></span>
          <a href="<?= base_url('spv/Customer') ?>" class=" text-right"> Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-store"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Toko</span>
          <span class="info-box-number">
            <?php if ($t_toko->total == 0) {
              echo "0";
            } else {
              echo $t_toko->total;
            } ?>
          </span>
          <a href="<?= base_url('spv/Toko') ?>" class=" text-right">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>

    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cube"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Stok</span>
          <span class="info-box-number">
            <?php if ($t_stok->total == 0) {
              echo "0";
            } else {
              echo number_format($t_stok->total, 0, ',', '.');
            } ?>
          </span>
          <a href="<?= base_url('spv/Toko'); ?>" class="text-right">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>

        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Leader</span>
          <span class="info-box-number">
            <?php if ($t_leader->total == 0) {
              echo "0";
            } else {
              echo $t_leader->total;
            } ?>
          </span>
          <a href="<?= base_url('spv/User') ?>" class=" text-right">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
  <div class="callout callout-danger">
    <p> Data Transaksi Tahun : <b><?= date('Y') ?></b> </p>
  </div>
  <div class="card card-success">
    <div class="card-header">
      <h3 class="card-title">Tren Transaksi Semua Toko</h3>
    </div>
    <div class="card-body">
      <div class="chart">
        <canvas id="grafikTransaksi" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
      </div>
    </div>
    <div class="card-footer">
      <small>* Data update : <?= date('d-M-Y H:i:s') ?> </small>
    </div>
    <!-- /.card-body -->
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="card card-danger">
        <div class="card-header">
          Top 5 Toko dengan Stok Terbanyak
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <ul class="products-list product-list-in-card">
            <?php if (is_array($top_stok)) { ?>
              <?php
              foreach ($top_stok as $dd) :
              ?>
                <li class="item">
                  <div class="product-img">
                    <i class="fas fa-store"></i>
                  </div>
                  <div class="product-info">
                    <span class="product-title"><?= html_escape($dd->nama_toko) ?>
                      <span class="badge badge-warning float-right"><?= number_format($dd->total, 0, ',', '.') ?> Artikel</span></span>
                    <span class="product-description">
                      <small><?= html_escape($dd->spg) ?></small>
                    </span>
                  </div>
                </li>
                <!-- /.item -->
              <?php endforeach; ?>
            <?php  } else { ?>
              <span> Data Kosong</span>
            <?php } ?>
          </ul>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <small> * Data update : <?= date('d-M-Y H:i:s') ?></small>
        </div>
        <!-- /.card-footer -->
      </div>
    </div>
    <div class="col-md-6">
      <div class="callout callout-danger">
        <p> Data Transaksi Bulan : <b><?= date('M-Y') ?></b> </p>
      </div>
      <div class="info-box bg-gradient-warning">
        <span class="info-box-icon"><i class="fas fa-list-alt"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Data Permintaan</span>
          <strong><?= number_format($t_minta->total, 0, ',', '.') ?> Artikel</strong>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
        </div>
        <!-- /.info-box-content -->
      </div>
      <div class="info-box bg-gradient-info">
        <span class="info-box-icon"><i class="fas fa-truck"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Data Pengiriman</span>
          <strong><?= number_format($t_kirim->total, 0, ',', '.') ?> Artikel</strong>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
        </div>
        <!-- /.info-box-content -->
      </div>
      <div class="info-box bg-gradient-success">
        <span class="info-box-icon"><i class="fas fa-cart-plus"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Data Penjualan</span>
          <strong><?= number_format($t_jual->total, 0, ',', '.') ?> Artikel</strong>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
        </div>
        <!-- /.info-box-content -->
      </div>
      <div class="info-box bg-gradient-danger">
        <span class="info-box-icon"><i class="fas fa-exchange-alt"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Data Retur</span>
          <strong><?= number_format($t_retur->total, 0, ',', '.') ?> Artikel</strong>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
        </div>
        <!-- /.info-box-content -->
      </div>

    </div>
  </div>

</section>
<script src="<?php echo base_url() ?>/assets/plugins/chart.js/Chart.min.js"></script>
<script>
  $(document).ready(function() {
    $.ajax({
      url: '<?= base_url('spv/Dashboard/transaksi') ?>',
      method: 'GET',
      dataType: 'json',
      success: function(data) {
        // Get the current month to limit the months displayed
        var currentMonth = new Date().getMonth() + 1; // getMonth() returns 0-11
        var bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'].slice(0, currentMonth);

        var transaksi = {
          labels: bulan,
          datasets: [{
              label: 'Penjualan',
              backgroundColor: '#22c55e',
              borderColor: 'rgba(210, 214, 222, 1)',
              pointRadius: false,
              pointColor: 'rgba(210, 214, 222, 1)',
              pointStrokeColor: '#c1c7d1',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(220,220,220,1)',
              data: data.jual
            },
            {
              label: 'Retur',
              backgroundColor: '#f97316',
              borderColor: 'rgba(210, 214, 222, 1)',
              pointRadius: false,
              pointColor: 'rgba(210, 214, 222, 1)',
              pointStrokeColor: '#c1c7d1',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(220,220,220,1)',
              data: data.retur
            },
            {
              label: 'Pengiriman',
              backgroundColor: '#3b82f6',
              borderColor: 'rgba(60,141,188,0.8)',
              pointRadius: false,
              pointColor: '#3b8bba',
              pointStrokeColor: 'rgba(60,141,188,1)',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data: data.kirim
            }
          ]
        }
        var barChartCanvas = $('#grafikTransaksi').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, transaksi)
        var temp0 = transaksi.datasets[0]
        var temp1 = transaksi.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
          responsive: true,
          maintainAspectRatio: false,
          datasetFill: false,
          legend: {
            position: 'bottom',
            labels: { boxWidth: 10, padding: 20, fontColor: '#64748b' }
          },
          tooltips: { mode: 'index', intersect: false },
          scales: {
            xAxes: [{ gridLines: { display: false }, ticks: { fontColor: '#64748b' } }],
            yAxes: [{ ticks: { beginAtZero: true, precision: 0, fontColor: '#64748b' }, gridLines: { color: 'rgba(148,163,184,.18)' } }]
          }
        }

        new Chart(barChartCanvas, {
          type: 'bar',
          data: barChartData,
          options: barChartOptions
        })
      }
    });
  });
</script>

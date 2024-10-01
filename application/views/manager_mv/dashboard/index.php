<!-- Small boxes (Stat box) -->
<section class="content">
  <div class="card card-primary card-outline">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-4">
          <img src="<?= base_url('assets/img/saran.svg') ?>" alt="dashboard" class="img-dashboard">
        </div>
        <div class="col-lg-8">
          <div class="konten text-left">
            <h2>Hallo.. <?= $this->session->userdata('nama_user') ?>,</h2>
            <p>Selamat datang di Dahboard <a href="#">Manager MV</a> <br>
              anda bisa menggunakan aplikasi ABSI ini untuk mempermudah pekerjaan anda.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="callout callout-danger">
    <p> Data Transaksi Bulan : <b><?= date('M-Y') ?></b> </p>
  </div>
  <div class="row">
    <div class="col-md-5">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3 style="font-size:70px;">
            <?= ($t_stok->total == 0) ? "Kosong" : number_format($t_stok->total) ?>
          </h3>
          <p>Stok Artikel</p>
        </div>
        <div class="icon">
          <i class="fa fa-chart-pie"></i>
        </div>
        <a href="#" class="small-box-footer">
          semua toko
        </a>
      </div>
    </div>
    <div class="col-md-7">
      <div class="row">
        <div class="col-md-6">
          <a href="<?= base_url('sup/Permintaan') ?>">
            <div class="info-box bg-gradient-success">
              <span class="info-box-icon"><i class="fas fa-list-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Data Permintaan</span>
                <strong><?= ($t_minta->total == 0) ? "Kosong" : number_format($t_minta->total) ?></strong>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-6">
          <a href="<?= base_url('sup/Pengiriman') ?>">
            <div class="info-box bg-gradient-info">
              <span class="info-box-icon"><i class="fas fa-truck"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Data Pengiriman</span>
                <strong><?= ($t_kirim->total == 0) ? "Kosong" : number_format($t_kirim->total)  ?></strong>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-6">
          <a href="<?= base_url('sup/Retur') ?>">
            <div class="info-box bg-gradient-danger">
              <span class="info-box-icon"><i class="fas fa-exchange-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Data Retur</span>
                <strong><?= ($t_retur->total == 0) ? "Kosong" : number_format($t_retur->total) ?></strong>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-6">
          <a href="<?= base_url('sup/Selisih') ?>">
            <div class="info-box bg-gradient-warning">
              <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Data Selisih</span>
                <strong><?= ($t_selisih->total == 0) ? "Kosong" : number_format($t_selisih->total)  ?></strong>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="callout callout-danger">
    <p> Data Transaksi Tahun : <b><?= date('Y') ?></b> </p>
  </div>
  <div class="card card-success">
    <div class="card-header">
      <h3 class="card-title">Transaksi Semua Toko</h3>
    </div>
    <div class="card-body">
      <div class="chart">
        <canvas id="grafikTransaksi" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
      </div>
    </div>
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
        // Get the current month to limit the months displayed
        var currentMonth = new Date().getMonth() + 1; // getMonth() returns 0-11
        var bulan = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'].slice(0, currentMonth);

        var transaksi = {
          labels: bulan,
          datasets: [{
              label: 'Permintaan',
              backgroundColor: '#28a745',
              borderColor: 'rgba(210, 214, 222, 1)',
              pointRadius: false,
              pointColor: 'rgba(210, 214, 222, 1)',
              pointStrokeColor: '#c1c7d1',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(220,220,220,1)',
              data: data.Permintaan
            },
            {
              label: 'Retur',
              backgroundColor: '#df4957',
              borderColor: 'rgba(210, 214, 222, 1)',
              pointRadius: false,
              pointColor: 'rgba(210, 214, 222, 1)',
              pointStrokeColor: '#c1c7d1',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(220,220,220,1)',
              data: data.Retur
            },
            {
              label: 'Pengiriman',
              backgroundColor: 'rgba(60,141,188,0.9)',
              borderColor: 'rgba(60,141,188,0.8)',
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
        var barChartData = $.extend(true, {}, transaksi)
        var temp0 = transaksi.datasets[0]
        var temp1 = transaksi.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
          responsive: true,
          maintainAspectRatio: false,
          datasetFill: false
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
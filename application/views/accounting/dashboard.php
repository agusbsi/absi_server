<!-- Small boxes (Stat box) -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-4">
            <img src="<?= base_url('assets/img/saran.svg') ?>" alt="dashboard" class="img-dashboard">
          </div>
          <div class="col-lg-8">
            <div class="konten text-left">
              <h2>Hallo.. <?= $this->session->userdata('nama_user') ?>,</h2>
              <p>Selamat datang di Dahboard <a href="#">Accounting.</a> <br>
                anda bisa menggunakan aplikasi ABSI ini untuk mempermudah pekerjaan anda.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- box master -->
    <div class="row">
      <?php foreach ($box as $info_box) : ?>
        <div class="col-lg-3 col-6">
          <div class="small-box <?= $info_box->box ?>">
            <div class="inner">

              <h3 class="count">
                <?php if (($info_box->total) == 0) {
                  echo "kosong";
                } else {
                  echo number_format($info_box->total);
                }
                ?>
              </h3>
              <p><?= $info_box->title; ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-<?= $info_box->icon ?>"></i>
            </div>
            <a href="<?= base_url() . strtolower($info_box->link); ?>" class="small-box-footer">
              Lihat Data
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="row">
      <div class="col-md-5">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3 style="font-size:70px;">
              <?= ($t_stok->total == 0) ? "Kosong" : number_format($t_stok->total) ?>
            </h3>
            <p>Stok</p>
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
            <div class="info-box bg-gradient-warning">
              <span class="info-box-icon"><i class="fas fa-list-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Data Permintaan</span>
                <strong><?= ($t_minta->total == 0) ? "Kosong" : number_format($t_minta->total) . " Artikel" ?></strong>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="info-box bg-gradient-info">
              <span class="info-box-icon"><i class="fas fa-truck"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Data Pengiriman</span>
                <strong><?= ($t_kirim->total == 0) ? "Kosong" : number_format($t_kirim->total) . " Artikel" ?></strong>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="info-box bg-gradient-success">
              <span class="info-box-icon"><i class="fas fa-cart-plus"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Data Penjualan</span>
                <strong><?= ($t_jual->total == 0) ? "Kosong" : number_format($t_jual->total) . " Artikel" ?></strong>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="info-box bg-gradient-danger">
              <span class="info-box-icon"><i class="fas fa-exchange-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Data Retur</span>
                <strong><?= ($t_retur->total == 0) ? "Kosong" : number_format($t_retur->total) . " Artikel" ?></strong>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
      </div>
      <!-- /.col -->
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
      <!-- /.card-body -->
    </div>
  </div>
</section>
<!-- jQuery -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/chart.js/Chart.min.js"></script>
<script>
  $(document).ready(function() {
    $.ajax({
      url: '<?= base_url('accounting/Dashboard/transaksi') ?>',
      method: 'GET',
      dataType: 'json',
      success: function(data) {
        // Get the current month to limit the months displayed
        var currentMonth = new Date().getMonth() + 1; // getMonth() returns 0-11
        var bulan = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'].slice(0, currentMonth);

        var transaksi = {
          labels: bulan,
          datasets: [{
              label: 'Penjualan',
              backgroundColor: '#28a745',
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
              backgroundColor: '#df4957',
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
              backgroundColor: 'rgba(60,141,188,0.9)',
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
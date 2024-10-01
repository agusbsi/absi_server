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
            <p>Selamat datang di Dahboard <a href="#">Supervisor</a> <br>
              anda bisa menggunakan aplikasi ABSI ini untuk mempermudah pekerjaan anda.</p>
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
              echo "Kosong";
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
              echo "Kosong";
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
              echo "Kosong";
            } else {
              echo number_format($t_stok->total);
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
              echo "Kosong";
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
      <h3 class="card-title">Transaksi Semua Toko Yang Anda Kelola</h3>
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
          TOP 5 TOKO - STOK TERBANYAK
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
                    <a href="javascript:void(0)" class="product-title"><?= $dd->nama_toko ?>
                      <span class="badge badge-warning float-right"><?= number_format($dd->total) ?> Artikel</span></a>
                    <span class="product-description">
                      <small><?= $dd->spg ?></small>
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
          <strong><?= ($t_minta->total == 0) ? "Kosong" : number_format($t_minta->total) . " Artikel" ?></strong>
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
          <strong><?= ($t_kirim->total == 0) ? "Kosong" : number_format($t_kirim->total) . " Artikel" ?></strong>
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
          <strong><?= ($t_jual->total == 0) ? "Kosong" : number_format($t_jual->total) . " Artikel" ?></strong>
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
          <strong><?= ($t_retur->total == 0) ? "Kosong" : number_format($t_retur->total) . " Artikel" ?></strong>
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
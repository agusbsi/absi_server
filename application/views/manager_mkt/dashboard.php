<style>
  .nomor {
    position: absolute;
    transform: translate(-250%, 10%);
    font-weight: bold;
  }
</style>
<section class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="card card-success card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-bullhorn"></i>
            <?php
            date_default_timezone_set("Asia/Jakarta");
            $b = time();
            $hour = date("G", $b);
            if ($hour >= 0 && $hour <= 11) {
              echo "Selamat Pagi :)";
            } elseif ($hour >= 12 && $hour <= 14) {
              echo "Selamat Siang :) ";
            } elseif ($hour >= 15 && $hour <= 17) {
              echo "Selamat Sore :) ";
            } elseif ($hour >= 17 && $hour <= 18) {
              echo "Selamat Petang :) ";
            } elseif ($hour >= 19 && $hour <= 23) {
              echo "Selamat Malam :) ";
            }

            ?>,
          </h3>
        </div>
        <div class="card-body">
          <h4>
            <strong> <?= $this->session->userdata('nama_user') ?> !</strong>
          </h4> <br>
          <strong>INI HALAMAN MANAGER MARKETING !</strong>
          <hr>
        </div>
        <div class="card-footer text-right">
          <a href="#" class=" text-secondary">By ABSI</a>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <div class="col-md-4">
      <div class="info-box bg-info">
        <span class="info-box-icon"><i class="fa fa-store"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Toko</span>
          <span class="info-box-number">
            <?= ($t_toko->total == 0) ? "Kosong" : number_format($t_toko->total) ?>
          </span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <a href="<?= base_url('mng_mkt/User') ?>" class=" text-white text-right">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="info-box bg-danger">
        <span class="info-box-icon"><i class="fa fa-users"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total User</span>
          <span class="info-box-number">
            <?= ($t_user->total == 0) ? "Kosong" : number_format($t_user->total) ?>
          </span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <a href="<?= base_url('mng_mkt/User') ?>" class="text-white text-right">Detail <i class="fas fa-arrow-circle-right"></i></a>
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
  <div class="row">
    <div class="col-md-6">
      <div class="card card-success">
        <div class="card-header text-center">
          <strong> TOP 5 TOKO - PENJUALAN TERBANYAK</strong>
        </div>
        <div class="card-body">
          <ul class="products-list product-list-in-card">
            <?php if (is_array($top_toko)) { ?>
              <?php
              $no = 0;
              foreach ($top_toko as $dd) :
                $no++;
              ?>
                <li class="item">
                  <div class="product-img">
                    <i class="fas fa-certificate text-success fa-2x"></i>
                    <span class="nomor text-white"><?= $no ?></span>
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
        <div class="card-footer">
          <small>* Periode Penjualan : <?= date('M-Y', strtotime('last month')) ?></small>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card card-success">
        <div class="card-header text-center">
          <strong> TOP 5 ARTIKEL - TERJUAL TERBANYAK</strong>
        </div>
        <div class="card-body">
          <ul class="products-list product-list-in-card">
            <?php if (is_array($top_artikel)) { ?>
              <?php
              $no = 0;
              foreach ($top_artikel as $dd) :
                $no++;
              ?>
                <li class="item">
                  <div class="product-img">
                    <i class="fas fa-certificate text-success fa-2x"></i>
                    <span class="nomor text-white"><?= $no ?></span>
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title"><?= $dd->kode ?>
                      <span class="badge badge-warning float-right"><?= number_format($dd->total) ?> Terjual</span></a>
                    <span class="product-description">
                      <small><?= $dd->nama_produk ?></small>
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
        <div class="card-footer">
          <small>* Periode Penjualan : <?= date('M-Y', strtotime('last month')) ?></small>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <!-- toko teratas -->
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
      <!-- /.card -->
      <!-- end toko -->

    </div>
    <div class="col-md-4">
      <!-- isi Calender -->
      <!-- Calendar -->
      <div class="card bg-gradient-success">
        <div class="card-header border-0">

          <h3 class="card-title">
            <i class="far fa-calendar-alt"></i>
            Calendar
          </h3>
          <!-- tools card -->
          <div class="card-tools">
            <!-- button with a dropdown -->
            <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
          <!-- /. tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body pt-0">
          <!--The calendar -->
          <div id="calendar" style="width: 100%"></div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
</section>
<script src="<?php echo base_url() ?>/assets/plugins/chart.js/Chart.min.js"></script>
<script>
  $(document).ready(function() {
    $.ajax({
      url: '<?= base_url('mng_mkt/Dashboard/transaksi') ?>',
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
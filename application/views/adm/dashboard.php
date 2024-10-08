<style>
  .nomor {
    position: absolute;
    transform: translate(-250%, 10%);
    font-weight: bold;
  }

  .list {
    padding: 0;
    margin: 0;
    list-style: none;
  }

  .list-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #ddd;
    padding: 10px;
  }

  .list-item:last-child {
    border-bottom: none;
  }

  .number {
    background-color: #e8f5e9;
    color: #34a853;
    font-size: 20px;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-weight: bold;
  }

  .details {
    flex-grow: 1;
    margin-left: 10px;
  }

  .details h4 {
    margin: 0;
    font-size: 16px;
    font-weight: bold;
  }

  .details span {
    font-size: 14px;
    color: gray;
  }

  .amount {
    text-align: right;
    font-size: 16px;
    font-weight: bold;
  }

  .amount .percentage {
    font-size: 14px;
    font-weight: bold;
  }

  .amount span {
    color: gray;
    font-size: 12px;
    font-weight: normal;
  }
</style>
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
              <p>Selamat datang di Dahboard <a href="#">Direksi.</a> <br>
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
                <?= ($info_box->total == 0) ? "Kosong" : number_format($info_box->total) ?>
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
    <div class="callout callout-danger">
      <p> Data Transaksi Bulan ini ( <b><?= date('M-Y') ?></b> )</p>
    </div>
    <!-- box transaksi -->
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
            <ul class="list">
              <?php if (is_array($top_toko)) { ?>
                <?php
                $no = 0;
                foreach ($top_toko as $dd) :
                  $no++;
                  // Menghitung persentase perubahan
                  $persen = 0;
                  if ($dd->total_bulan_lalu > 0) {
                    $persen = (($dd->total_bulan_ini - $dd->total_bulan_lalu) / $dd->total_bulan_lalu) * 100;
                  }
                ?>
                  <li class="list-item">
                    <div class="number"><?= $no ?></div>
                    <div class="details">
                      <h4><?= $dd->nama_toko ?></h4>
                      <span><?= $dd->spg ?></span>
                    </div>
                    <div class="amount">
                      <?= number_format($dd->total_bulan_ini) ?>
                      <div>
                        <span class="percentage <?= ($persen >= 0) ? 'text-success' : 'text-danger' ?>">
                          <?= ($persen >= 0) ? '<i class="fas fa-arrow-up"></i> ' . number_format($persen, 2) . '%' : '<i class="fas fa-arrow-down"></i> ' . number_format($persen, 2) . '%' ?>
                        </span>
                        <span>dari bulan sebelumnya</span>
                      </div>
                    </div>
                  </li>
                <?php endforeach; ?>
              <?php } else { ?>
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
      <div class="col-md-6">
        <div class="card card-danger">
          <div class="card-header text-center">
            <strong> TOP 5 TOKO - PENJUALAN TERKECIL</strong>
          </div>
          <div class="card-body">
            <ul class="products-list product-list-in-card">
              <?php if (is_array($low_toko)) { ?>
                <?php
                $no = 0;
                foreach ($low_toko as $dd) :
                  $no++;
                ?>
                  <li class="item">
                    <div class="product-img">
                      <i class="fas fa-certificate text-danger fa-2x"></i>
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
        <div class="card card-danger">
          <div class="card-header text-center">
            <strong> TOP 5 ARTIKEL - TERJUAL TERKECIL</strong>
          </div>
          <div class="card-body">
            <ul class="products-list product-list-in-card">
              <?php if (is_array($low_artikel)) { ?>
                <?php
                $no = 0;
                foreach ($low_artikel as $dd) :
                  $no++;
                ?>
                  <li class="item">
                    <div class="product-img">
                      <i class="fas fa-certificate text-danger fa-2x"></i>
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
    <div class="card card-danger">
      <div class="card-header">
        <h3 class="card-title">Stok Artikel Berdasarkan Supervisor</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-5">
            <table class="table" id="data-table">
              <thead>
                <tr class="text-center">
                  <th rowspan="2">Supervisor</th>
                  <th colspan="2">Total</th>
                  <th rowspan="2">(%)</th>
                </tr>
                <tr class="text-center">
                  <th>Toko</th>
                  <th>Stok</th>
                </tr>
              </thead>
              <tbody></tbody>
              <tfoot>
                <tr>
                  <th class="text-right">Grand Total : </th>
                  <th id="grand-total-toko"></th>
                  <th id="grand-total-stok"></th>
                  <th id="persen"></th>
                </tr>
              </tfoot>
            </table>
          </div>
          <div class="col-md-7">
            <div class="chart mt-5 pt-3">
              <canvas id="grafikStokSPV" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <small>* Data ini di ambil dari Toko yang sudah di kaitkan ke Supervisor.</small>
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
      url: '<?= base_url('adm/Dashboard/transaksi') ?>',
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
<script>
  $(document).ready(function() {
    $.ajax({
      url: '<?= base_url('adm/Dashboard/stok_spv'); ?>',
      method: 'GET',
      dataType: 'json',
      success: function(data) {
        var labels = [];
        var dataValues = [];
        var tableContent = '';
        var grandTotalToko = 0;
        var grandTotalStok = 0;

        data.forEach(function(item) {
          labels.push(item.nama);
          dataValues.push(item.total_stok);
          grandTotalToko += parseInt(item.total_toko);
          grandTotalStok += parseInt(item.total_stok);
        });

        data.forEach(function(item) {
          var totalStokNumeric = parseInt(item.total_stok);
          var percentage = ((item.total_stok / grandTotalStok) * 100).toFixed(2);
          tableContent += '<tr><td><small>' + item.nama + '</small></td><td><small>' + item.total_toko + '</small></td><td><small>' + totalStokNumeric.toLocaleString() + '</small></td><td><small>' + percentage + '%</small></td></tr>';
        });

        $('#data-table tbody').html(tableContent);
        $('#grand-total-toko').text(grandTotalToko);
        $('#grand-total-stok').text(grandTotalStok.toLocaleString());
        $('#persen').text('100 %');

        var donutChartCanvas = $('#grafikStokSPV').get(0).getContext('2d');
        var donutData = {
          labels: labels,
          datasets: [{
            data: dataValues,
            backgroundColor: [
              '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'
            ],
          }]
        };
        var donutOptions = {
          maintainAspectRatio: false,
          responsive: true,
        };

        new Chart(donutChartCanvas, {
          type: 'doughnut',
          data: donutData,
          options: donutOptions
        });
      }
    });
  });
</script>
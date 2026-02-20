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
              <p>Selamat datang di Dahboard <a href="#">Tim Produksi.</a> <br>
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
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="callout callout-success">
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
    <div class="card card-danger">
      <div class="card-header">
        <h3 class="card-title">10 Artikel terbanyak di Gudang Prepedan</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="chart">
              <canvas id="grafikStokSPV" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <table class="table table-sm table-striped" id="data-table">
              <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th style="width:15%">Kode</th>
                  <th>Nama Produk</th>
                  <th>Stok</th>
                  <th>% dari Total</th>
                </tr>
              </thead>
              <tbody></tbody>
              <tfoot>
                <tr>
                  <th colspan="3" class="text-right">Total 10 Artikel : </th>
                  <th id="grand-total-stok"></th>
                  <th id="total-percentage"></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <small>
          <b>Total Keseluruhan:</b> <span id="total-artikel"></span> Artikel dengan total stok <span id="total-stok-keseluruhan"></span>
        </small>
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
<!-- Chart.js Datalabels Plugin for Chart.js v2 -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
<script>
  $(document).ready(function() {
    $.ajax({
      url: '<?= base_url('produksi/Dashboard/transaksi') ?>',
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
      url: '<?= base_url('produksi/Dashboard/stok_terbanyak'); ?>',
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        var labels = [];
        var dataValues = [];
        var productNames = [];
        var tableContent = '';
        var top10TotalStok = 0;
        var totalStokKeseluruhan = parseInt(response.total_stok);

        // Build table rows and chart data
        response.top10.forEach(function(item, index) {
          var totalStokNumeric = parseInt(item.stok);
          var percentage = ((totalStokNumeric / totalStokKeseluruhan) * 100).toFixed(2);
          top10TotalStok += totalStokNumeric;

          // Add to table
          tableContent += '<tr>';
          tableContent += '<td class="text-center"><small>' + (index + 1) + '</small></td>';
          tableContent += '<td><small>' + item.kode + '</small></td>';
          tableContent += '<td><small>' + item.nama_produk + '</small></td>';
          tableContent += '<td class="text-right"><small><b>' + totalStokNumeric.toLocaleString() + '</b></small></td>';
          tableContent += '<td class="text-center"><small>' + percentage + '%</small></td>';
          tableContent += '</tr>';

          // Add to chart data (maintain order - highest first = top of chart)
          labels.push(item.kode);
          dataValues.push(totalStokNumeric);
          productNames.push(item.nama_produk);
        });

        $('#data-table tbody').html(tableContent);
        $('#grand-total-stok').html('<b>' + top10TotalStok.toLocaleString() + '</b>');
        var totalPercentage = ((top10TotalStok / totalStokKeseluruhan) * 100).toFixed(2);
        $('#total-percentage').html('<b>' + totalPercentage + '%</b>');
        $('#total-artikel').text(parseInt(response.total_artikel).toLocaleString());
        $('#total-stok-keseluruhan').text(totalStokKeseluruhan.toLocaleString());

        // Create horizontal bar chart
        var barChartCanvas = $('#grafikStokSPV').get(0).getContext('2d');

        var gradientColors = [
          '#dc3545', '#e74c3c', '#f56954', '#ff6b6b',
          '#ff8c42', '#ffa726', '#ffc107', '#ffeb3b',
          '#8bc34a', '#4caf50'
        ];

        var barChartData = {
          labels: labels,
          datasets: [{
            label: 'Stok Artikel',
            data: dataValues,
            backgroundColor: gradientColors,
            borderColor: gradientColors.map(color => color),
            borderWidth: 1
          }]
        };

        var barChartOptions = {
          maintainAspectRatio: false,
          responsive: true,
          legend: {
            display: false
          },
          scales: {
            xAxes: [{
              ticks: {
                beginAtZero: true,
                callback: function(value) {
                  return value.toLocaleString();
                }
              },
              scaleLabel: {
                display: true,
                labelString: 'Jumlah Stok'
              }
            }],
            yAxes: [{
              ticks: {
                fontSize: 11
              },
              scaleLabel: {
                display: true,
                labelString: 'Kode Artikel'
              }
            }]
          },
          tooltips: {
            callbacks: {
              title: function(tooltipItem, data) {
                var index = labels.indexOf(tooltipItem[0].label);
                return productNames[index];
              },
              label: function(tooltipItem, data) {
                var value = tooltipItem.value;
                var percentage = ((value / totalStokKeseluruhan) * 100).toFixed(2);
                return [
                  'Kode: ' + tooltipItem.label,
                  'Stok: ' + parseInt(value).toLocaleString(),
                  'Persentase: ' + percentage + '%'
                ];
              }
            }
          },
          plugins: {
            datalabels: {
              display: true,
              anchor: 'end',
              align: 'end',
              formatter: function(value, context) {
                var percentage = ((value / totalStokKeseluruhan) * 100).toFixed(1);
                return value.toLocaleString() + ' (' + percentage + '%)';
              },
              color: '#333',
              font: {
                weight: 'bold',
                size: 10
              }
            }
          }
        };

        new Chart(barChartCanvas, {
          type: 'horizontalBar',
          data: barChartData,
          options: barChartOptions
        });
      }
    });
  });
</script>
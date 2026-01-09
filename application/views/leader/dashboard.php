<style>
  /* menu livin */
  .menu-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
  }

  .menu-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin-bottom: 10px;
    position: relative;
  }

  .menu-item a {
    position: relative;
    display: inline-block;
  }

  /* Notif Badge */
  .notif {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: #ed2938;
    color: #fff;
    border-radius: 50%;
    padding: 4px 6px;
    font-size: 0.7rem;
    font-weight: bold;
    line-height: 1;
    text-align: center;
    box-shadow: 0 0 0 2px #fff;
    animation: bounce 1.5s infinite;
  }

  @keyframes bounce {

    0%,
    20%,
    50%,
    80%,
    100% {
      transform: translateY(0);
    }

    40% {
      transform: translateY(-6px);
    }

    60% {
      transform: translateY(-3px);
    }
  }

  .menu-item i {
    font-size: 30px;
    margin-bottom: 5px;
    background-color: rgb(238, 242, 248);
    color: #007bff;
    padding: 12px 16px;
    border-radius: 25%;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }

  .menu-item a:hover i {
    color: #28a745;
    background-color: rgb(214, 248, 222);
    transform: scale(1.1);
  }

  .menu-item span {
    font-size: 12px;
    font-weight: 700;
    color: #333;
    margin-top: 4px;
  }

  .judul-menu {
    font-size: 18px;
    font-weight: 700;
    color: #333;
    margin: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
</style>

<?php
$id = $this->session->userdata('id');
$Permintaan = $this->db->query("SELECT * FROM tb_permintaan JOIN tb_toko ON tb_permintaan.id_toko = tb_toko.id JOIN tb_user ON tb_user.id = tb_toko.id_leader WHERE tb_permintaan.status = '0' AND tb_toko.id_leader ='$id'")->num_rows();
$Retur = $this->db->query("SELECT * FROM tb_retur JOIN tb_toko ON tb_retur.id_toko = tb_toko.id JOIN tb_user ON tb_user.id = tb_toko.id_leader WHERE tb_retur.status = '0' AND tb_toko.id_leader ='$id'")->num_rows();
$Bap = $this->db->query("SELECT * FROM tb_bap 
  JOIN tb_toko ON tb_bap.id_toko = tb_toko.id 
  JOIN tb_user ON tb_user.id = tb_toko.id_leader 
  WHERE tb_bap.status = '0' AND tb_toko.id_leader ='$id'")->num_rows();
$kirim = $this->db->query("SELECT tp.id FROM tb_pengiriman tp
  JOIN tb_toko tt ON tp.id_toko = tt.id 
  JOIN tb_user tu ON tu.id = tt.id_leader 
  WHERE tp.status = '1' AND tt.id_leader ='$id'")->num_rows();
?>
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
            <p>Selamat datang di Dahboard <a href="#">Team Leader.</a> <br>
              anda bisa menggunakan aplikasi ABSI ini untuk mempermudah pekerjaan anda.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card card-primary card-outline">
    <div class="card-header">
      Menu Utama
    </div>
    <div class="card-body">
      <div class="menu-container">
        <div class="menu-item">
          <a href="<?= base_url('leader/toko') ?>"><i class="fas fa-store"></i></a>
          <span>Toko Aktif</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('spv/Toko/toko_tutup') ?>"><i class="fas fa-store-slash"></i></a>
          <span>Toko Tutup</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('leader/spg') ?>"><i class="fas fa-users"></i></a>
          <span>SPG</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('adm/Stok/stok_gudang') ?>"><i class="fas fa-warehouse"></i></a>
          <span>Stok Gudang</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('leader/permintaan') ?>">
            <?php if ($Permintaan != 0) { ?>
              <div class="notif">
                <?= $Permintaan; ?>
              </div>
            <?php } ?>
            <i class="fas fa-file-alt"></i>
          </a>
          <span>PO</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('leader/pengiriman') ?>">
            <?php if ($kirim != 0) { ?>
              <div class="notif">
                <?= $kirim; ?>
              </div>
            <?php } ?>
            <i class="fas fa-truck"></i>
          </a>
          <span>Pengiriman</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('leader/retur') ?>">
            <?php if ($Retur != 0) { ?>
              <div class="notif">
                <?= $Retur; ?>
              </div>
            <?php } ?>
            <i class="fas fa-exchange-alt"></i>
          </a>
          <span>Retur</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('leader/Mutasi') ?>">
            <i class="fas fa-copy"></i>
          </a>
          <span>Mutasi</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('leader/Bap') ?>">
            <?php if ($Bap != 0) { ?>
              <div class="notif">
                <?= $Bap; ?>
              </div>
            <?php } ?>
            <i class="fas fa-envelope"></i>
          </a>
          <span>BAP</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('sup/So') ?>"><i class="fas fa-box"></i></a>
          <span>SO Artikel</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('hrd/Aset/list_aset') ?>"><i class="fas fa-cubes"></i></a>
          <span>SO Aset</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('sup/So/Riwayat_so') ?>"><i class="fas fa-history"></i></a>
          <span>Riwayat SO Artikel</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('adm/So/histori_aset') ?>"><i class="fas fa-clipboard-list"></i></a>
          <span>Riwayat SO Aset</span>
        </div>
        <div class="menu-item">
          <a href="<?= base_url('leader/Penjualan/lap_toko') ?>"><i class="fas fa-cart-plus"></i></a>
          <span>Lap Penjualan</span>
        </div>

      </div>
    </div>
  </div>
  <div class="card card-success">
    <div class="card-header">
      <h3 class="card-title">Transaksi Semua Toko ( <?= date('Y') ?> )</h3>
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
</section>
<script src="<?php echo base_url() ?>/assets/plugins/chart.js/Chart.min.js"></script>
<script>
  $(document).ready(function() {
    $.ajax({
      url: '<?= base_url('leader/Dashboard/transaksi') ?>',
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
<style>
  #loading {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(255, 255, 255, 0.7);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .loader {
    position: relative;
    width: 200px;
    height: 200px;
  }

  .circle {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: conic-gradient(#3498db 0deg, #3498db 0deg, transparent 0deg);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .percentage {
    position: absolute;
    font-size: 2em;
    font-weight: bold;
    color: #ffc107;
  }

  .img-nodata {
    width: 100%;

  }
</style>
<section class="content">
  <div class="container-fluid">
    <div id="loading" style="display: none;">
      <div class="loader">
        <div class="circle">
          <div class="percentage" id="percentage">0%</div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">
              <li class="fas fa-cube"></li> Data Permintaan
            </h3>
          </div>
          <div class="card-body">
            <form action="<?= base_url('sup/Permintaan') ?>" method="post" id="form_cari">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label>Kategori</label>
                    <?php if (empty($kat)) { ?>
                      <input type="text" name="kategori" value="<?= !empty($kat) ? $kat : '' ?>" class="form-control form-control-sm" placeholder="Cari berdasarkan Nomor atau Nama Toko">
                    <?php } else { ?>
                      <input type="text" class="form-control form-control-sm" value="<?= $kat ?>" readonly>
                    <?php } ?>

                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Range Tanggal</label>
                    <?php if (empty($tgl)) { ?>
                      <input type="text" name="tanggal" class="form-control form-control-sm" autocomplete="off" placeholder="Periode">
                    <?php } else { ?>
                      <input type="text" class="form-control form-control-sm" value="<?= $tgl ?>" readonly>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-3">
                  <br>
                  <?php if (!empty($tgl || $kat)) { ?>
                    <a href="<?= base_url('adm/Permintaan') ?>" class="btn btn-sm btn-danger mt-2"><i class="fas fa-times-circle"></i> Reset</a>
                  <?php } else { ?>
                    <button class="btn btn-info btn-sm mt-2" id="btn_cari"><i class="fas fa-search"></i> Cari Data</button>
                  <?php } ?>
                </div>
              </div>
            </form>
            <hr>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th style="width: 2%">#</th>
                  <th>Nomor PO</th>
                  <th>Status</th>
                  <th>Toko</th>
                  <th>Tgl Update</th>
                  <th>Menu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($list as $data) :
                  $no++; ?>
                  <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td class="text-center"><?= $data->id ?></td>
                    <td class="text-center">
                      <?php
                      status_permintaan($data->status);
                      ?>
                    </td>
                    <td><?= $data->nama_toko ?></td>
                    <td class="text-center"><?= date('d-M-Y H:m:s', strtotime($data->created_at)) ?></td>
                    <td class="text-center">
                      <?php
                      if ($data->status == 1) {
                      ?>
                        <a class="btn btn-success btn-sm" href="<?= base_url('sup/permintaan/terima/' . $data->id) ?>"><i class="fas fa-paper-plane"></i> Proses</a>
                      <?php
                      } else {
                      ?>
                        <a class="btn btn-primary btn-sm" href="<?= base_url('sup/permintaan/detail/' . $data->id) ?>"><i class="fas fa-eye"></i> Detail</a>
                      <?php }
                      ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function() {
    $('input[name="tanggal"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
        cancelLabel: 'Clear'
      }
    });

    $('input[name="tanggal"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('input[name="tanggal"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });
  })
  document.getElementById('btn_cari').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent form submission

    var loadingElement = document.getElementById('loading');
    loadingElement.style.display = 'flex';
    var percentageElement = document.getElementById('percentage');
    var circle = document.querySelector('.circle');
    var percentage = 0;
    var intervalTime = 50; // Update every 50ms
    var intervalDuration = 500; // 2 seconds

    var interval = setInterval(() => {
      if (percentage < 100) {
        percentage += 5;
        percentageElement.textContent = Math.round(percentage) + '%';
        var angle = percentage * 3.6;
        circle.style.background = `conic-gradient(
                #3498db 0deg,
                #3498db ${angle}deg,
                transparent ${angle}deg,
                transparent 360deg
            )`;
      } else {
        clearInterval(interval);
        setTimeout(() => {
          document.getElementById('form_cari').submit();
        }, intervalDuration);
      }
    }, intervalTime);
  });
</script>
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
            <h3 class="card-title"><i class="fas fa-copy"></i> <?= $title ?></h3>
          </div>
          <div class="card-body">
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <i class="icon fas fa-info"></i>
              <small>Info : Proses verifikasi Mutasi sekarang berpindah ke manager operasional dan manager marketing. </small>
            </div>
            <hr>
            <form action="<?= base_url('adm/Mutasi') ?>" method="post" id="form_cari">
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
                    <a href="<?= base_url('adm/Mutasi') ?>" class="btn btn-sm btn-danger mt-2"><i class="fas fa-times-circle"></i> Reset</a>
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
                  <th>#</th>
                  <th>Nomor</th>
                  <th>Nama Toko</th>
                  <th>Status</th>
                  <th>Tgl Buat</th>
                  <th>Tgl Terima</th>
                  <th>Menu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($list as $row) {
                  $no++; ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td class="text-center"><small><strong><?= $row->id ?></strong></small></td>
                    <td><small>
                        <b>Asal :</b> <?= $row->pengirim ?> <br>
                        <b>Tujuan :</b> <?= $row->tujuan ?>
                      </small></td>
                    <td class="text-center"><?= status_mutasi($row->status) ?></td>
                    <td class="text-center"><small><?= date('d-M-Y : H:m:s', strtotime($row->created_at)) ?></small></td>
                    <td class="text-center"><small><?= $row->tgl_terima ? date('d-M-Y', strtotime($row->tgl_terima)) : "-" ?></small></td>
                    <td class="text-center"><a class="btn btn-primary btn-sm" href="<?= base_url('adm/Mutasi/detail/') . $row->id ?>"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
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
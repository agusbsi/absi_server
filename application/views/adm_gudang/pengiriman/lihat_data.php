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
  <div id="loading" style="display: none;">
    <div class="loader">
      <div class="circle">
        <div class="percentage" id="percentage">0%</div>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="card card-info ">
      <div class="card-header">
        <h3 class="card-title">
          <li class="fas fa-truck"></li> Data Pengiriman
        </h3>
        <div class="card-tools">
        </div>
        <!-- /.card-tools -->
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <form action="<?= base_url('adm_gudang/Pengiriman') ?>" method="post" id="form_cari">
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
                <a href="<?= base_url('adm_gudang/Pengiriman') ?>" class="btn btn-sm btn-danger mt-2"><i class="fas fa-times-circle"></i> Reset</a>
              <?php } else { ?>
                <button class="btn btn-info btn-sm mt-2" id="btn_cari"><i class="fas fa-search"></i> Cari Data</button>
              <?php } ?>
            </div>
          </div>
        </form>
        <hr>
        <!-- isi konten -->
        <table id="table_kirim" class="table table-bordered table-striped">
          <thead>
            <tr class="text-center">
              <th>No.</th>
              <th style="width: 15%;">Kode #</th>
              <th>Status</th>
              <th style="width: 30%;">Nama Toko</th>
              <th>Tanggal</th>
              <th style="width: 13%;">Menu</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            foreach ($list as $dd) :
              $no++;
            ?>
              <tr>
                <td><?= $no ?></td>
                <td><?= $dd->id ?></td>
                <td>
                  <?= status_pengiriman($dd->status) ?>
                </td>
                <td>
                  <b style="font-size:small"><?= $dd->nama_toko ?> </b><br>
                  <small><b>Leader :</b> <?= $dd->leader ? $dd->leader : 'Tidak ada' ?> </small>
                </td>
                <td>
                  <small><?= date("d F Y, H:i:s", strtotime($dd->created_at)) ?></small>
                </td>

                <td>

                  <a type="button" class="btn btn-primary btn-sm" href="<?= base_url('adm_gudang/pengiriman/detail_p/' . $dd->id) ?>" name="btn_detail" title="Detail"><i class="fa fa-eye" aria-hidden="true"></i> </a>
                  <button type="button" data-id="<?= $dd->id ?>" data-id_po="<?= $dd->id_permintaan ?>" data-toko="<?= $dd->nama_toko ?>" data-toggle="modal" data-target="#modal-export" class="btn btn-warning btn-sm btn_export" title="Export ke Easy"><i class="fa fa-file-export"></i> </button>
                  <a type="button" class="btn btn-default btn-sm <?= ($dd->status != "1") ? 'd-none' : ''; ?>" target="_blank" href="<?= base_url('adm_gudang/Pengiriman/detail_print/' . $dd->id) ?>" title="Print Surat Jalan"><i class="fa fa-print" aria-hidden="true"></i></a>

                </td>

              </tr>
            <?php endforeach; ?>

          </tbody>

        </table>
      </div>
      <!-- /.card-body -->

    </div>
    <!-- /.card -->
  </div>
</section>
<div class="modal fade" id="modal-export">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h4 class="modal-title">
          <li class="fa fa-excel"></li> Integrasi Data ke Easy Accounting
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formExport" method="post" action="<?= base_url('adm_gudang/Pengiriman/export_ea'); ?>">
          <div class="form-group">
            <label for="file">No. Transfer</label>
            <input type="text" name="no_transfer" class="form-control form-control-sm" placeholder="Gunakan no urut dr Easy Accounting..." required>
            <input type="hidden" name="id_kirim" id="id_kirim">
            <input type="hidden" name="id_po" id="id_po">
          </div>
          <div class="form-group">
            <label for="file">Tanggal</label>
            <input type="date" name="tanggal" class="form-control form-control-sm" required>
          </div>
          <div class="form-group">
            <label for="file">Toko</label>
            <input type="text" name="toko" class="form-control form-control-sm nama_toko" readonly>
          </div>
      </div>
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
          <li class="fas fa-times-circle"></li> Close
        </button>
        <button type="submit" class="btn btn-primary btn-sm" id="export-button">
          <li class="fas fa-file-export"></li> Export
        </button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- jQuery -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script>
  $(document).ready(function() {

    $('#table_kirim').DataTable({
      order: [
        [0, 'asc']
      ],
      responsive: true,
      lengthChange: false,
      autoWidth: false,
    });
  })
</script>
<script>
  document.getElementById('export-button').addEventListener('click', function(event) {
    event.preventDefault(); // Menghentikan eksekusi default (submit) dari tombol
    var noTransfer = $('[name="no_transfer"]').val();
    var tanggal = $('[name="tanggal"]').val();
    if (noTransfer == "" || tanggal == "") { // Menggunakan operator || (atau) agar salah satu dari kedua input tidak boleh kosong
      alert('No Transfer & Tanggal tidak boleh kosong');
    } else {
      // Jalankan submit di sini
      document.getElementById('formExport').submit(); // Ganti 'form-id' dengan ID formulir Anda
      alert('Berhasil Export Data');
      $('#modal-export').modal('hide');
      $('[name="no_transfer"]').val('');
      $('[name="tanggal"]').val('');
    }

  });
</script>

<script>
  $('.btn_export').on('click', function() {
    // get data from button edit
    const id = $(this).data('id');
    const id_po = $(this).data('id_po');
    const toko = $(this).data('toko');
    // Set data to Form Edit
    $('#id_kirim').val(id);
    $('#id_po').val(id_po);
    $('.nama_toko').val(toko);
    // Call Modal Edit
    $('#modal-export').modal('show');
  });
</script>
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
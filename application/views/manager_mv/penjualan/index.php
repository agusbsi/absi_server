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
              <i class="fas fa-cube"></i>
              Data Penjualan
            </h3>
          </div>

          <div class="card-body">
            <form action="<?= base_url('sup/Penjualan') ?>" method="post" id="form_cari">
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
                      <input type="text" name="tanggal" id="periode" class="form-control form-control-sm" autocomplete="off" placeholder="Tanggal Penjualan">
                    <?php } else { ?>
                      <input type="text" class="form-control form-control-sm" value="<?= $tgl ?>" readonly>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-3">
                  <br>
                  <?php if (!empty($tgl || $kat)) { ?>
                    <a href="<?= base_url('sup/Penjualan') ?>" class="btn btn-sm btn-danger mt-2"><i class="fas fa-times-circle"></i> Reset</a>
                  <?php } else { ?>
                    <button class="btn btn-info btn-sm mt-2" id="btn_cari"><i class="fas fa-search"></i> Cari Data</button>
                  <?php } ?>
                </div>
              </div>
            </form>
            <hr>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 1%">
                    #
                  </th>
                  <th style="width: 20%">No. Penjualan</th>
                  <th>
                    Nama Toko
                  </th>
                  <th>Tgl. Penjualan</th>
                  <th>Tgl Buat</th>
                  <th style="width: 13%">Menu</th>
                </tr>
              </thead>
              <tbody>
                <?php if (is_array($list)) { ?>
                  <?php $no = 0; ?>
                  <?php foreach ($list as $data) {
                    $no++ ?>
                    <tr>
                      <td><?= $no; ?></td>
                      <td><?= $data->id; ?></td>
                      <td><?= $data->nama_toko; ?></td>
                      <td><?= format_tanggal2($data->tanggal_penjualan); ?></td>
                      <td><?= format_tanggal2($data->created_at); ?></td>
                      <td>
                        <a href="<?= base_url('sup/Penjualan/detail/' . $data->id) ?>" class="btn btn-primary btn-sm" title="Detail"><i class="fas fa-eye"></i> <?= ($akses == 1) ? "" : "Detail" ?></a>
                        <button onclick="exportSo('<?= $data->id; ?>','<?= $data->nama_toko; ?>','<?= $data->tanggal_penjualan; ?>')" data-toggle="modal" data-target=".edit_modal" class="btn btn-warning <?= ($akses == 1) ? "" : "d-none" ?> btn-sm" title="Edit tgl"><i class="fas fa-edit"></i></button>
                        <a href="#" class="btn btn-danger <?= ($akses == 1) ? "" : "d-none" ?> btn-sm btn_delete" data-id="<?= $data->id ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr>
                    <td colspan="7" align="center"><strong>Data Kosong</strong></td>
                  </tr>
                <?php } ?>
              </tbody>

            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade edit_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <form id="formExport" action="<?= base_url('sup/Penjualan/update_jual') ?>" method="post">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title" id="exampleModalLabel">Edit Penjualan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <label for="">No. Penjualan :</label>
          <input type="text" id="nomor" class="form-control form-control-sm" readonly>
          <div class="form-group">
            <label for="">Toko :</label>
            <input type="text" id="toko" class="form-control form-control-sm" readonly>
          </div>
          <div class="form-group">
            <label for="">Tgl Penjualan :</label>
            <input type="date" name="tanggal" id="tgl_jual" class="form-control form-control-sm" autocomplete="off" required>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_jual" id="id_jual" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm" id="export-button"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  function exportSo(id, toko, tgl) {
    var tanggal = tgl.split(' ')[0];
    $('#id_jual').val(id);
    $('#nomor').val(id);
    $('#toko').val(toko);
    $('#tgl_jual').val(tanggal);
  }
</script>
<script>
  $('.btn_delete').click(function(e) {
    const id = $(this).data('id');
    e.preventDefault();
    Swal.fire({
      title: 'Hapus Data',
      text: "Apakah anda yakin untuk Menghapusnya ?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        location.href = "<?php echo base_url('sup/Penjualan/hapus_data/') ?>" + id;
      }
    })
  })
</script>
<script>
  $(document).ready(function() {
    $('#periode').daterangepicker({
      autoUpdateInput: false,
      locale: {
        cancelLabel: 'Clear'
      }
    });

    $('#periode').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('#periode').on('cancel.daterangepicker', function(ev, picker) {
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
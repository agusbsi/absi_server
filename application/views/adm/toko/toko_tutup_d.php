<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-danger ">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-store"></i> Pengajuan <?= kategori_pengajuan($retur->kategori) ?></b> </h3>
            <div class="card-tools">
              <a href="<?= base_url('adm/Toko/pengajuanToko') ?>"> <i class="fas fa-times-circle"></i></a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">No. Pengajuan</label> <br>
                  <h5><?= $retur->nomor ?></h5>
                </div>
              </div>
              <div class="col-md-5">
                <label for="">Nama Toko</label> <br>
                <small>
                  <strong><?= $retur->nama_toko ?></strong> <br>
                  <address><?= $retur->alamat ?></address>
                </small>
              </div>
              <div class="col-md-2">
                <label for="">Tanggal</label> <br>
                <small>
                  dibuat : <?= date('d M Y', strtotime($retur->created_at)) ?> <br>
                  tutup : <?= date('d M Y', strtotime($retur->tgl_jemput)) ?>
                </small>
              </div>
              <div class="col-md-2">
                <label for="">Status</label> <br>
                <small>
                  <?= status_pengajuan($retur->status) ?>
                </small>
              </div>
            </div>
            <hr>
            # List Artikel
            <hr>
            <div style="max-height: 300px; overflow-y: auto;">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr class="text-center">
                    <th>No</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  $total = 0;
                  foreach ($artikel as $t) :
                    $no++
                  ?>
                    <tr>
                      <td class="text-center"><?= $no ?></td>
                      <td>
                        <small>
                          <strong><?= $t->kode ?></strong> <br>
                          <?= $t->nama_produk ?>
                        </small>
                      </td>
                      <td class="text-center"><?= $t->qty ?></td>
                    </tr>
                  <?php
                    $total += $t->qty;
                  endforeach;
                  ?>
                  <tr>
                    <td colspan="2" class="text-right">Total :</td>
                    <td class="text-center"><?= $total ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <hr>
            # Proses Pengajuan :
            <hr>
            <div class="timeline">
              <?php $no = 0;
              foreach ($histori as $h) :
                $no++;
              ?>
                <div>
                  <i class="fas bg-blue"><?= $no ?></i>
                  <div class="timeline-item">
                    <span class="time"></span>
                    <p class="timeline-header"><small><?= $h->aksi ?> <strong><?= $h->pembuat ?></strong></small></p>
                    <div class="timeline-body">
                      <small>
                        <?= date('d-M-Y  H:i:s', strtotime($h->tanggal)) ?> <br>
                        Catatan :<br>
                        <?= $h->catatan_h ?>
                      </small>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </div>
            <hr>
            <?php if ($retur->status == 3) { ?>
              <form action="<?= base_url('adm/Toko/tindakan') ?>" method="post" id="form_approve">
                <strong>Catatan Direksi:</strong>
                <textarea name="catatan_direksi" rows="3" class="form-control form-control-sm" required></textarea>
                <input type="hidden" name="id_pengajuan" value="<?= $retur->id ?>">
                <input type="hidden" name="id_retur" value="<?= $retur->id_retur ?>">
                <input type="hidden" name="id_toko" value="<?= $retur->id_toko ?>">
                <input type="hidden" name="pembuat" value="<?= $retur->id_pembuat ?>">
                <small>* harus di isi.</small>
                <div class="form-group">
                  <label for="">Tindakan</label>
                  <select name="tindakan" id="tindakan" class="form-control form-control-sm" required>
                    <option value="">Pilih</option>
                    <option value="4">Setuju</option>
                    <option value="5">Tolak</option>
                  </select>
                </div>
                <hr>
                <div class="text-right">
                  <a href="<?= base_url('adm/Toko/toko_tutup') ?>" class="btn btn-sm btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                  <button type="submit" class="btn btn-sm btn-primary btn_simpan"><i class="fas fa-save"></i> Simpan</button>
                  <?php if ($retur->status == 7) : ?>
                    <button type="button" class="btn btn-sm btn-warning btn_suspend"><i class="fas fa-ban"></i> Suspend Toko</button>
                  <?php endif; ?>
                </div>
              </form>
              <hr>
            <?php } else { ?>
              <div class="row no-print">
                <div class="col-12">
                  <a href="<?= base_url('adm/Toko/pengajuanToko') ?>" class="btn btn-sm btn-danger float-right" style="margin-right: 5px;">
                    <i class="fas fa-arrow-left"></i> Kembali </a>
                  <a href="<?= base_url('adm/Toko/fpo_tutup/' . $retur->id) ?>" target="_blank" class="btn btn-default float-right btn-sm mr-3 <?= $retur->status != 4 ? 'disabled' : '' ?>"><i class="fas fa-print"></i> Print FPO</a>
                  <?php if ($retur->status == 6) : ?>
                    <button type="button" class="btn btn-sm btn-warning float-right mr-3 btn_suspend"><i class="fas fa-ban"></i> Suspend Toko</button>
                  <?php endif; ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>

    </div>
  </div>
  </div>
</section>
<script>
  $(document).ready(function() {
    function validateForm() {
      let isValid = true;
      // Get all required input fields
      $('#form_approve').find('input[required], select[required], textarea[required]').each(function() {
        if ($(this).val() === '') {
          isValid = false;
          $(this).addClass('is-invalid');
        } else {
          $(this).removeClass('is-invalid');
        }
      });
      return isValid;
    }
    $('.btn_simpan').click(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data Pengajuan Tutp Toko akan di proses",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Yakin'
      }).then((result) => {
        if (result.isConfirmed) {

          if (validateForm()) {
            document.getElementById("form_approve").submit();
          } else {
            Swal.fire({
              title: 'Belum Lengkap',
              text: ' Semua kolom  harus di isi.',
              icon: 'error',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            });
          }
        }
      })
    })

    $('.btn_suspend').click(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Suspend Toko?',
        text: "Apakah Anda yakin ingin suspend toko ini secara lengkap? Tindakan ini tidak dapat dibatalkan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Suspend!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url('adm/Toko/Suspend/' . $retur->id) ?>";
        }
      });
    })

    function printDiv(divName) {
      var printContents = document.getElementById(divName).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
    }
  });
</script>
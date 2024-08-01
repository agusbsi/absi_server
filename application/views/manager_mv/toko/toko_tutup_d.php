<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-danger ">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-store"></i> Detail Toko Tutup</b> </h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">Nomor</label> <br>
                  <h5><?= $retur->id ?></h5>
                </div>
              </div>
              <div class="col-md-4">
                <label for="">Nama Toko</label> <br>
                <small>
                  <strong><?= $retur->nama_toko ?></strong> <br>
                  <address><?= $retur->alamat ?></address>
                </small>
              </div>
              <div class="col-md-3">
                <label for="">Tanggal</label> <br>
                <small>
                  Dibuat : <?= date('d M Y', strtotime($retur->created_at)) ?> <br>
                  Penjemputan : <?= date('d M Y', strtotime($retur->tgl_jemput)) ?>
                </small>
              </div>
              <div class="col-md-3">
                <label for="">Status</label> <br>
                <small>
                  <?= status_retur($retur->status) ?>
                </small>
              </div>
            </div>
            <hr>
            #List Aset
            <hr>
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Aset</th>
                  <th>Jumlah</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (empty($aset)) {
                  echo "<tr><td colspan='4' class='text-center'>DATA ASET KOSONG</td></tr>";
                } else {
                  $no = 0;
                  foreach ($aset as $t) :
                    $no++
                ?>
                    <tr>
                      <td class="text-center"><?= $no ?></td>
                      <td>
                        <small>
                          <strong><?= $t->kode ?></strong> <br>
                          <?= $t->aset ?>
                        </small>
                      </td>
                      <td class="text-center"><?= $t->qty ?></td>
                      <td>
                        <small><?= $t->keterangan ?></small>
                      </td>
                    </tr>
                <?php
                  endforeach;
                }
                ?>
              </tbody>
            </table>
            <hr>
            # List Artikel
            <hr>
            <table class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th>Kode</th>
                  <th>Artikel</th>
                  <th>Jumlah</th>
                  <th>Diterima gudang</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                $total = 0;
                $total_a = 0;
                foreach ($artikel as $t) :
                  $no++
                ?>
                  <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td>
                      <small>
                        <strong><?= $t->kode ?></strong>
                      </small>
                    </td>
                    <td>
                      <small><?= $t->nama_produk ?></small>
                    </td>
                    <td class="text-center"><?= $t->qty ?></td>
                    <td class="text-center <?= $retur->status == 15 && $t->qty_terima != $t->qty ? 'bg-danger' : '' ?>"><?= $retur->status == 15 ? $t->qty_terima : 'Belum' ?></td>
                  </tr>
                <?php
                  $total += $t->qty;
                  $total_a += $t->qty_terima;
                endforeach;
                ?>
                <tr>
                  <td colspan="3" class="text-right">Total :</td>
                  <td class="text-center"><?= $total ?></td>
                  <td class="text-center"><?= $retur->status == 15 ? $total_a : 'Belum' ?></td>
                </tr>
              </tbody>
            </table>
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
            <?php if ($retur->status == 10) { ?>
              <form action="<?= base_url('sup/Toko/tindakan') ?>" method="post" id="form_approve">
                <div class="form-group">
                  <label for="">Tgl Jemput</label>
                  <input type="date" name="tgl_jemput" class="form-control form-control-sm" value="<?= date('Y-m-d', strtotime($retur->tgl_jemput)) ?>" required>
                </div>
                <strong>Catatan MV:</strong>
                <textarea name="catatan_mv" rows="3" class="form-control form-control-sm" required></textarea>
                <input type="hidden" name="id_retur" value="<?= $retur->id ?>">
                <input type="hidden" name="id_toko" value="<?= $retur->id_toko ?>">
                <input type="hidden" name="pembuat" value="<?= $retur->id_user ?>">
                <small>* harus di isi.</small>
                <div class="form-group">
                  <label for="">Tindakan</label>
                  <select name="tindakan" id="tindakan" class="form-control form-control-sm" required>
                    <option value="">Pilih</option>
                    <option value="1">Setuju</option>
                    <option value="5">Tolak</option>
                  </select>
                </div>
                <hr>
                <div class="text-right">
                  <button type="submit" class="btn btn-sm btn-primary btn_simpan"><i class="fas fa-save"></i> Simpan</button>
                  <a href="<?= base_url('sup/Toko/toko_tutup') ?>" class="btn btn-sm btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
              </form>
              <hr>
            <?php } else { ?>
              <div class="row no-print">
                <div class="col-12">
                  <a href="<?= base_url('sup/Toko/toko_tutup') ?>" class="btn btn-sm btn-danger float-right" style="margin-right: 5px;">
                    <i class="fas fa-arrow-left"></i> Kembali </a>
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

    function printDiv(divName) {
      var printContents = document.getElementById(divName).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
    }
  });
</script>
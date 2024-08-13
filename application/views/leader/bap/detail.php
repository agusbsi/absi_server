<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="callout callout-info">
          <h5><i class="fas fa-info"></i> BAP :</h5>
          <div class="row">
            <div class="col-md-3">
              <strong>No Kirim : </strong> <br>
              <?= $bap->id_kirim ?>
            </div>
            <div class="col-md-4">
              <strong>Toko : </strong> <br>
              <small><?= $bap->nama_toko ?></small>
            </div>
            <div class="col-md-3">
              <strong>Status : </strong> <br>
              <small><?= status_bap($bap->status) ?></small>
            </div>
            <div class="col-md-2">
              <strong>Tanggal : </strong> <br>
              <small><?= date('d F Y', strtotime($bap->created_at)) ?></small>
            </div>
          </div>
        </div>
        <div id="printableArea">
          <div class="invoice p-3 mb-3">
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr class="text-center">
                      <th rowspan="2">No</th>
                      <th rowspan="2" class="text-left">Artikel</th>
                      <th colspan="3">QTY</th>
                      <th rowspan="2" class="text-left">Kategori & Catatan</th>
                    </tr>
                    <tr class="text-center">
                      <th>Di kirim</th>
                      <th>Di Terima</th>
                      <th>Di Update</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 0;
                    $total = 0;
                    foreach ($detail_bap as $d) {
                      $no++;
                    ?>
                      <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td>
                          <small>
                            <strong><?= $d->kode_produk ?></strong><br>
                            <?= $d->nama_produk ?>
                          </small>
                        </td>
                        <td class="text-center"><?= $d->qty_kirim ?></td>
                        <td class="text-center"><?= $d->qty_awal ?></td>
                        <td class="text-center"><?= $d->qty_update ?></td>
                        <td>
                          <small>
                            <strong>[ <?= $d->kategori ?> ]</strong><br>
                            <?= $d->catatan ?>
                          </small>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <hr>
            <form action="<?= base_url('leader/Bap/simpan') ?>" method="post" id="form_bap">
              <input type="hidden" name="id_bap" value="<?= $bap->id ?>">
              <?php if ($bap->status == 0) { ?>
                <div class="form-group">
                  <label for="Catatan Leader:">Catatan Leader : *</label>
                  <textarea name="catatan_leader" class="form-control form-control-sm" placeholder="Masukan catatan ....." required></textarea>
                </div>
                <div class="form-group">
                  <label for="tindakan">Tindakan : *</label>
                  <select name="tindakan" class="form-control form-control-sm select2" required>
                    <option value=""> Pilih </option>
                    <option value="1"> Setuju </option>
                    <option value="4"> Tolak</option>
                  </select>
                </div>
              <?php } else { ?>
                <div class="form-group">
                  <label for="Catatan Leader:">Catatan Leader :</label>
                  <textarea class="form-control form-control-sm" readonly><?= $bap->catatan_leader ?></textarea>
                </div>
                <?php if (!empty($bap->catatan_mv)) { ?>
                  <div class="form-group">
                    <label for="Catatan Leader:">Catatan MV :</label>
                    <textarea class="form-control form-control-sm" readonly><?= $bap->catatan_mv ?></textarea>
                  </div>
                <?php } ?>
              <?php } ?>
              <hr>
              <div class="row no-print">
                <div class="col-12">
                  <?php if ($bap->status == 0) { ?>
                    <button type="submit" class="btn btn-sm btn-primary float-right" id="btn_kirim"><i class="fas fa-save"></i> Simpan</button>
                    <a href="<?= base_url('leader/Bap') ?>" class="btn btn-sm btn-danger float-right mr-2"> <i class="fas fa-times-circle"></i> Close</a>
                  <?php } else { ?>
                    <a href="<?= base_url('leader/Bap') ?>" class="btn btn-sm btn-danger float-right"> <i class="fas fa-times-circle"></i> Close</a>
                  <?php } ?>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  function validateForm() {
    let isValid = true;
    $('#form_bap').find('input[required], select[required], textarea[required]').each(function() {
      if ($(this).val() === '') {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });
    return isValid;
  }
  document.getElementById("btn_kirim").addEventListener("click", function(event) {
    event.preventDefault();

    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data Pengajuan BAP akan di proses",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        if (validateForm()) {
          document.getElementById("form_bap").submit();
        } else {
          Swal.fire({
            title: 'Belum lengkap',
            text: "Kolom Catatan dan Tindakan harus di isi.",
            icon: 'info',
          });
        }

      }
    })
  });
</script>
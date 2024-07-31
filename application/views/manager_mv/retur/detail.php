<style>
  .img-artikel {
    width: auto;
    height: 50px;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.3s ease-in-out;
  }

  .img-artikel:hover {
    transform: scale(5.5);
    border: 1px solid rgb(0, 123, 255);
  }
</style>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="callout callout-info">
          <div class="row">
            <div class="col-md-3">
              <h5> No: <?= $retur->id ?></h5>
              Status : <?= status_retur($retur->status) ?>
            </div>
            <div class="col-md-4">
              <strong><?= $retur->nama_toko; ?></strong><br>
              [ <?= $retur->spg ?> ]
            </div>
            <div class="col-md-2">
              <strong>Tanggal Dibuat :</strong><br>
              <?= date('d M Y', strtotime($retur->created_at)) ?>
            </div>
            <div class="col-md-3">
              <strong>Tanggal Penjemputan :</strong><br>
              <?= date('d M Y', strtotime($retur->tgl_jemput)) ?>
            </div>
          </div>
        </div>
        <div id="printableArea">
          <div class="invoice p-3 mb-3">
            <div class="row">
              <h4>
                <li class="fas fa-file-alt"></li> Detail
              </h4>
            </div>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Artikel</th>
                  <th>Satuan</th>
                  <th>QTY</th>
                  <th>Foto</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                $total = 0;
                foreach ($detail_retur as $d) {
                  $no++;
                ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td>
                      <small>
                        <strong><?= $d->kode_produk ?></strong> <br>
                        <?= $d->nama_produk ?>
                      </small>
                    </td>
                    <td><?= $d->satuan ?></td>
                    <td><?= $d->qty ?></td>
                    <td>
                      <img class="img-artikel" src="<?= base_url('assets/img/retur/' . $d->foto) ?>" alt="retur">
                    </td>
                    <td>
                      <small>
                        <strong><?= $d->keterangan ?></strong> <br>
                        <?= $d->catatan ?>
                      </small>
                    </td>
                  </tr>
                <?php
                  $total += $d->qty;
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3" align="right"> <strong>Total</strong> </td>
                  <td><?= $total; ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
            <a href="<?= base_url('assets/img/retur/lampiran/' . $retur->lampiran) ?>" target="_blank" class="btn btn-sm btn-warning <?= empty($retur->lampiran) ? 'd-none' : '' ?>"><i class="fas fa-download"></i> Lampiran </a>
            <a href="<?= base_url('assets/img/retur/lampiran/' . $retur->foto_packing) ?>" target="_blank" class="btn btn-sm btn-warning <?= empty($retur->foto_packing) ? 'd-none' : '' ?>"><i class="fas fa-download"></i> Foto packing </a>
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
            <?php if ($retur->status == 2) { ?>
              <form action="<?= base_url('sup/Retur/tindakan') ?>" method="post" id="form_approve">
                <div class="form-group">
                  <label for="">Tgl Jemput</label>
                  <input type="date" name="tgl_jemput" class="form-control form-control-sm" value="<?= date('Y-m-d', strtotime($retur->tgl_jemput)) ?>" required>
                </div>
                <strong>Catatan MV:</strong>
                <textarea name="catatan_mv" rows="3" class="form-control form-control-sm" required></textarea>
                <input type="hidden" name="id_retur" value="<?= $retur->id ?>">
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
                  <a href="<?= base_url('sup/Retur') ?>" class="btn btn-sm btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
              </form>
              <hr>
            <?php } else { ?>
              <div class="row no-print">
                <div class="col-12">
                  <a href="<?= base_url('sup/Retur') ?>" class="btn btn-sm btn-danger float-right" style="margin-right: 5px;">
                    <i class="fas fa-arrow-left"></i> Kembali </a>
                  <a class="btn btn-default btn-sm float-right mr-2 <?= $retur->status == 2 || $retur->status == 3 ? '' : 'disabled' ?>" target="_blank" href="<?= base_url('sup/retur/sppr/' . $retur->id) ?>"><i class="fas fa-print"></i> Sppr</a>
                </div>
              </div>
            <?php } ?>
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
        text: "Data Pengajuan Retur akan di proses",
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
<section class="content">
  <div class="container-fluid">
    <form action="<?= base_url('sup/Pengiriman/approve') ?>" method="post" id="form_kirim">
      <div class="callout callout-info">
        <strong>Status : </strong><?= status_pengiriman($pengiriman->status) ?>
      </div>
      <div class="callout callout-info">
        <div class="row">
          <div class="col-lg-2">
            <div class="form-group">
              <label for="">No Kirim :</label>
              <input type="text" class="form-control form-control-sm" name="id_kirim" value="<?= $pengiriman->id; ?>" readonly>
            </div>
          </div>
          <div class="col-lg-2">
            <div class="form-group">
              <label for="">No PO :</label>
              <input type="text" class="form-control form-control-sm" name="id_po" value="<?= $pengiriman->id_permintaan; ?>" readonly>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="">Toko :</label> <br>
              <small><?= $pengiriman->nama_toko; ?></small>
            </div>
          </div>
          <div class="col-lg-2">
            <div class="form-group">
              <label for="">SPG :</label> <br>
              <small><?= $pengiriman->spg; ?></small>
            </div>
          </div>
          <div class="col-lg-2">
            <div class="form-group">
              <label for="">Tanggal :</label> <br>
              <small><?= date("d F Y, H:i:s", strtotime($pengiriman->created_at))  ?></small>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header">List Artikel</div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr class="text-center">
                <th rowspan="2">No</th>
                <th rowspan="2">Artikel</th>
                <th colspan="2">Jumlah</th>
                <th rowspan="2">Catatan</th>
              </tr>
              <tr class="text-center">
                <th>Kirim</th>
                <th>Terima</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              $total = 0;
              $terima = 0;
              $gt = 0;
              foreach ($detail as $d) {
                $no++;
                if ($d->het != 1) {
                  $hrg_produk = $d->het_indobarat;
                } else {
                  $hrg_produk = $d->het_jawa;
                }
              ?>
                <tr>
                  <td class="text-center"><?= $no ?></td>
                  <td>
                    <small>
                      <strong><?= $d->kode ?></strong> <br>
                      <?= $d->nama_produk ?>
                    </small>
                  </td>
                  <td class="text-center"><?= $d->qty ?></td>
                  <td class="text-center <?= (($d->qty != $d->qty_diterima) && $pengiriman->status >= 1) ? 'bg-danger' : '' ?>"><?= $pengiriman->status <= 1 ? '<small>belum diterima</small>' : $d->qty_diterima ?></td>
                  <td><?= $d->catatan ?></td>
                </tr>
              <?php
                $total += $d->qty;
                $terima += $d->qty_diterima;
              }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="2" align="right"> <strong>Total</strong> </td>
                <td class="text-right"><b><?= $total; ?></b></td>
                <td class="text-right"><b><?= $terima; ?></b></td>
                <td></td>
              </tr>
            </tfoot>
          </table>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <strong>Catatan Gudang :</strong> <br>
                <textarea class="form-control form-control-sm" readonly><?= $pengiriman->keterangan ?></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <strong>Dibuat oleh</strong> <br>
                <input type="text" name="pembuat" class="form-control form-control-sm" value="<?= $pengiriman->nama_user ?>" readonly>
              </div>
            </div>
          </div>
          <div class="form-group">
            <strong>Catatan Anda :</strong> <br>
            <textarea name="catatan" class="form-control form-control-sm"></textarea>
            <small>* Jika ada</small>
          </div>
        </div>
        <div class="card-footer">
          <a href="<?= base_url('sup/Pengiriman') ?>" class="btn btn-sm btn-danger float-right"><i class="fas fa-times-circle"></i> Tutup</a>
          <button type="submit" class="btn btn-sm btn-success float-right btn_approve mr-1 <?= ($pengiriman->status != 0) ? 'd-none' : '' ?>"><i class="fas fa-save"></i> Approve</button>
        </div>
      </div>
    </form>
  </div>
</section>
<script>
  $(document).ready(function() {
    function validateForm() {
      let isValid = true;
      // Get all required input fields
      $('#form_kirim').find('input[required], select[required], textarea[required]').each(function() {
        if ($(this).val() === '') {
          isValid = false;
          $(this).addClass('is-invalid');
        } else {
          $(this).removeClass('is-invalid');
        }
      });
      return isValid;
    }
    $('.btn_approve').click(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data Pengiriman Barang akan di proses",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Yakin'
      }).then((result) => {
        if (result.isConfirmed) {

          if (validateForm()) {
            document.getElementById("form_kirim").submit();
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

  });
</script>
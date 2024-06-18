<section class="content">
  <div class="container-fluid">
    <div class="col-md-12">
      <!-- Master -->
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">
            <li class="fas fa-box"></li> <strong>Data Mutasi</strong>
          </h3>
        </div>
        <form action="<?= base_url('spg/Mutasi/terima') ?>" method="post" id="form_mutasi">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>No Mutasi :</label>
                  <input type="text" class="form-control form-control-sm id_mutasi" name="id_mutasi" value="<?= $mutasi->id ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Tanggal :</label>
                  <input type="text" class="form-control form-control-sm" name="tgl_mutasi" value="<?= $mutasi->created_at ?>" readonly>
                </div>
                <!-- /.form-group -->
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Toko Asal :</label>
                  <input type="text" class="form-control form-control-sm" value="<?= $mutasi->asal ?>" readonly>
                  <input type="hidden" name="id_toko_asal" value="<?= $mutasi->toko_asal ?>">
                </div>
                <div class="form-group">
                  <label>Toko tujuan :</label>
                  <input type="text" class="form-control form-control-sm" value="<?= $mutasi->tujuan ?>" readonly>
                </div>
                <!-- /.form-group -->
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Diajukan Oleh :</label>
                  <br>
                  [ <?= $mutasi->leader ?> ]
                </div>
                <br>
                <div class="form-group">
                  <label>Status :</label>
                  <br>
                  <?= status_mutasi($mutasi->status) ?>
                </div>
                <!-- /.form-group -->
              </div>
            </div>
            <hr>
            <table id="example1" class="table table-striped">
              <thead>
                <tr class="text-center">
                  <th rowspan="2">No</th>
                  <th rowspan="2">Artikel</th>
                  <th colspan="2">Jumlah</th>
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
                foreach ($detail_mutasi as $d) {
                  $no++;
                ?>
                  <tr>
                    <td class="text-center">
                      <?= $no ?>
                    </td>
                    <td>
                      <small>
                        <strong><?= $d->kode ?></strong> <br>
                        <?= $d->nama_produk ?>
                      </small>
                      <input type="hidden" name="id_produk[]" value="<?= $d->id_produk ?>">
                    </td>
                    <td class="text-center">
                      <?= $d->qty ?>
                      <input type="hidden" name="qty[]" value="<?= $d->qty ?>">
                    </td>
                    <td>
                      <input type="number" class="form-control form-control-sm" name="qty_terima[]" min="0" max="<?= $d->qty ?>" required>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-sm btn-success btn_terima float-right"> <i class="fas fa-save"></i> Terima</button>
            <a href="<?= base_url('spg/Mutasi') ?>" class="btn btn-sm btn-danger mr-2  float-right"> <i class="fas fa-times-circle"></i> Close</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function() {
    function validateForm() {
      let isValid = true;
      // Get all required input fields
      $('#form_mutasi').find('input[required], select[required], textarea[required]').each(function() {
        if ($(this).val() === '') {
          isValid = false;
          $(this).addClass('is-invalid');
        } else {
          $(this).removeClass('is-invalid');
        }
      });
      return isValid;
    }
    $('.btn_terima').click(function(e) {
      e.preventDefault();
      if (validateForm()) {
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Data Terima barang mutasi akan di simpan",
          icon: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Batal',
          confirmButtonText: 'Yakin'
        }).then((result) => {
          if (result.isConfirmed) {
            $('#form_mutasi').submit(); // Ini untuk submit form setelah konfirmasi
          }
        })
      } else {
        Swal.fire(
          'BELUM LENGKAP',
          'Lengkapi semua kolom.',
          'info'
        );
      }
    });

    // ketika qty terima di ganti
    $('input[name="qty_terima[]"]').keyup(function() {
      var qty_terima = $(this).val();
      var qty_terima_max = $(this).attr('max');
      if (parseInt(qty_terima) > parseInt(qty_terima_max)) {
        // menampilkan pesan eror
        Swal.fire(
          'Melebihi jumlah Mutasi',
          'Pastikan input jumlah yang sesuai dan tidak melebihi jumlah Mutasi',
          'info'
        )
        $(this).val(qty_terima_max);
      }
      // menjumlahkan semua qty_terima yang di input
      var qty_terima_sum = 0;
      $('input[name="qty_terima[]"]').each(function() {
        qty_terima_sum += parseInt($(this).val());
      });
      // menampilkan jumlah qty_terima ke id total_terima html
      $('#total_terima').html(qty_terima_sum);

    });
  });
</script>
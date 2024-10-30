<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <form action="<?= base_url('spg/Penerimaan/terima_barang') ?>" method="post" id="form_terima">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">
                <li class="fas fa-check-circle"></li> Penerimaan Barang
              </h3>
              <input type="hidden" name="id_kirim" value="<?= $terima->id ?>">
              <input type="hidden" name="id_toko" value="<?= $terima->id_toko ?>">
              <input type="hidden" name="unique_id" value="<?= uniqid() ?>">
              <div class="card-tools">
                <a href="<?= base_url('spg/Penerimaan') ?>" type="button" class="btn btn-tool">
                  <i class="fas fa-times"></i>
                </a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">No Kirim</label>
                    <input type="text" class="form-control form-control-sm" value="<?= $terima->id ?>" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">No PO</label>
                    <input type="text" name="id_po" class="form-control form-control-sm" value="<?= $terima->id_permintaan ?>" readonly>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="">Keterangan</label>
                <textarea class="form-control form-control-sm" readonly><?= $terima->keterangan ?></textarea>
              </div>
              <hr>
              List Artikel
              <hr>
              <table class="table table-bordered table-striped table responsive">
                <thead>
                  <tr class="text-center">
                    <th style="width: 10%;">No</th>
                    <th style="width: 50%;">Artikel</th>
                    <th>Jumlah</th>
                  </tr>
                </thead>
                <?php
                $no = 0;
                foreach ($detail as $d) :
                  $no++ ?>
                  <tr class="baris">
                    <td class="text-center"><?= $no ?></td>
                    <td>
                      <small>
                        <strong><?= $d->kode ?></strong> <br>
                        <?= $d->nama_produk ?>
                      </small>
                      <input type="hidden" name="id_produk[]" value="<?= $d->id_produk ?>">
                      <input type="hidden" name="id_detail[]" value="<?= $d->id ?>">
                    </td>
                    <td class="text-center">
                      <input type="number" class="form-control form-control-sm" name="qty_terima[]" min="0" required>
                      <input type="hidden" class="form-control form-control-sm" name="qty[]" value="<?= $d->qty ?>">
                    </td>
                  </tr>
                <?php endforeach ?>
              </table>
              <div class="form-group">
                <label for="">Catatan :</label>
                <textarea name="catatan" class="form-control form-control-sm" placeholder="Catatan anda jika ada..."></textarea>
              </div>
              <hr>
              <small># Pastikan anda sudah mengisi data dengan benar.</small>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-sm btn-success float-right btn_terima"><i class="fas fa-save"></i> Terima</button>
              <a href="<?= base_url('spg/Penerimaan') ?>" class="btn btn-sm btn-danger float-right mr-2"><i class="fas fa-times-circle"></i> Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function() {
    // table
    $('#table_terima').DataTable({
      order: [
        [0, 'asc']
      ],
      responsive: true,
      lengthChange: false,
      autoWidth: false,
    });

    function validateForm() {
      let isValid = true;
      // Get all required input fields
      $('#form_terima').find('input[required], select[required], textarea[required]').each(function() {
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
          title: 'Apakah anda yakin ?',
          text: "Pastikan data yang di input sudah benar.",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Batal',
          confirmButtonText: 'Yakin'
        }).then((result) => {
          if (result.isConfirmed) {
            $('#form_terima').submit();
            $('.btn_terima').prop('disabled', true);
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

  });
</script>
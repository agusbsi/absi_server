<style>
  .product-card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgb(109, 112, 129, 0.4);
    overflow: hidden;
    width: 100%;
    margin-bottom: 5px;
    border: 1px solid rgb(0, 123, 255);
  }

  .product-header {
    padding: 8px;
    background-color: rgb(0, 123, 255);
    display: flex;
    align-items: center;
  }

  .product-number {
    background-color: white;
    color: #007BFF;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: bold;
    margin-right: 12px;
  }

  .product-code {
    font-size: 16px;
    color: white;
  }

  .product-details {
    color: #343A40;
    padding: 8px;
  }

  .product-name {
    font-size: 13px;
    margin-bottom: 7px;
  }

  .product-quantity {
    display: flex;
    font-size: 13px;
    justify-content: space-between;
  }

  .quantity-input {
    background-color: white;
    border: 1px solid #6D7081;
    padding: 4px 8px;
    border-radius: 10px;
    width: 80px;
  }
</style>
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
                  <input type="hidden" name="unique_id" value="<?= $unique_id ?>">
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
            <?php
            $no = 0;
            $total = 0;
            foreach ($detail_mutasi as $d) {
              $no++;
            ?>
              <div class="product-card">
                <div class="product-header">
                  <div class="product-number"><?= $no ?></div>
                  <div class="product-code"><?= $d->kode ?></div>
                </div>
                <div class="product-details">
                  <div class="product-name"><?= $d->nama_produk ?></div>
                  <div class="product-quantity">
                    <div>
                      <span>Qty Kirim :</span>
                      <p><?= $d->qty ?></p>
                    </div>
                    <div>
                      <span>Qty Terima :</span> <br>
                      <input type="hidden" name="id_produk[]" value="<?= $d->id_produk ?>">
                      <input type="hidden" name="qty[]" value="<?= $d->qty ?>">
                      <input type="number" class="form-control form-control-sm quantity-input" name="qty_terima[]" min="0" max="<?= $d->qty ?>" required>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
            <hr>
            <div class="form-group">
              <label for="tgl_terima">Tgl Penerimaan : *</label>
              <input type="date" name="tgl_terima" id="tgl_terima" class="form-control form-control-sm" required>
              <small>* Wajib di isi.</small>
            </div>
            <div class="form-group">
              <label for="">Catatan :</label>
              <textarea name="catatan" class="form-control form-control-sm" placeholder="catatan jika ada.."></textarea>
            </div>
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
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
    <div class="col-12">
      <!-- isi konten -->
      <form action="<?php echo base_url('adm_gudang/Retur/terimBarang') ?>" method="post" id="form_retur">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">
              <li class="fas fa-exchange-alt"></li> Detail
            </h3>
            <input type="hidden" name="id_retur" value="<?= $retur->id ?>">
            <input type="hidden" name="id_toko" value="<?= $retur->id_toko ?>">
            <div class="card-tools">
              <a href="<?= base_url('adm_gudang/Retur') ?>" type="button" class="btn btn-tool">
                <i class="fas fa-times"></i>
              </a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <hr>
            <h5 class="text-center">RETUR TUTUP TOKO</h5>
            <hr>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">No Retur :</label>
                  <input type="text" value="<?= $retur->id ?>" class="form-control form-control-sm" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Toko:</label>
                  <input type="text" value="<?= $retur->nama_toko ?>" class="form-control form-control-sm" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">Tgl dibuat:</label>
                  <input type="text" value="<?= date('d-M-Y', strtotime($retur->created_at)) ?>" class="form-control form-control-sm" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">Tgl Dijemput:</label>
                  <input type="text" value="<?= date('d-M-Y', strtotime($retur->tgl_jemput)) ?>" class="form-control form-control-sm" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Status:</label> <br>
                  <?= status_retur($retur->status) ?>
                </div>
              </div>
            </div>
            <hr>
            <b># List Aset :</b>
            <table class="table responsive">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th>Kode</th>
                  <th>Aset</th>
                  <th>Jumlah</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($aset as $aa) :
                  $no++;
                ?>
                  <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td>
                      <small>
                        <?= $aa->kode ?>
                      </small>
                    </td>
                    <td><?= $aa->aset ?></td>
                    <td><?= $aa->qty ?></td>
                    <td><?= $aa->keterangan ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
            <hr>
            <b># List Artikel :</b>
            <table class="table responsive table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th rowspan="2" style="width:5%">No</th>
                  <th rowspan="2">Artikel</th>
                  <th rowspan="2" style="width:5%">Satuan</th>
                  <th colspan="2">Jumlah</th>
                </tr>
                <tr class="text-center">
                  <th>Retur</th>
                  <th>Terima</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $no = 0;
                $total_qty = 0;
                $total_terima = 0;
                foreach ($detail_retur as $d) {
                  $no++;

                ?>
                  <tr>
                    <td class="text text-center"><?= $no ?></td>
                    <td>
                      <small>
                        <strong><?= $d->kode ?> </strong> <br>
                        <?= $d->nama_produk ?>
                      </small>
                      <input type="hidden" name="id_produk[]" value="<?= $d->id_produk ?>">
                    </td>
                    <td><small><?= $d->satuan ?></small></td>
                    <td class="text-center"><?= $d->qty ?></td>
                    <td><input type="number" name="qty_input[]" class="form-control form-control-sm qty_input" min="0" value="<?= $d->qty ?>" max="<?= $d->qty ?>" required></td>

                  </tr>
                <?php
                  $total_qty += $d->qty;
                }
                ?>

              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3" class="text-right">Total :</td>
                  <td class="text-center"> <strong><?= $total_qty ?></strong> </td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
            <hr>
            <div class="form-group">
              <label for="">Catatan : *</label>
              <textarea name="catatan" class="form-control form-control-sm" placeholder="Berikan catatan disini..." required></textarea>
              <small>* Wajib di isi.</small>
            </div>
            <div class="form-group">
              <label for="tgl_terima">Tanggal Penerimaan : *</label>
              <input type="date" name="tgl_terima" id="tgl_terima" class="form-control form-control-sm" required>
              <small>* Wajib di isi.</small>
            </div>
            <hr>
            <li class="fas fa-info"></li> Reminder : Proses retur ini akan mempengaruhi jumlah stok di toko : <strong><?= $retur->nama_toko ?></strong> !

          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button type='submit' class='btn btn-success btn-sm float-right btn_terima'><i class='fa fa-save'></i> Terima Barang</button>
            <a href="<?= base_url('adm_gudang/Retur') ?>" class="btn btn-danger btn-sm float-right mr-3"><i class="fas fa-times-circle"></i> Close</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<script>
  function validateForm() {
    let isValid = true;
    // Get all required input fields
    $('#form_retur').find('input[required], select[required], textarea[required]').each(function() {
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
        text: "Data Terima barang akan di simpan",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Yakin'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#form_retur').submit(); // Ini untuk submit form setelah konfirmasi
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
  $(function() {
    $('.btn-foto').on('click', function() {
      $('.image').attr('src', $(this).attr('src'));
      $('.id_produk').html($(this).data('id_produk'));
      $('#lihat-foto').modal('show');
    });
  });

  //  ketika qty input di ketik
  $('.qty_input').keyup(function() {
    var qty = $('#qty').val();
    var maks = $(this).attr('max');
    if ($(this).val() > maks) {
      Swal.fire('Info', 'Qty tidak boleh melebihi jumlah yang di kirim', 'info');
      $(this).val(maks);
    }
  });
</script>
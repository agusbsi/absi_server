<section class="content">
  <div class="container-fluid">
    <div class="col-12">
      <!-- isi konten -->
      <form action="<?php echo base_url('adm_gudang/Retur/terima_barang') ?>" method="post" id="form_retur">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">
              <li class="fas fa-exchange-alt"></li> Detail retur
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
            <div class="row">
              <div class="col-md-3">
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
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Tanggal:</label>
                  <input type="text" value="<?= date('d-M-Y', strtotime($retur->created_at)) ?>" class="form-control form-control-sm" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Status:</label> <br>
                  <?= status_retur($retur->status) ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Catatan MV :</label>
                  <textarea class="form-control" readonly><?= $retur->catatan_mv ?></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Alamat :</label>
                  <textarea class="form-control" readonly><?= $retur->alamat ?></textarea>
                </div>
              </div>
            </div>
            <hr>
            <table class="table responsive table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th rowspan="2" style="width:5%">#</th>
                  <th rowspan="2">Artikel</th>
                  <th rowspan="2" style="width:5%">Satuan</th>
                  <th colspan="2">Jumlah</th>
                  <th rowspan="2" style="width:15%">Catatan</th>
                  <th rowspan="2" style="width:10%">Berkas</th>
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
                    <td>
                      <textarea name="catatan[]" class="form-control form-control-sm" rows="1" placeholder="Jika ada..."></textarea>
                    </td>

                    <td>
                      <a type="button" class="btn btn-outline-primary btn-foto btn-sm" data-id_produk="<?= $d->kode ?>" src="<?= base_url('assets/img/retur/' . $d->foto) ?>"><i class="fas fa-eye"></i> Lihat</a>
                    </td>
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
                  <td></td>
                </tr>
              </tfoot>
            </table>
            <hr>
            <li class="fas fa-info"></li> Reminder : Proses retur ini akan mempengaruhi jumlah stok di toko : <strong><?= $retur->nama_toko ?></strong> !

          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button type='submit' class='btn btn-success btn-sm float-right btn_terima'><i class='fa fa-save'></i> Terima Barang</button>
            <button type="button" class="btn btn-warning btn-sm float-right mr-3 <?= ($retur->status == 3) ? '' : 'd-none' ?>" data-toggle="modal" data-target="#lihat-resi" data-kode="<?= $retur->id ?>"><i class="fas fa-eye"></i> Lihat Resi</button>
            <a href="<?= base_url('adm_gudang/Retur') ?>" class="btn btn-danger btn-sm float-right mr-3"><i class="fas fa-times-circle"></i> Close</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<!-- modal lihat resi -->
<div class="modal fade" id="lihat-resi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title judul">
          <li class="fas fa-file"></li> Berkas RESI : <?= $retur->no_resi ?>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <img class="img-rounded" style="width: 100%" src="<?= base_url('assets/img/retur/resi/' . $retur->foto_resi) ?>" alt="User Image">
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
<!-- end modal -->
<!-- modal lihat foto -->
<div class="modal fade" id="lihat-foto">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title judul">
          <li class="fas fa-box"></li> Berkas Produk : <a href="#" class="id_produk"></a>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <img class="img-rounded image" id="image" style="width: 100%" src="" alt="User Image">
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
<!-- end modal -->
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
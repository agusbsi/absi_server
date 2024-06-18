<section class="content">
  <div class="container-fluid">
    <div id="printableArea">
      <div class="row">
        <div class="col-md-12">
          <div class="callout callout-info">
            <h5>MUTASI BARANG</h5>
            <div class="row">
              <div class="col-md-4">
                <b>No :</b> <?= $mutasi->id; ?>
                <br>
                <small><b>Status : </b><?= status_mutasi($mutasi->status) ?></small>
              </div>
              <div class="col-md-4">
                <b>Toko Asal :</b> <?= $mutasi->asal ?> <br>
                <b>Toko Tujuan :</b> <?= $mutasi->tujuan ?></strong>
              </div>
              <div class="col-md-4">
                <b>Tanggal :</b> <?= date("d F Y, H:i:s", strtotime($mutasi->created_at));  ?> <br>
                <strong></strong>

              </div>
            </div>
          </div>

          <!-- print area -->
          <form action="<?= base_url('leader/Mutasi/updatebap') ?>" method="POST">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <h4>
                  <li class="fas fa-file-alt"></li> Detail Barang
                </h4>
              </div>

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive ">
                  <table class="table table-striped ">
                    <thead>
                      <tr>
                        <th class="text-center">No</th>
                        <th>Kode Artikel #</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Tersedia</th>
                        <th class="text-center" style="width: 10%;">Perbaikan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($detail as $no => $d) :
                      ?>
                        <tr>
                          <td class="text-center"><?= ++$no ?></td>
                          <td><?= $d->kode ?></td>
                          <td><small><?= $d->nama_produk ?></small></td>
                          <td class="text-center"><?= $d->qty ?></td>
                          <td class="text-center text-danger"> Max : <?= $d->stok ?> </td>
                          <td class="text-center">
                            <input type="hidden" name="id_detail[]" value="<?= $d->id ?>">
                            <input type="hidden" name="id_mutasi" value="<?= $d->id_mutasi ?>">
                            <input type="number" name="qty_update[]" value="<?= $d->qty ?>" max="<?= $d->stok ?>" class="form-control form-control-sm" required>
                          </td>
                        </tr>
                      <?php
                      endforeach;
                      ?>
                    </tbody>

                    <tfoot>
                      <tr>
                        <td colspan="6" class="text-right"><button type="button" class="btn btn-success btn-sm " data-toggle="modal" data-target="#formTambah"><i class="fas fa-plus"></i> Tambah Artikel</button></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="col-12">
                # Info : Proses ini akan memperbarui jumlah barang sesuai dengan nilai di kolom perbaikan.
                <div class="form-group">
                  <label for="">Catatan :</label>
                  <textarea name="catatan" rows="3" class="form-control form-control-sm" required></textarea>
                </div>
              </div>
              <!-- /.row -->
              <hr>
              <div class="row no-print">
                <div class="col-12">
                  <a href="<?= base_url('leader/Mutasi') ?>" class="btn btn-danger btn-sm float-right"> <i class="fas fa-arrow-left"></i> Kembali</a>
                  <button type="submit" class="btn btn-sm btn-primary float-right mr-2"><i class="fa fa-save"></i> Simpan & Ajukan</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- end print area -->

        <!-- /.invoice -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<div class="modal fade" id="formTambah" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Artikel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('leader/Mutasi/tambah_item') ?>" method="POST">
          <div class="form-group">
            <label>Pilih Artikel</label>
            <select name="id_produk" id="pilih_produk" class="form-control select2bs4" required>
              <option>-- Pilih Produk --</option>
              <?php foreach ($list_produk as $lp) { ?>
                <option value="<?= $lp->id_produk ?>" data-stok="<?= $lp->qty ?>" data-satuan="<?= $lp->satuan ?>"><?= $lp->kode ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Stok di toko</label>
            <input type="text" id="stok" class="form-control form-control-sm" disabled>
          </div>
          <div class="form-group">
            <label>Satuan</label>
            <input type="text" id="satuan" class="form-control form-control-sm" disabled>
            <input type="hidden" name="id_mutasi" value="<?= $mutasi->id ?>" class="form-control form-control-sm">
            <input type="hidden" name="halaman" value="bap" class="form-control form-control-sm">
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success btn-sm">Tambah</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  }
</script>
<script>
  function goBack() {
    window.history.back();
  }
</script>
<script>
  $('input[name="qty_update[]"]').on('keydown keyup change', function() {
    var input = $(this).val();
    var stok = $(this).attr('max');
    if (parseInt(input) > parseInt(stok)) {
      Swal.fire(
        'Peringatan !',
        'Pastikan jumlah yang di Transfer tidak melebihi jumlah stok yang tersedia.',
        'info'
      )
      $(this).val(stok);
    }

  });

  $('#pilih_produk').change(function(e) {
    var stok = $(this).find(':selected').data('stok');
    var satuan = $(this).find(':selected').data('satuan');
    $('#stok').val(stok);
    $('#qty').attr('max', stok); // Mengatur atribut max pada input qty sesuai dengan stok
    $('#satuan').val(satuan);
  });

  $('#qty').on('input', function() {
    var stok = parseInt($('#stok').val());
    var qty = parseInt($(this).val());
    if (qty > stok) {
      $(this).val(stok); // Jika qty melebihi stok, maka nilai qty diatur menjadi stok
    }
  });
</script>
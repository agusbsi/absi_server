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
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th class="text-center">No</th>
                      <th>Kode Artikel #</th>
                      <th>Deskripsi</th>
                      <th class="text-center">Jumlah</th>
                      <th class="text-center">Tersedia</th>
                      <th class="text-center">Menu</th>
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
                          <button type="button" class="btn btn-sm btn-danger btn_hapus" data-id="<?= $d->id ?>" title="Hapus Barang"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                    <?php
                    endforeach;
                    ?>
                  </tbody>

                  <tfoot>
                    <tr>
                      <td colspan="6" class="text-right"><button type="button" class="btn btn-success btn-sm <?= $mutasi->status == 0 ? '' : 'd-none' ?>" data-toggle="modal" data-target="#formTambah"><i class="fas fa-plus"></i> Tambah Artikel</button></td>


                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-4">

              </div>
              <!-- /.col -->
              <div class="col-8">
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <hr>
            <div class="row no-print">
              <div class="col-12">
                <a href="<?= base_url('leader/Mutasi') ?>" class="btn btn-danger btn-sm float-right"> <i class="fas fa-arrow-left"></i> Kembali</a>

              </div>
            </div>
          </div>
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
          </div>
          <div class="form-group">
            <label>Qty</label>
            <input type="number" name="qty" id="qty" class="form-control form-control-sm" required>
            <input type="hidden" name="id_mutasi" value="<?= $mutasi->id ?>" class="form-control form-control-sm">
            <input type="hidden" name="halaman" value="edit" class="form-control form-control-sm">
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
  $('.btn_hapus').click(function(e) {
    var id = $(this).data('id');
    var tr = $(this).closest('tr');
    e.preventDefault();
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Barang ini akan dihapus dari list?",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url() ?>leader/Mutasi/hapus_item",
          method: "POST",
          data: {
            id: id
          },
          success: function(data) {
            tr.find('td').fadeOut(1000, function() {
              tr.remove();
            });
          }
        });
      }
    })
  })
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
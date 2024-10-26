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
          <form action="<?= base_url('mng_mkt/Mutasi/setujuiBap') ?>" method="POST">
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
                        <th class="text-center">Jml Kirim</th>
                        <th class="text-center">Jml Diterima</th>
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
                          <td class="text-center "> <?= $d->qty_terima ?> </td>
                          <td class="text-center">
                            <input type="hidden" name="id_produk[]" value="<?= $d->id_produk ?>">
                            <input type="hidden" name="id_mutasi" value="<?= $d->id_mutasi ?>">
                            <input type="hidden" name="toko_asal" value="<?= $mutasi->id_toko_asal ?>">
                            <input type="hidden" name="toko_tujuan" value="<?= $mutasi->id_toko_tujuan ?>">
                            <input type="hidden" name="qty_terima[]" value="<?= $d->qty_terima ?>">
                            <input type="number" name="qty_update[]" value="<?= $d->qty_update ?>" class="form-control form-control-sm" readonly>
                          </td>
                        </tr>
                      <?php
                      endforeach;
                      ?>
                    </tbody>


                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="col-12">
                # Info : Proses ini akan memperbarui jumlah barang sesuai dengan nilai di kolom perbaikan.
                <div class="form-group">
                  <label for="">Catatan :</label>
                  <textarea name="catatan" rows="3" class="form-control form-control-sm" readonly><?= $mutasi->catatan ?></textarea>
                </div>

              </div>
              <!-- /.row -->
              <hr>
              <div class="row no-print">
                <div class="col-12">
                  <a href="<?= base_url('mng_mkt/Mutasi') ?>" class="btn btn-danger btn-sm float-right"> <i class="fas fa-arrow-left"></i> Kembali</a>
                  <button id="btnSetujui" type="submit" class="btn btn-sm btn-success float-right mr-2"><i class="fa fa-save"></i> Simpan</button>
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
  // Menambahkan event click pada tombol
  document.getElementById("btnSetujui").addEventListener("click", function(event) {
    // Mencegah tindakan default dari tombol submit
    event.preventDefault();
    // Menampilkan SweetAlert untuk konfirmasi
    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Anda akan menyetujui tindakan ini!",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Setujui!'
    }).then((result) => {
      // Jika pengguna mengonfirmasi
      if (result.isConfirmed) {
        document.querySelector('form').submit();
      }
    });
  });
</script>
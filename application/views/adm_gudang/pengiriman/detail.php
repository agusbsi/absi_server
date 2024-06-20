<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="callout callout-info">
          <strong>Status : </strong><?= status_pengiriman($pengiriman->status) ?>
        </div>
        <div class="callout callout-info">
          <div class="row">
            <div class="col-lg-2">
              <div class="form-group">
                <label for="">No Kirim :</label>
                <input type="text" class="form-control form-control-sm" value="<?= $pengiriman->id; ?>" readonly>
              </div>
            </div>
            <div class="col-lg-2">
              <div class="form-group">
                <label for="">No PO :</label>
                <input type="text" class="form-control form-control-sm" value="<?= $pengiriman->id_permintaan; ?>" readonly>
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
        <div id="printableArea">
          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <div class="col-12 table-responsive">
              <table class="table table-bordered table-striped ">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Artikel #</th>
                    <th>Deskripsi </th>
                    <th>Satuan</th>
                    <th>Qty Kirim</th>
                    <th>Qty Diterima</th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  $total = 0;
                  $terima = 0;
                  foreach ($detail as $d) {
                    $no++;
                  ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td><small><strong><?= $d->kode ?></strong></small></td>
                      <td><small><?= $d->nama_produk ?></small></td>
                      <td class="text-center"> <?= $d->satuan ?> </td>
                      <td class="text-right"><?= $d->qty ?></td>
                      <td class="text-right <?= ($d->qty != $d->qty_diterima && $pengiriman->status != 1) ? 'bg-danger' : '' ?>"><?= $pengiriman->status <= 1 ? '<small>belum diterima</small>' : $d->qty_diterima ?></td>
                    </tr>
                  <?php
                    $total += $d->qty;
                    $terima += $d->qty_diterima;
                  }
                  ?>
                </tbody>
                <tfoot>
                  <tr>

                    <td colspan="4" align="right"> <strong>Total</strong> </td>
                    <td class="text-right"><b><?= $total; ?></b></td>
                    <td class="text-right"><b><?= $terima; ?></b></td>


                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.end table list isi -->
            <b>Noted:</b> Untuk Artikel yang jumlahnya = 0, maka secara otomatis tidak akan ditampilkan di list lagi.
            <!-- footer untuk TTD  -->
            <hr>
            <div class="row">
              <div class="col-md-6">
                <div class="from-group">
                  <label for="">Catatan :</label>
                  <textarea class="form-control form-control-sm" readonly> <?= $pengiriman->keterangan ?></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="from-group">
                  <label for="">Dibuat oleh :</label>
                  <input type="text" value="<?= $pengiriman->nama_user ?>" class="form-control form-control-sm" readonly>
                </div>
              </div>
            </div>
            <hr>
            <div class="row no-print">
              <div class="col-md-12">
                <a href="<?= base_url('adm_gudang/pengiriman') ?>" class="btn btn-danger btn-sm float-right"><i class="fas fa-times-circle"></i> Close </a>
                <a type="button" class="btn btn-default btn-sm float-right <?= ($pengiriman->status != "1") ? 'd-none' : ''; ?>" target="_blank" href="<?= base_url('adm_gudang/Pengiriman/detail_print/' . $pengiriman->id) ?>" style="margin-right: 5px;"><i class="fa fa-print" aria-hidden="true"></i> </a>
              </div>
            </div>

          </div>
          <!-- /.invoice -->
        </div>
        <!-- end print area -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


<script>
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  }
</script>
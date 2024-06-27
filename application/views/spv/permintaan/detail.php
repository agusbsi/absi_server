<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="callout callout-info">
          <h5><i class="fas fa-info"></i> Note:</h5>
          <div class="row">
            <div class="col-md-3">
              <small>
                <strong>Nomor :</strong> <br>
                <strong><?= $p->id ?> </strong>
              </small>
            </div>
            <div class="col-md-3">
              <small>
                <strong>Toko :</strong> <br>
                <strong><?= $p->nama_toko; ?></strong><br>
                <?= $p->spg ?>
              </small>
            </div>
            <div class="col-md-3">
              <small>
                <strong>Tanggal :</strong> <br>
                <?= date('d-M-Y H:i:s', strtotime($p->created_at)) ?>
              </small>
            </div>
            <div class="col-md-3">
              <small><strong>Status :</strong> <br></small>
              <?= status_permintaan($p->status) ?>
            </div>
          </div>
        </div>

        <!-- print area -->
        <div id="printableArea">
          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <h4>
                <li class="fas fa-file-alt"></li> Detail
              </h4>
            </div>
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>Kode #</th>
                      <th>Nama Artikel</th>
                      <th>Satuan</th>
                      <th>QTY (pcs)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 0;
                    $total = 0;
                    foreach ($detail_permintaan as $d) {
                      $no++;
                    ?>
                      <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td><small><?= $d->kode_produk ?></small></td>
                        <td><small><?= $d->nama_produk ?></small></td>
                        <td class="text-center"><small><?= $d->satuan ?></small></td>
                        <td class="text-center"><?= $d->qty ?></td>
                      </tr>
                    <?php
                      $total += $d->qty;
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>

                      <td colspan="4" align="right"> <strong>Total :</strong> </td>
                      <td class="text-center"><?= $total; ?></td>

                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            # Proses Pengajuan :
            <hr>
            <div class="timeline">
              <?php $no = 0;
              foreach ($histori as $h) :
                $no++;
              ?>
                <div>
                  <i class="fas bg-blue"><?= $no ?></i>
                  <div class="timeline-item">
                    <span class="time"></span>
                    <p class="timeline-header"><small><?= $h->aksi ?> <strong><?= $h->pembuat ?></strong></small></p>
                    <div class="timeline-body">
                      <small>
                        <?= date('d-M-Y  H:i:s', strtotime($h->tanggal)) ?> <br>
                        Catatan :<br>
                        <?= $h->catatan ?>
                      </small>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </div>
            <hr>

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a type="button" onclick="printDiv('printableArea')" target="_blank" class="btn btn-sm btn-default float-right">
                  <i class="fas fa-print"></i> Print </a>
                <a href="<?= base_url('spv/Permintaan') ?>" class="btn btn-sm btn-danger float-right mr-2"><i class="fas fa-times-circle"></i> Close </a>
              </div>
            </div>
          </div>
        </div>
        <!-- /.invoice -->
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
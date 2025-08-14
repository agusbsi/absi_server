<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="callout callout-info">
          <h5><i class="fas fa-store"></i> Nama Toko:</h5>
          <div class="row">
            <div class="col-md-3">
              <strong><?= $kirim->nama_toko; ?></strong>
            </div>
            <div class="col-md-3">
              Nomor : <strong><?= $kirim->id; ?></strong>
            </div>
            <div class="col-md-3">
              Tgl : <strong><?= date('d F Y', strtotime($kirim->created_at)) ?></strong>
            </div>
            <div class="col-md-3">
              <strong><?= status_retur($kirim->status) ?></strong>
            </div>
          </div>
        </div>

        <div id="printableArea">
          <div class="invoice p-3 mb-3">
            <div class="row">
              <h4>
                <li class="fas fa-file-alt"></li> Detail
              </h4>
            </div>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Artikel</th>
                  <th>Satuan</th>
                  <th>QTY</th>
                  <th>Diterima</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                $total = 0;
                $total_t = 0;
                foreach ($list_data as $d) {
                  $no++;
                ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td>
                      <small>
                        <strong><?= $d->kode ?></strong> <br>
                        <?= $d->nama_produk ?>
                      </small>
                    </td>
                    <td><?= $d->satuan ?></td>
                    <td><?= $d->qty ?></td>
                    <td><?= $kirim->status != 4 ? '-' : $d->qty_terima ?></td>
                    <td>
                      <small>
                        <strong><?= $d->keterangan ?></strong> <br>
                        <?= $d->catatan ?>
                      </small>
                    </td>
                  </tr>
                <?php
                  $total += $d->qty;
                  $total_t += $d->qty_terima;
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3" align="right"> <strong>Total</strong> </td>
                  <td><?= $total; ?></td>
                  <td><?= $kirim->status != 4 ? '-' : $total_t; ?></td>
                  <td></td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
            <hr>
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
                        <?= $h->catatan_h ?>
                      </small>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </div>
            <hr>
            <div class="col-12">
              <a href="<?= base_url('spv/Retur') ?>" class="btn btn-sm btn-danger" style="margin-right: 5px;">
                <i class="fas fa-arrow-left"></i> Kembali </a>
            </div>
          </div>
        </div>
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
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
                      <th>No</th>
                      <th>Kode Artikel #</th>
                      <th>Deskripsi</th>
                      <th class="text-center">Jml Kirim</th>
                      <th class="text-center">Jml Terima </th>
                      <th class="text-center">Selisih </th>
                      <th class="text-center">Perbaikan </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $total = $total_t =  $total_s = 0;
                    foreach ($detail as $no => $d) :
                    ?>
                      <tr>
                        <td class="text-center"><?= ++$no ?></td>
                        <td><?= $d->kode ?></td>
                        <td><small><?= $d->nama_produk ?></small></td>
                        <td class="text-center"><?= $d->qty ?></td>
                        <td class="text-center"><?= ($mutasi->status != 2) ? '<small>Belum diterima</small>' : $d->qty_terima ?></td>
                        <td class="text-center <?= ($d->qty != $d->qty_terima && $mutasi->status != 2) ? 'bg-warning' : '' ?>"><?= ($mutasi->status != 2) ? '<small>Belum diterima</small>' : $d->qty_terima - $d->qty ?></td>
                        <td class="text-center"><?= ($d->status == 2) ? $d->qty_update : '<small>Tidak ada</small>' ?></td>
                      </tr>
                    <?php
                      $total += $d->qty;
                      $total_t += $d->qty_terima;
                      $total_s += ($mutasi->status != 2) ? 0 : $d->qty_terima - $d->qty;
                    endforeach;
                    ?>
                  </tbody>

                  <tfoot>
                    <tr>

                      <td colspan="3" align="right"> <strong>Total :</strong> </td>
                      <td class="text-center"><strong><?= number_format($total); ?></strong></td>
                      <td class="text-center"><strong><?= ($mutasi->status <= 1) ? '<small>Belum diterima</small>' : number_format($total_t); ?></strong></td>
                      <td class="text-center"><strong><?= ($mutasi->status <= 1) ? '<small>Belum diterima</small>' : number_format($total_s); ?></strong></td>
                      <td class="text-center"></td>

                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <small># Info : <br> <b>Perbaikan :</b> <br> - merupakan jumlah yang di perbaiki oleh leader dan di setujui Marketing Verifikasi. <br>
              - Stok di Toko asal dan Tujuan akan disesuaikan dengan jumlah perbaikan.</small>
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
                        <?= $h->catatan ?>
                      </small>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </div>
            <hr>
            <div class="row no-print">
              <div class="col-12">
                <button onclick="goBack()" class="btn btn-danger btn-sm float-right"> <i class="fas fa-arrow-left"></i> Kembali</button>
                <a href="<?= base_url('leader/Mutasi/edit/' . $mutasi->id) ?>" class="btn btn-sm btn-warning float-right <?= ($mutasi->status == "0") ? '' : 'd-none'; ?>" title="Edit Mutasi" style="margin-right: 3px;"><i class="fa fa-edit"></i> Edit</a>
                <!-- <a href="<?= base_url('leader/Mutasi/bap/' . $mutasi->id) ?>" class="btn btn-sm btn-warning float-right <?= ($mutasi->status == "0" || $mutasi->status == "1" || $mutasi->status == "4" || $mutasi->status == "5") ? 'd-none' : ''; ?>" title="Ajukan Perbaikan Data Mutasi" style="margin-right: 3px;"><i class="fa fa-reply"></i> BAP</a> -->
                <a href="<?= base_url('leader/Mutasi/mutasi_print/' . $mutasi->id) ?>" target="_blank" class="btn btn-default btn-sm float-right <?= ($mutasi->status != "1") ? 'disabled' : ''; ?>" style="margin-right: 5px;">
                  <i class="fas fa-print"></i> Print </a>
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
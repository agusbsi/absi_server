<section class="content">
  <div class="container-fluid">
    <div class="callout callout-info">
      <strong>Status : </strong><?= status_pengiriman($pengiriman->status) ?>
    </div>
    <div class="callout callout-info">
      <div class="row">
        <div class="col-lg-2">
          <div class="form-group">
            <label for="">No Kirim :</label>
            <input type="text" class="form-control form-control-sm" name="id_kirim" value="<?= $pengiriman->id; ?>" readonly>
          </div>
        </div>
        <div class="col-lg-2">
          <div class="form-group">
            <label for="">No PO :</label>
            <input type="text" class="form-control form-control-sm" name="id_po" value="<?= $pengiriman->id_permintaan; ?>" readonly>
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
    <div class="card">
      <div class="card-header">List Artikel</div>
      <div class="card-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-center">
              <th rowspan="2">No</th>
              <th rowspan="2">Artikel</th>
              <th colspan="2">Jumlah</th>
              <th rowspan="2">Selisih</th>
            </tr>
            <tr class="text-center">
              <th>Kirim</th>
              <th>Terima</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            $total = 0;
            $terima = 0;
            $selisih = 0;
            foreach ($detail as $d) {
              $no++;
            ?>
              <tr>
                <td class="text-center"><?= $no ?></td>
                <td>
                  <small>
                    <strong><?= $d->kode ?></strong> <br>
                    <?= $d->nama_produk ?>
                  </small>
                </td>
                <td class="text-center"><?= $d->qty ?></td>
                <td class="text-center <?= (($d->qty != $d->qty_diterima)) ? 'bg-danger' : '' ?>"><?= $d->qty_diterima ?></td>
                <td class="text-center"><?= $d->qty_diterima - $d->qty ?></td>
              </tr>
            <?php
              $total += $d->qty;
              $terima += $d->qty_diterima;
              $selisih += $d->qty_diterima - $d->qty;
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2" align="right"> <strong>Total</strong> </td>
              <td class="text-center"><b><?= $total; ?></b></td>
              <td class="text-center"><b><?= $terima; ?></b></td>
              <td class="text-center"><b><?= $selisih; ?></b></td>
            </tr>
          </tfoot>
        </table>
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
      </div>
      <div class="card-footer">
        <a href="<?= base_url('sup/Selisih') ?>" class="btn btn-sm btn-danger float-right"><i class="fas fa-times-circle"></i> Tutup</a>
      </div>
    </div>
  </div>
</section>
<section>
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="nav-icon fas fa-file"></i> Detail Permintaan</h3>
        <div class="card-tools">
          <a href="<?= base_url('sup/Permintaan') ?>" type="button" class="btn btn-tool">
            <i class="fas fa-times"></i>
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>No PO :</label>
              <input type="text" class="form-control form-control-sm" name="permintaan" value="<?= $permintaan->id ?>" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Nama Toko :</label>
              <input type="text" class="form-control form-control-sm" name="toko" value="<?= $permintaan->nama_toko ?>" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Status :</label> <br>
              <?= status_permintaan($permintaan->status); ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Nama SPG :</label>
              <input type="text" class="form-control form-control-sm" name="spg" value="<?= $permintaan->spg ?>" readonly>
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label>Alamat Toko :</label> <br>
              <address>
                <small><?= $permintaan->alamat ?></small>
              </address>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 table-responsive">
            <table class="table table-bordered table-striped" id="myTable">
              <thead>
                <tr>
                  <th rowspan="2" class="text-center">No</th>
                  <th rowspan="2" class="text-center" style="width: 27%;">Artikel #</th>
                  <th rowspan="2" class="text-center">Stok</th>
                  <th colspan="2" class="text-center">Jumlah</th>
                  <th rowspan="2" class="text-center">Harga</th>
                  <th rowspan="2" class="text-center">Total</th>
                  <th rowspan="2" class="text-center">Keterangan</th>
                </tr>
                <tr>
                  <th class="text-center">Minta</th>
                  <th class="text-center">ACC</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <?php
                  $no = 0;
                  $total_qty = 0;
                  $grandtotal = 0;
                  foreach ($detail_permintaan as $d) :
                    $no++;
                    $total = 0;
                    $hrg_produk = 0;
                    if ($d->het != 1) {
                      $hrg_produk = $d->het_indobarat;
                    } else {
                      $hrg_produk = $d->het_jawa;
                    }
                  ?>
                <tr>
                  <td class="text-center"><?= $no ?></td>
                  <td>
                    <small>
                      <strong><?= $d->kode ?></strong> <br>
                      <?= $d->nama_produk ?>
                    </small>
                  </td>
                  <td class="text-center">
                    <?= $d->stok ?>
                  </td>
                  <td class="text-center">
                    <?= $d->qty ?>
                  </td>
                  <td class="text-center">
                    <?= $d->qty_acc ?>
                  </td>
                  <td class="text-right">
                    Rp <?= number_format($hrg_produk) ?>
                  </td>
                  <td class="total text-right">
                    Rp <?= number_format($hrg_produk * $d->qty_acc) ?>
                  </td>
                  <td class="text-center">
                    <small><?= $d->keterangan ?></small>
                  </td>
                </tr>
              <?php
                    $grandtotal += $hrg_produk * $d->qty_acc;
                  endforeach;
              ?>
              </tr>
              <tr>
                <td colspan="6" class="text-right">GrandTotal :</td>
                <td class="text-right">Rp <?= number_format($grandtotal) ?></td>
                <td></td>
              </tr>
              </tbody>
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
                        <?= $h->catatan ?>
                      </small>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </div>
            <hr>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <a href="<?= base_url('sup/Permintaan') ?>" class="btn btn-danger btn-sm float-right" title="Tutup"><i class="fas fa-times-circle"></i> Tutup</a>
      </div>
    </div>
  </div>
</section>
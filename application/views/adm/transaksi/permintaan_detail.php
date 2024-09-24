<section class="content">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file-alt"></i> Detail Permintaan</h3>
        <div class="card-tools">
          <a href="<?= base_url('adm/Permintaan') ?>" type="button" class="btn btn-tool">
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

        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-center">
              <th rowspan="2">No</th>
              <th rowspan="2">Artikel</th>
              <th colspan="2">Jumlah</th>
              <th rowspan="2">Keterangan</th>
            </tr>
            <tr class="text-center">
              <th>Minta</th>
              <th>ACC</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            $t_minta = 0;
            $t_acc = 0;
            foreach ($detail as $d) {
              $no++; ?>
              <tr>
                <td class="text-center"><?= $no ?></td>
                <td>
                  <small>
                    <strong><?= $d->kode ?></strong> <br>
                    <?= $d->nama_produk ?>
                  </small>
                </td>
                <td class="text-center"><?= $d->qty ?></td>
                <td class="text-center"><?= $d->qty_acc ?></td>
                <td><?= $d->keterangan ?></td>
              </tr>
            <?php
              $t_minta += $d->qty;
              $t_acc += $d->qty_acc;
            }
            ?>
            <tr>
              <td colspan="2" class="text-right">Total :</td>
              <td class="text-center"><?= $t_minta ?></td>
              <td class="text-center"><?= $t_acc ?></td>
              <td></td>
            </tr>
          </tbody>
        </table>
        <hr>
        # Proses Pengajuan :
        <hr>
        <div class="timeline">
          <?php
          $no = 0;
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
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="nav-icon fas fa-box"></i> <?= $title ?></h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <label for="">Nomor</label>
              <input type="text" class="form-control form-control-sm" value="<?= $mutasi->id ?>" readonly>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="">Toko Asal</label>
              <input type="text" class="form-control form-control-sm" value="<?= $mutasi->asal ?>" readonly>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="">Toko Tujuan</label>
              <input type="text" class="form-control form-control-sm" value="<?= $mutasi->tujuan ?>" readonly>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="">Status</label> <br>
              <?= status_mutasi($mutasi->status) ?>
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
            </tr>
            <tr class="text-center">
              <th>Kirim</th>
              <th>Terima</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            $t_qty = 0;
            $t_terima = 0;
            foreach ($detail as $d) {
              $no++; ?>
              <tr>
                <td class="text-center"><?= $no ?></td>
                <td><small>
                    <strong><?= $d->kode ?></strong> <br>
                    <?= $d->nama_produk ?>
                  </small></td>
                <td class="text-center"><?= $d->qty ?></td>
                <td class="text-center"><?= $d->qty_terima ?></td>
              </tr>
            <?php
              $t_qty += $d->qty;
              $t_terima += $d->qty_terima;
            } ?>
            <tr>
              <td colspan="2" class="text-right">Total :</td>
              <td class="text-center"><?= $t_qty ?></td>
              <td class="text-center"><?= $t_terima ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <a href="<?= base_url('adm/Mutasi') ?>" class="btn btn-sm btn-danger float-right"><i class="fas fa-arrow-left"></i> Kembali</a>
      </div>
    </div>
  </div>
</section>
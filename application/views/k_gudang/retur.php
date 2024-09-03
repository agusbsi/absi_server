<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title"> <i class="fas fa-exchange-alt"></i> Retur</h3>
        <div class="card-tools">
          <a href="<?= base_url('k_gudang/Dashboard') ?>"> <i class="fas fa-times-circle"></i></a>
        </div>
      </div>
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nomor Retur</th>
              <th style="width: 40%;">Toko</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Menu</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            foreach ($po as $d):
              $no++;
            ?>
              <tr>
                <td><?= $no ?></td>
                <td>
                  <small>
                    <strong><?= $d->id ?></strong>
                  </small>
                </td>
                <td>
                  <small>
                    <strong><?= $d->nama_toko ?></strong> <br>
                    <?= $d->alamat ?>
                  </small>
                </td>
                <td>
                  <small>
                    <strong>Dibuat : </strong> <?= date('d M Y', strtotime($d->created_at)) ?> <br>
                    <strong>Dijemput : </strong> <?= date('d M Y', strtotime($d->tgl_jemput)) ?>
                  </small>
                </td>
                <td><?= status_retur($d->status) ?></td>
                <td>
                  <a href="<?= base_url('k_gudang/Dashboard/retur_detail/' . $d->id) ?>" class="btn btn-sm btn-<?= $d->status == 3 || $d->status == 13 ? 'success' : 'primary' ?>"><?= $d->status == 3 || $d->status == 13 ? 'Proses' : 'Detail' ?></a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
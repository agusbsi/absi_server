<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title"> <i class="fas fa-truck"></i> Pengiriman</h3>
        <div class="card-tools">
          <a href="<?= base_url('k_gudang/Dashboard') ?>"> <i class="fas fa-times-circle"></i></a>
        </div>
      </div>
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nomor DO</th>
              <th>Nomor PO</th>
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
                    <strong><?= $d->id_permintaan ?></strong>
                  </small>
                </td>
                <td>
                  <small>
                    <strong><?= $d->nama_toko ?></strong> <br>
                    <?= $d->alamat ?>
                  </small>
                </td>
                <td><small><?= date('d M Y', strtotime($d->created_at)) ?></small></td>
                <td><?= status_pengiriman($d->status) ?></td>
                <td>
                  <a href="<?= base_url('k_gudang/Dashboard/kirim_detail/' . $d->id) ?>" class="btn btn-sm btn-primary">Detail</a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title"> <i class="fas fa-box"></i> Artikel</h3>
        <div class="card-tools">
          <a href="<?= base_url('k_gudang/Dashboard') ?>"> <i class="fas fa-times-circle"></i></a>
        </div>
      </div>
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>Nama Artikel</th>
              <th>Satuan</th>
              <th class="text-center">Min-Pack</th>
              <th class="text-center">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            foreach ($artikel as $d):
              $no++;
            ?>
              <tr>
                <td><?= $no ?></td>
                <td><small><?= $d->kode ?></small></td>
                <td><small><?= $d->nama_produk ?></small></td>
                <td><small><?= $d->satuan ?></small></td>
                <td class="text-center"><?= $d->packing ?></td>
                <td class="text-center"><?= status_artikel($d->status) ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
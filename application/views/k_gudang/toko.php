<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title"> <i class="fas fa-store"></i> Toko</h3>
        <div class="card-tools">
          <a href="<?= base_url('k_gudang/Dashboard') ?>"> <i class="fas fa-times-circle"></i></a>
        </div>
      </div>
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th style="width: 40%;">Toko</th>
              <th>Supervisor</th>
              <th>Leader</th>
              <th>SPG</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            foreach ($toko as $d):
              $no++;
            ?>
              <tr>
                <td><?= $no ?></td>
                <td>
                  <small>
                    <strong><?= $d->nama_toko ?></strong> <br>
                    <?= $d->alamat ?>
                  </small>
                </td>
                <td><small><?= $d->spv ? $d->spv : '<span class="text-danger">Belum dikaitkan</span>' ?></small></td>
                <td><small><?= $d->leader ? $d->leader : '<span class="text-danger">Belum dikaitkan</span>' ?></small></td>
                <td><small><?= $d->spg ? $d->spg : '<span class="text-danger">Belum dikaitkan</span>' ?></small></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-store"></i> Toko anda
        </h3>
        <div class="card-tools">
          <a href="<?= base_url('spg/Dashboard') ?>" type="button" class="btn btn-tool">
            <i class="fas fa-times"></i>
          </a>
        </div>
      </div>
      <div class="card-body table-responsive">
        <div class="card card-success card-outline">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-store"></i> Detail Toko</h3>
          </div>
          <div class="card-body p-2">
            <ul class="list-group list-group-flush">
              <li class="list-group-item  align-items-center p-2">
                <div>
                  <strong>Nama Toko</strong><br>
                  <small class="text-muted"><?= $toko->nama_toko ?></small>
                </div>
                <hr>
                <div>
                  <strong>Alamat</strong><br>
                  <small class="text-muted"><?= $toko->alamat ?></small>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="card card-success card-outline">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-users"></i> Team</h3>
          </div>
          <div class="card-body p-2">
            <ul class="list-group list-group-flush">
              <li class="list-group-item  align-items-center p-2">
                <div>
                  <strong>Team Leader</strong><br>
                  <small class="text-muted"><?= $toko->leader ? $toko->leader : 'Belum ada' ?></small>
                </div>
                <hr>
                <div>
                  <strong>SPG</strong><br>
                  <small class="text-muted"><?= $toko->spg ? $toko->spg : 'Belum ada' ?></small>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <table id="example1" class="table table-bordered table-striped">
          <thead class="thead-light">
            <tr>
              <th class="text-center" style="width: 5%;">No</th>
              <th>Artikel</th>
              <th class="text-center" style="width: 10%;">Stok</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            $total = 0;
            foreach ($stok_produk as $stok) {
              $no++
            ?>
              <tr>
                <td class="text-center"><?= $no ?></td>
                <td>
                  <small>
                    <strong><?= $stok->kode ?></strong><br>
                    <?= $stok->nama_produk ?> | <?= $stok->satuan ?>
                  </small>
                </td>
                <td class="text-center"><?= $stok->qty ?></td>
              </tr>
            <?php
              $total += $stok->qty;
            } ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="text-center"><strong>Total :</strong> <b><?= $total; ?></b></td>
            </tr>
          </tfoot>
        </table>
      </div>

    </div>
  </div>
</section>
<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-cart-plus"></i> <?= $title ?></h3>
        <div class="card-tools">
          <a href="<?= base_url('spg/Dashboard') ?>" type="button" class="btn btn-tool">
            <i class="fas fa-times"></i>
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <a href="<?= base_url('spg/penjualan/tambah_penjualan') ?>" class="btn btn-sm btn-success ml-auto">
            <li class="fas fa-plus"></li> Input Penjualan
          </a>
        </div>
        <hr>
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th>No Penjualan</th>
              <th class="text-center">Menu</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            foreach ($list_penjualan as $row) {
              $no++ ?>
              <tr>
                <td class="text-center"><?= $no ?></td>
                <td>
                  <small>
                    <strong><?= $row->id ?></strong> <br>
                    <?= date("d F Y", strtotime($row->tanggal_penjualan)) ?>
                  </small>
                </td>
                <td class="text-center">
                  <a class="btn btn-primary btn-sm" href="<?= base_url('spg/Penjualan/detail/') . $row->id ?>"><i class="fa fa-eye"></i> Detail</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
</section>
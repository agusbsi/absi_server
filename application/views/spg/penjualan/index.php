<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-cart"></i> <?= $title ?></h3>
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
                  <th>#</th>
                  <th>Kode</th>
                  <th>Tanggal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($list_penjualan as $row) {
                  $no++ ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= $row->id ?></td>
                    <td>
                      <?= date("d F Y", strtotime($row->tanggal_penjualan)) ?>
                    </td>
                    <td><a class="btn btn-primary btn-sm" href="<?= base_url('spg/Penjualan/detail/') . $row->id ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
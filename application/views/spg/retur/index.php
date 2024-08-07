<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-exchange-alt"></i> <?= $title ?></h3>
            <div class="card-tools">
              <a href="<?= base_url('spg/Dashboard') ?>" type="button" class="btn btn-tool">
                <i class="fas fa-times"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <a href="<?= base_url('spg/retur/tambah_retur') ?>" class="btn btn-success ml-auto btn-sm">
                <li class="fas fa-plus"></li> Buat Retur
              </a>
            </div>
            <hr>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No.Retur #</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($list_retur as $row) {
                  $no++ ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= $row->id ?></td>
                    <td><?= date('d-M-Y', strtotime($row->created_at)) ?></td>
                    <td><?= status_retur($row->status) ?></td>
                    <td>
                      <a type="button" class="btn btn-primary btn-sm" href="<?= base_url('spg/retur/detail/' . $row->id) ?>"><i class="fas fa-eye" aria-hidden="true"></i> Detail</a>
                    </td>
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
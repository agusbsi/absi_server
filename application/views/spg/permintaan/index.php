<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-file-alt"></i> <?= $title ?></h3>
          </div>
          <div class="card-body">
            <div class="row">
              <a href="<?= base_url('spg/permintaan/tambah_permintaan') ?>" class="btn btn-sm btn-success ml-auto">
                <li class="fas fa-plus"></li> Buat PO
              </a>
            </div>
            <hr>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Nomor</th>
                  <th>Status</th>
                  <th>Menu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($list_permintaan as $row) {
                  $no++; ?>
                  <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td>
                      <small>
                        <strong><?= $row->id ?></strong> <br>
                        <?= date('d-M-Y', strtotime($row->created_at)) ?>
                      </small>
                    </td>
                    <td class="text-center"><?= status_permintaan($row->status) ?></td>
                    <td class="text-center"><a class="btn btn-primary btn-sm" href="<?= base_url('spg/Permintaan/detail/') . $row->id ?>"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a></td>
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
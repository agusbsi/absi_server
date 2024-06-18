<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">

    </div>
  </div>
  <div class="row">
    <!-- /.col -->
    <div class="col-md-12">
      <div class="card card-info ">
        <div class="card-header">
          <h3 class="card-title">
            <li class="fas fa-check-circle"></li> Data Penerimaan
          </h3>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">

          <!-- isi konten -->
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr class="text-center">
                <th>No.</th>
                <th>No Pengiriman</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Menu</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              foreach ($list_data as $dd) :
                $no++;
              ?>
                <tr class="text-center">
                  <td><?= $no ?></td>
                  <td><?= $dd->id ?></td>
                  <td><?= status_pengiriman($dd->status) ?></td>
                  <td><?= $dd->created_at ?></td>

                  <td>
                    <?php
                    if ($dd->status == 1) {
                    ?>
                      <a type="button" class="btn btn-success btn-sm" href="<?= base_url('spg/penerimaan/terima/' . $dd->id) ?>"><i class="fas fa-arrow-circle-right" aria-hidden="true"></i> Proses</a>
                    <?php
                    } else {
                    ?>
                      <a type="button" class="btn btn-primary btn-sm" href="<?= base_url('spg/penerimaan/detail/' . $dd->id) ?>"><i class="fas fa-eye" aria-hidden="true"></i> Detail</a>
                    <?php }
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>

          </table>
        </div>
      </div>
    </div>
  </div>
</section>
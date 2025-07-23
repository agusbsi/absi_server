<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-danger ">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-store"></i> List Toko Tutup</b> </h3>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th>Nama Toko</th>
                  <th>Alamat</th>
                  <th>Status</th>
                  <th>Menu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($toko_tutup as $t) :
                  $no++
                ?>
                  <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td style="width: 25%;">
                      <small>
                        <strong><?= $t->nama_toko ?></strong> <br>
                        <?= jenis_toko($t->jenis_toko) ?>
                      </small>
                    </td>
                    <td style="width: 45%;">
                      <small><?= $t->alamat ?></small>
                    </td>
                    <td class="text-center">
                      <?= status_toko($t->status) ?>
                    </td>
                    <td class="text-center">
                      <a href="<?= base_url('adm/Toko/detail_toko/' . $t->id) ?>" class="btn btn-info btn-sm"> <i class="fas fa-eye"></i> Detail</a>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
          <div class="card-footer text-center ">
          </div>
        </div>
      </div>

    </div>
  </div>
  </div>
</section>
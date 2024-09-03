<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-info ">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-store"></i> List Pengajuan Toko</b> </h3>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th class="text-center" style="width:4%">No</th>
                  <th style="width:14%">No Pengajuan</th>
                  <th>Toko</th>
                  <th>Kategori</th>
                  <th class="text-center">Status</th>
                  <th class="text-center" style="width:10%">Menu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($pengajuan as $t) :
                  $no++
                ?>
                  <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td>
                      <small>
                        <strong><?= $t->nomor ?></strong>
                      </small>
                    </td>
                    <td>
                      <small>
                        <strong><?= $t->nama_toko ?></strong>
                        <address><?= $t->alamat ?></address>
                      </small>
                    </td>
                    <td>
                      <small>
                        <strong><?= kategori_pengajuan($t->kategori) ?></strong>
                      </small>
                    </td>
                    <td class="text-center">
                      <?= status_pengajuan($t->status) ?>
                    </td>
                    <td>
                      <a href="<?= base_url('sup/Toko/toko_tutup_d/' . $t->id) ?>" class="btn btn-<?= $t->status == 1 ? "success" : "info" ?> btn-sm "> <i class="fas fa-<?= $t->status == 1 ? "arrow-right" : "eye" ?>"></i> <?= $t->status == 1 ? "Proses" : "Detail" ?> </a>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
  </div>
</section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-info ">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-store"></i> Pengajuan Toko</b> </h3>
          </div>
          <div class="card-body">
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <i class="icon fas fa-check"></i>
              <small>Proses pengajuan Toko baru sekarang hanya melalui ABSI, Marketing tidak perlu lagi membuat pengajuan secara manual. </small>
            </div>
            <hr>
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
                      <?php if ($t->kategori == 3) { ?>
                        <a href="<?= base_url('adm/Toko/toko_tutup_d/' . $t->id) ?>"
                          class="btn btn-<?= ($t->status == 3 || $t->status == 6) ? 'success' : 'info' ?> btn-sm">
                          <i class="fas fa-<?= ($t->status == 3 || $t->status == 6) ? 'arrow-right' : 'eye' ?>"></i>
                          <?= ($t->status == 3 || $t->status == 6) ? 'Proses' : 'Detail' ?>
                        </a>

                      <?php } else { ?>
                        <a href="<?= base_url('adm/Toko/detail/' . $t->id) ?>" class="btn btn-<?= $t->status == 3 ? "success" : "info" ?> btn-sm "> <i class="fas fa-<?= $t->status == 3 ? "arrow-right" : "eye" ?>"></i> <?= $t->status == 3 ? "Proses" : "Detail" ?> </a>
                      <?php } ?>
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
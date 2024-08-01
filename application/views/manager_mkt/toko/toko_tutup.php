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
                  <th>#</th>
                  <th>No Pengajuan</th>
                  <th style="width:30%">Nama Toko</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                  <th style="width:13%">Menu</th>
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
                    <td><?= $t->id ?></td>
                    <td>
                      <small>
                        <strong><?= $t->nama_toko ?></strong>
                        <address>
                          <?= $t->alamat ?>
                        </address>
                      </small>
                    </td>
                    <td>
                      <small>
                        Dibuat : <?= date('d M Y', strtotime($t->created_at)) ?> <br>
                        Penjemputan : <?= date('d M Y', strtotime($t->tgl_jemput)) ?> <br>
                      </small>
                    </td>
                    <td class="text-center">
                      <?= status_retur($t->status) ?>
                    </td>
                    <td>
                      <a href="<?= base_url('mng_mkt/Toko/toko_tutup_d/' . $t->id) ?>" class="btn btn-sm btn-<?= ($t->status == 11 ? "success" : "info") ?>"> <?= ($t->status == 11 ? "Proses <i class='fa fa-arrow-right'></i>" : "<i class='fa fa-eye'></i> Detail") ?></a>
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
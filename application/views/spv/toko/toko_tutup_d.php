<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-danger ">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-store"></i> Pengajuan <?= kategori_pengajuan($retur->kategori) ?></b> </h3>
            <div class="card-tools">
              <a href="<?= base_url('spv/Toko/pengajuanToko') ?>"> <i class="fas fa-times-circle"></i></a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">No. Pengajuan</label> <br>
                  <h5><?= $retur->nomor ?></h5>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">No. Retur</label> <br>
                  <h5><?= $retur->id_retur ?></h5>
                </div>
              </div>
              <div class="col-md-4">
                <label for="">Nama Toko</label> <br>
                <small>
                  <strong><?= $retur->nama_toko ?></strong> <br>
                  <address><?= $retur->alamat ?></address>
                </small>
              </div>
              <div class="col-md-2">
                <label for="">Tanggal</label> <br>
                <small>
                  Dibuat : <?= date('d M Y', strtotime($retur->created_at)) ?> <br>
                  Penjemputan : <?= date('d M Y', strtotime($retur->tgl_jemput)) ?>
                </small>
              </div>
              <div class="col-md-2">
                <label for="">Status</label> <br>
                <small>
                  <?= status_pengajuan($retur->status) ?>
                </small>
              </div>
            </div>
            <hr>
            #List Aset
            <hr>
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Aset</th>
                  <th>Jumlah</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (empty($aset)) {
                  echo "<tr><td colspan='4' class='text-center'>DATA ASET KOSONG</td></tr>";
                } else {
                  $no = 0;
                  foreach ($aset as $t) :
                    $no++
                ?>
                    <tr>
                      <td class="text-center"><?= $no ?></td>
                      <td>
                        <small>
                          <strong><?= $t->kode ?></strong> <br>
                          <?= $t->aset ?>
                        </small>
                      </td>
                      <td class="text-center"><?= $t->qty ?></td>
                      <td>
                        <small><?= $t->keterangan ?></small>
                      </td>
                    </tr>
                <?php
                  endforeach;
                }
                ?>
              </tbody>
            </table>
            <hr>
            # List Artikel
            <hr>
            <table class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th>Kode</th>
                  <th>Artikel</th>
                  <th>Jumlah</th>
                  <th>Diterima gudang</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                $total = 0;
                $total_a = 0;
                foreach ($artikel as $t) :
                  $no++
                ?>
                  <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td>
                      <small>
                        <strong><?= $t->kode ?></strong>
                      </small>
                    </td>
                    <td>
                      <small><?= $t->nama_produk ?></small>
                    </td>
                    <td class="text-center"><?= $t->qty ?></td>
                    <td class="text-center <?= $retur->status == 15 && $t->qty_terima != $t->qty ? 'bg-danger' : '' ?>"><?= $retur->status == 15 ? $t->qty_terima : 'Belum' ?></td>
                  </tr>
                <?php
                  $total += $t->qty;
                  $total_a += $t->qty_terima;
                endforeach;
                ?>
                <tr>
                  <td colspan="3" class="text-right">Total :</td>
                  <td class="text-center"><?= $total ?></td>
                  <td class="text-center"><?= $retur->status == 15 ? $total_a : 'Belum' ?></td>
                </tr>
              </tbody>
            </table>
            <hr>
            # Proses Pengajuan :
            <hr>
            <div class="timeline">
              <?php $no = 0;
              foreach ($histori as $h) :
                $no++;
              ?>
                <div>
                  <i class="fas bg-blue"><?= $no ?></i>
                  <div class="timeline-item">
                    <span class="time"></span>
                    <p class="timeline-header"><small><?= $h->aksi ?> <strong><?= $h->pembuat ?></strong></small></p>
                    <div class="timeline-body">
                      <small>
                        <?= date('d-M-Y  H:i:s', strtotime($h->tanggal)) ?> <br>
                        Catatan :<br>
                        <?= $h->catatan_h ?>
                      </small>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </div>
            <hr>
            <div class="row no-print">
              <div class="col-12">
                <a href="<?= base_url('spv/Toko/pengajuanToko') ?>" class="btn btn-sm btn-danger float-right" style="margin-right: 5px;">
                  <i class="fas fa-arrow-left"></i> Kembali </a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  </div>
</section>
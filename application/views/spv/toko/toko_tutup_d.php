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
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">No. Pengajuan</label> <br>
                  <h5><?= $retur->nomor ?></h5>
                </div>
              </div>
              <div class="col-md-5">
                <label for="">Nama Toko</label> <br>
                <small>
                  <strong><?= $retur->nama_toko ?></strong> <br>
                  <address><?= $retur->alamat ?></address>
                </small>
              </div>
              <div class="col-md-2">
                <label for="">Tanggal</label> <br>
                <small>
                  dibuat : <?= date('d M Y', strtotime($retur->created_at)) ?> <br>
                  tutup : <?= date('d M Y', strtotime($retur->tgl_jemput)) ?>
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
            # List Artikel
            <hr>
            <div style="max-height: 300px; overflow-y: auto;">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr class="text-center">
                    <th>No</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  $total = 0;
                  foreach ($artikel as $t) :
                    $no++
                  ?>
                    <tr>
                      <td class="text-center"><?= $no ?></td>
                      <td>
                        <small>
                          <strong><?= $t->kode ?></strong> <br>
                          <?= $t->nama_produk ?>
                        </small>
                      </td>
                      <td class="text-center"><?= $t->qty ?></td>
                    </tr>
                  <?php
                    $total += $t->qty;
                  endforeach;
                  ?>
                  <tr>
                    <td colspan="2" class="text-right">Total :</td>
                    <td class="text-center"><?= $total ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
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
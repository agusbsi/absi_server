<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">
          <li class="fas fa-exchange-alt"></li> Detail
        </h3>
        <input type="hidden" name="id_retur" value="<?= $retur->id ?>">
        <input type="hidden" name="id_toko" value="<?= $retur->id_toko ?>">
        <div class="card-tools">
          <a href="<?= base_url('adm_gudang/Retur') ?>" type="button" class="btn btn-tool">
            <i class="fas fa-times"></i>
          </a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <hr>
        <h5 class="text-center">RETUR TUTUP TOKO</h5>
        <hr>
        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <label for="">No Retur :</label>
              <input type="text" value="<?= $retur->id ?>" class="form-control form-control-sm" readonly>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="">Toko:</label>
              <input type="text" value="<?= $retur->nama_toko ?>" class="form-control form-control-sm" readonly>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="">Tgl dibuat:</label>
              <input type="text" value="<?= date('d-M-Y', strtotime($retur->created_at)) ?>" class="form-control form-control-sm" readonly>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="">Tgl Dijemput:</label>
              <input type="text" value="<?= date('d-M-Y', strtotime($retur->tgl_jemput)) ?>" class="form-control form-control-sm" readonly>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="">Tgl Diterima:</label>
              <input type="text" value="<?= $retur->tgl_terima ? date('d-M-Y', strtotime($retur->tgl_terima)) : "-" ?>" class="form-control form-control-sm" readonly>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="">Status:</label> <br>
              <?= status_retur($retur->status) ?>
            </div>
          </div>
        </div>
        <hr>
        <table class="table responsive table-bordered table-striped">
          <thead>
            <tr class="text-center">
              <th rowspan="2" style="width:5%">#</th>
              <th rowspan="2">Artikel</th>
              <th rowspan="2" style="width:5%">Satuan</th>
              <th colspan="2">Jumlah</th>
            </tr>
            <tr class="text-center">
              <th>Retur</th>
              <th>Terima</th>
            </tr>
          </thead>
          <tbody>

            <?php
            $no = 0;
            $total_qty = 0;
            $total_terima = 0;
            foreach ($detail_retur as $d) {
              $no++;

            ?>
              <tr>
                <td class="text text-center"><?= $no ?></td>
                <td>
                  <small>
                    <strong><?= $d->kode ?> </strong> <br>
                    <?= $d->nama_produk ?>
                  </small>
                </td>
                <td><small><?= $d->satuan ?></small></td>
                <td class="text-center"><?= $d->qty ?></td>
                <td class="text-center"><?= $d->qty_terima ?></td>

              </tr>
            <?php
              $total_qty += $d->qty;
              $total_terima += $d->qty_terima;
            }
            ?>

          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="text-right">Total :</td>
              <td class="text-center"> <strong><?= $total_qty ?></strong> </td>
              <td class="text-center"> <strong><?= $total_terima ?></strong> </td>
            </tr>
          </tfoot>
        </table>
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
      </div>
      <div class="card-footer">
        <a href="<?= base_url('adm_gudang/Retur') ?>" class="btn btn-danger btn-sm float-right mr-3"><i class="fas fa-times-circle"></i> Close</a>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="nav-icon fas fa-exchange-alt"></i> Detail Retur</h3>
        <div class="card-tools">
          <a href="<?= base_url('spg/retur') ?>" type="button" class="btn btn-tool">
            <i class="fas fa-times"></i>
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-2">
            <div class="form-group mb-1">
              <label>No Retur :</label>
              <input type="text" class="form-control form-control-sm" value="<?= $retur->id ?>" readonly>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group mb-1">
              <label>Toko :</label>
              <input type="text" class="form-control form-control-sm" value="<?= $retur->nama_toko ?>" readonly>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="">Dibuat</label> <br>
              <?= date('d M Y H:i:s', strtotime($retur->created_at)) ?>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="">Dijemput</label> <br>
              <?= date('d M Y', strtotime($retur->tgl_jemput)) ?>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group mb-1">
              <label>Status :</label> <br>
              <?= status_retur($retur->status) ?>
            </div>
          </div>
        </div>
        <hr>

        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>Artikel</th>
              <th>Qty</th>
              <th>Foto</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            $total = 0;
            foreach ($detail_retur as $d) :
              $no++ ?>
              <tr>
                <td><?= $no ?></td>
                <td>
                  <small>
                    <strong><?= $d->kode ?></strong> <br>
                    <?= $d->artikel ?>
                  </small>
                </td>
                <td class="text-center"><?= $d->qty ?></td>
                <td class="text-center">
                  <img class="img img-rounded" style="height: 50px;" src="<?= base_url('assets/img/retur/' . $d->foto) ?>" alt="User Image">
                </td>
                <td>
                  <small>
                    <strong><?= $d->keterangan ?></strong> <br>
                    <?= $d->catatan ?>
                  </small>
                </td>
              </tr>
            <?php
              $total += $d->qty;
            endforeach ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2" align="right"> <strong>Total :</strong> </td>
              <td class="text-center"><b><?= $total; ?></b></td>
              <td></td>
              <td></td>
            </tr>
          </tfoot>
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
      </div>

      <div class="card-footer">
        <a href="<?= base_url('spg/retur') ?>" class="btn btn-danger btn-sm float-right" style="margin-right: 5px;"> <i class="fas fa-arrow-left"></i> close</a>
      </div>
    </div>
  </div>
</section>
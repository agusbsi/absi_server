<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="nav-icon fas fa-box"></i> Detail PO</h3>
        <div class="card-tools">
          <a href="<?= base_url('spg/Permintaan') ?>" type="button" class="btn btn-tool">
            <i class="fas fa-times"></i>
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <strong>No. PO</strong>
              <input type="text" class="form-control form-control-sm" value="<?= $po->id ?>" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <strong>Status</strong> <br>
              <?= status_permintaan($po->status) ?>
            </div>
          </div>
        </div>
        <hr>
        # Detail
        <hr>
        <table class="table table-bordered table-striped">
          <tr class="text-center">
            <th>Artikel</th>
            <th>Jml Minta</th>
            <th>Jml Acc</th>
          </tr>
          <?php
          $total = 0;
          $total_acc = 0;
          foreach ($detail as $d) { ?>
            <tr>
              <td>
                <small>
                  <strong><?= $d->kode ?></strong> <br>
                  <?= $d->artikel ?>
                </small>
              </td>
              <td class="text-center"><?= $d->qty ?></td>
              <td class="text-center"><?= $d->qty_acc ? $d->qty_acc : "-" ?></td>
            </tr>
          <?php
            $total += $d->qty;
            $total_acc += (int)$d->qty_acc;
          } ?>
          <tfoot>
            <tr>
              <td class="text-right"> <strong>Total :</strong> </td>
              <td class="text-center"><b><?= $total; ?></b></td>
              <td class="text-center"><b><?= $total_acc; ?></b></td>
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
                    <?= $h->catatan ?>
                  </small>
                </div>
              </div>
            </div>
          <?php endforeach ?>
        </div>
        <hr>
      </div>
      <div class="card-footer">
        <a href="<?= base_url('spg/Permintaan') ?>" class="btn btn-sm btn-danger float-right" title="Tutup"><i class="fas fa-times-circle"></i> tutup</a>
      </div>
    </div>

  </div>
</section>
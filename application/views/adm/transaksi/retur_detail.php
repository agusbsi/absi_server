<style>
  .img-artikel {
    width: auto;
    height: 50px;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.3s ease-in-out;
  }

  .img-artikel:hover {
    transform: scale(5.5);
    border: 1px solid rgb(0, 123, 255);
  }
</style>
<section class="content">

  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-exchange-alt"></i> Detail Retur</h3>
        <div class="card-tools">
          <a href="<?= base_url('adm/Retur') ?>" type="button" class="btn btn-tool">
            <i class="fas fa-times"></i>
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col">
            <b>No. Retur</b><br>
            <b>Toko</b><br>
            <b>Tanggal Retur</b><br>
            <b>Status</b><br>
          </div>
          <div class="col">
            : <?= $no_retur ?><br>
            : <?= $nama_toko . " ($nama)" ?><br>
            : <?= date('d-M-Y : H:m:s', strtotime($tanggal)) ?><br>
            : <?= status_retur($status) ?><br>
          </div>
        </div>
        <hr>

        <table class="table responsive table-bordered table-striped">
          <thead>
            <tr class="text-center">
              <th rowspan="2" style="width:5%">#</th>
              <th rowspan="2">Artikel</th>
              <th rowspan="2" style="width:5%">Satuan</th>
              <th rowspan="2">foto</th>
              <th colspan="2">Jumlah Retur</th>
              <th rowspan="2">Keterangan</th>
            </tr>
            <tr class="text-center">
              <th>Kirim</th>
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
                <td>
                  <img class="img-artikel" src="<?= base_url('assets/img/retur/' . $d->foto) ?>" alt="retur">
                </td>
                <td class="text-center"><?= $d->qty ?></td>
                <td class="text-center"><?= $d->qty_terima ?></td>
                <td>
                  <small>
                    <strong><?= $d->keterangan ?></strong> <br>
                    <?= $d->catatan ?>
                  </small>
                </td>
              </tr>
            <?php
              $total_qty += $d->qty;
              $total_terima += $d->qty_terima;
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="text-right">Total :</td>
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
      </div>
    </div>
  </div>
</section>
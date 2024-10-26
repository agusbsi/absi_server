<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">
          <li class="fas fa-exchange-alt"></li> Data Retur
        </h3>
      </div>
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>No Retur</th>
              <th>Nama Toko</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Menu</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            foreach ($list_data as $data) :
              $no++; ?>
              <tr>
                <td><?= $no ?></td>
                <td><?= $data->id ?></td>
                <td>
                  <small>
                    <strong>
                      <?= $data->nama_toko ?>
                    </strong> <br>
                    <?= $data->spg ?>
                  </small>
                </td>
                <td>
                  <small>
                    Dibuat : <?= date('d M Y', strtotime($data->created_at)) ?> <br>
                    Penjemputan : <?= date('d M Y', strtotime($data->tgl_jemput)) ?>
                  </small>
                </td>
                <td>
                  <?php
                  status_retur($data->status);
                  ?>
                </td>
                <td>
                  <?php
                  if ($data->status == 1) {
                  ?>
                    <a type="button" class="btn btn-success btn-sm" href="<?= base_url('mng_ops/Retur/detail/' . $data->id) ?>" name="btn_proses">Proses <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                  <?php } else { ?>
                    <a type="button" class="btn btn-primary btn-sm" href="<?= base_url('mng_ops/Retur/detail/' . $data->id) ?>" name="btn_detail"><i class="fas fa-eye" aria-hidden="true"></i> Detail</a>
                  <?php } ?>
                  <a class="btn btn-default btn-sm <?= $data->status == 7 ? '' : 'disabled' ?>" target="_blank" href="<?= base_url('adm_gudang/retur/sppr/' . $data->id) ?>"><i class="fas fa-print"></i> Sppr</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
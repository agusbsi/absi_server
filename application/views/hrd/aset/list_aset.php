<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">
              <li class="fas fa-hospital"></li> Data aset toko
            </h3>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th style="width: 55%;">Nama Toko</th>
                  <th>Jumlah Aset</th>
                  <th>Status</th>
                  <th>Menu</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php if (is_array($list_data)) { ?>
                    <?php $no = 1; ?>
                    <?php foreach ($list_data as $dd) : ?>
                      <td class="text-center"><?= $no ?></td>
                      <td>
                        <small>
                          <b><?= $dd->nama_toko ?></b>
                          <br>
                          <?= $dd->alamat ?>
                        </small>
                      </td>
                      <td class="text-center">
                        <?= $dd->total_aset > 0 ? $dd->total_aset : "<span class='badge badge-sm badge-warning'>Tidak ada aset</span>" ?>
                      </td>
                      <td class="text-center">
                        <?php if ($dd->status_aset == 0) { ?>
                          <span class='badge badge-danger'>Belum Update</span>
                        <?php } else { ?>
                          <span class='badge badge-success'>Sudah Update</span>
                        <?php } ?>
                      </td>
                      <td class="text-center">
                        <?php
                        $tgl = (!empty($dd->tanggal) && date('Y-m', strtotime($dd->tanggal)) == date('Y-m'))
                          ? date('Y-m', strtotime($dd->tanggal))
                          : "empty";
                        ?>
                        <a href="<?= base_url('adm/So/detail_aset/' . $dd->id_toko . '/' . $tgl) ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Detail</a>
                      </td>
                </tr>
                <?php $no++; ?>
              <?php endforeach; ?>
            <?php } else { ?>
              <td colspan="5" align="center"><strong>Data Kosong</strong></td>
            <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
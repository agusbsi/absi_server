<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-info ">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-store"></i> List Pengajuan Toko</b> </h3>
          </div>
          <div class="card-body">
            <table id="table_toko" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th style="width:4%">No</th>
                  <th>Nama Toko</th>
                  <th style="width:28%">Alamat</th>
                  <th>PIC</th>
                  <th>Status</th>
                  <th style="width:13%">Menu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($toko as $t) :
                  $no++
                ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td>
                      <small>
                        <strong><?= $t->nama_toko ?></strong> <br>
                        <?= jenis_toko($t->jenis_toko) ?>
                      </small>
                    </td>
                    <td>
                      <small>
                        <address><?= $t->alamat ?></address>
                      </small>
                    </td>
                    <td>
                      <small>
                        <strong> <i class="fas fa-user"></i> <?= $t->nama_pic ?></strong> <br>
                        <i class="fas fa-phone"></i> <?= $t->telp ?>
                      </small>
                    </td>
                    <td class="text-center">
                      <?= status_toko($t->status) ?>
                    </td>
                    <td>
                      <a href="<?= base_url('adm/Toko/detail/' . $t->id) ?>" class="btn btn-<?= $t->status == 4 ? "success" : "info" ?> btn-sm "> <i class="fas fa-<?= $t->status == 4 ? "arrow-right" : "eye" ?>"></i> <?= $t->status == 4 ? "Proses" : "Detail" ?> </a>
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

<!-- jQuery -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script>
  $(document).ready(function() {

    $('#table_toko').DataTable({
      order: [
        [0, 'asc']
      ],
      responsive: true,
      lengthChange: false,
      autoWidth: false,
    });


  })
</script>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-info ">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-store"></i> Semua toko aktif</b> </h3>
          </div>
          <div class="card-body">
            <table id="table_toko" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th style="width:2%">No</th>
                  <th style="width:22%">Nama Toko</th>
                  <th style="width:30%">Alamat</th>
                  <th>Pengguna</th>
                  <th>Tgl dibuat</th>
                  <th>Menu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($toko as $t) :
                  $no++
                ?>
                  <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td>
                      <small><strong><?= $t->nama_toko ?></strong></small>
                    </td>
                    <td>
                      <small><?= $t->alamat ?></small>
                    </td>
                    <td>
                      <small>
                        <strong>Leader : </strong> <?= $t->leader ? $t->leader : 'Belum ada' ?> <br>
                        <strong>Spg : </strong> <?= $t->spg ? $t->spg : 'Belum ada' ?>
                      </small>
                    </td>
                    <td class="text-center">
                      <small><?= date('d-M-Y H:i:s', strtotime($t->created_at)) ?></small>
                    </td>
                    <td class="text-center">
                      <a href="<?= base_url('mng_ops/Dashboard/toko_detail/' . $t->id) ?>" class="btn btn-info btn-sm"> <i class="fas fa-eye"></i></a>
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
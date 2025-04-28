<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-info ">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-store"></i> Toko Aktif</b> </h3>
            <div class="card-tools">
              <a href="<?= base_url('leader/Dashboard') ?>" type="button" class="btn btn-tool">
                <i class="fas fa-times"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
            <form action="<?= base_url('spg/Aset/simpan'); ?>" method="post">
              <table id="table_retur" class="table table-bordered table-striped">
                <thead>
                  <tr class="text-center">
                    <th style="width:3%">No</th>
                    <th>Nama Toko</th>
                    <th>Alamat</th>
                    <th>SPG</th>
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
                      <td><?= $no ?></td>
                      <td>
                        <small>
                          <strong><?= $t->nama_toko ?></strong>
                        </small>
                      </td>
                      <td>
                        <small><?= $t->alamat ?></small>
                      </td>
                      <td class="text-center">
                        <small>
                          <?php
                          if ($t->nama_user == "") {
                            echo "<span class='badge badge-warning'> Belum dikaitkan</span>";
                          } else {
                            echo $t->nama_user;
                          }
                          ?>
                        </small>
                      </td>
                      <td>
                        <a href="<?= base_url('leader/Toko/profil/' . $t->id) ?>" class="btn btn-primary btn-sm"> <i class="fas fa-eye"></i> Detail</a>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
          </div>
          </form>
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

    $('#table_retur').DataTable({
      order: [
        [0, 'asc']
      ],
      responsive: true,
      lengthChange: false,
      autoWidth: false,
    });


  })
</script>
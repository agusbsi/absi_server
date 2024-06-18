<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-info ">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-store"></i> List Toko yang anda kelola</b> </h3>
          </div>
          <div class="card-body">
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <i class="icon fas fa-check"></i>
              <small>Menu Tambah Customer / Toko sekarang berada di fitur "Pengajuan Toko".</small>
            </div>
            <hr>
            <form action="<?= base_url('spg/Aset/simpan'); ?>" method="post">
              <table id="table_toko" class="table table-bordered table-striped">
                <thead>
                  <tr class="text-center">
                    <th style="width:5%">No</th>
                    <th style="width:20%">Nama Toko</th>
                    <th style="width:30%">Alamat</th>
                    <th>Team Leader</th>
                    <th>Status</th>
                    <th style="width:10%">Menu</th>
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
                        <small><?= $t->alamat ?></small>
                      </td>
                      <td class="text-center">
                        <small><?php
                                if ($t->nama_user == "") {
                                  echo "<span class='badge badge-warning'> Belum dikaitkan</span>";
                                } else {
                                  echo $t->nama_user;
                                }
                                ?></small>
                      </td>
                      <td class="text-center">
                        <?= status_toko($t->status) ?>
                      </td>
                      <td>
                        <a href="<?= base_url('spv/Toko/profil/' . $t->id) ?>" class="btn btn-info btn-sm"> <i class="fas fa-eye"></i> Detail</a>
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
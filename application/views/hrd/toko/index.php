<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">
              <li class="fas fa-store"></li> Data Akses Toko
            </h3>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th>Toko</th>
                  <th>Supervisor</th>
                  <th>Leader</th>
                  <th>SPG</th>
                  <th class="text-center">Menu</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                    $no = 0;
                    foreach ($list_toko as $data):
                    $no++; ?>
                <tr>
                      <td>
                        <?= $no ?>
                      </td>
                      <td>
                        <small><strong><?= $data->nama_toko ?></strong></small>
                      </td>
                      <td>
                        <small>
                        <?php if (empty($data->spv)) {
                          echo "<span class='badge badge-danger badge-sm'>- kosong - </span>";
                        } else {
                          echo $data->spv;
                        }
                        ?>
                        </small>
                      </td>
                      <td>
                       <small>
                       <?php if (empty($data->leader)) {
                          echo "<span class='badge badge-danger badge-sm'>- kosong - </span>";
                        } else {
                          echo $data->leader;
                        }
                        ?>
                       </small>
                      </td>
                      <td>
                       <small>
                       <?php if (empty($data->spg)) {
                          echo "<span class='badge badge-danger badge-sm'>- kosong - </span>";
                        } else {
                          echo $data->spg;
                        }
                        ?>
                       </small>
                      </td>
                      <td class="text-center">
                        <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $data->id; ?>"
                          data-toko="<?= $data->nama_toko; ?>" data-spv="<?= $data->id_spv; ?>"
                          data-leader="<?= $data->id_leader; ?>" data-spg="<?= $data->id_spg; ?>"><i
                            class="fas fa-edit"></i>
                          Ganti Akses</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
              </tbody>

            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- modal update akses -->
<div class="modal fade" id="editModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <li class="fas fa-store"></li> Ganti Akses di Toko
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- isi konten -->
        <form method="POST" action="<?= base_url('hrd/Toko/ganti_akses') ?>" role="form" method="post"
          enctype="multipart/form-data">
          <div class="form-group">
            <label for="nama">
              <li class="fas fa-store"></li> Nama Toko
            </label> </br>
            <input type="text" name="toko" class="form-control form-control-sm" id="toko" readonly>
            <input type="hidden" name="id_toko" class="form-control " id="id_toko" readonly>
          </div>
          <div class="form-group">
            <label for="nama">
              <li class="fas fa-user"></li> Supervisor
            </label> </br>
            <select name="spv" class="form-control form-control-sm select2" id="spv">
              <option value="">- Kosong -</option>
              <?php foreach ($spv as $spv): ?>
                <option value="<?= $spv->id ?>"><?= $spv->nama_user ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label for="nama">
              <li class="fas fa-user"></li> Leader
            </label> </br>
            <select name="leader" class="form-control form-control-sm select2" id="leader">
              <option value="">- Kosong -</option>
              <?php foreach ($leader as $leader): ?>
                <option value="<?= $leader->id ?>"><?= $leader->nama_user ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label for="nama">
              <li class="fas fa-user"></li> SPG
            </label> </br>
            <select name="spg" class="form-control form-control-sm select2" id="spg">
              <option value="">- kosong -</option>
              <?php foreach ($spg as $spg): ?>
                <option value="<?= $spg->id ?>"><?= $spg->nama_user ?></option>
              <?php endforeach ?>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
          <li class="fas fa-times-circle"></li> Cancel
        </button>
        <button type="submit" class="btn btn-success btn-sm">
          <li class="fas fa-save"></li> Simpan
        </button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- end modal -->

<!-- jQuery -->
<script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/app/js/alert.js"></script>
<script>
  $(document).ready(function () {

    // btn edit
    $('.btn-edit').on('click', function () {
      // get data from button edit
      const id = $(this).data('id');
      const toko = $(this).data('toko');
      const spv = $(this).data('spv');
      const leader = $(this).data('leader');
      const spg = $(this).data('spg');
      // Set data to Form Edit
      $('#id_toko').val(id);
      $('#toko').val(toko);
      $('#spv').val(spv).trigger('change');
      $('#leader').val(leader).trigger('change');
      $('#spg').val(spg).trigger('change');
      // Call Modal Edit
      $('#editModal').modal('show');
    });

  })
</script>
<!-- /.content -->
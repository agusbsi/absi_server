<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">

    </div>
  </div>
  <div class="row">
    <!-- /.col -->
    <div class="col-md-12">
      <div class="card card-info ">
        <div class="card-header">
          <h3 class="card-title">
            <li class="fas fa-copy"></li> Data Mutasi Barang
          </h3>
          <div class="card-tools">
          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">

          <table id="table_kirim" class="table table-bordered table-striped ">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th style="width: 15%;">Kode Mutasi</th>
                <th>Toko</th>
                <th>Tgl dibuat</th>
                <th>Status</th>
                <th>Menu</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $no = 0;
              foreach ($list_data as $data) :
                $no++;
              ?>
                <tr>
                  <td><?= $no ?></td>
                  <td class="text-center"><?= $data->id ?></td>
                  <td>
                    <small>
                      <b>Asal :</b> <?= $data->asal ?> <br>
                      <b>Tujuan :</b> <?= $data->tujuan ?>
                    </small>
                  </td>
                  <td class="text-center"><?= date("d F Y, H:i:s", strtotime($data->created_at));  ?></td>
                  <td class="text-center"><?= status_mutasi($data->status) ?></td>
                  <td>
                    <a href="<?= base_url('mng_mkt/Mutasi/detail/' . $data->id) ?>" class="btn btn-<?= $data->status == 6 ? 'success' : 'info' ?> btn-sm" title="<?= $data->status == 6 ? 'Proses' : 'Detail' ?>"><i class="fa fa-<?= $data->status == 6 ? 'arrow-right' : 'eye' ?>"></i> <?= $data->status == 6 ? 'Proses' : 'Detail' ?></a>
                    <a href="<?= base_url('mng_mkt/Mutasi/bap/' . $data->id) ?>" class="btn btn-success btn-sm <?= $data->status == 4 ? '' : 'd-none' ?>" title="Proses BAP"><i class="fa fa-check-circle"></i> Proses</a>
                  </td>
                </tr>
              <?php
              endforeach;
              ?>

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
</section>

<!-- jQuery -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script>
  $(document).ready(function() {

    $('#table_kirim').DataTable({
      order: [
        [0, 'asc']
      ],
      responsive: true,
      lengthChange: false,
      autoWidth: false,
    });


  })
</script>
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
            <li class="fas fa-box"></li> Data Mutasi Barang
          </h3>
          <div class="card-tools">
            <a href="<?= base_url('leader/Dashboard') ?>" type="button" class="btn btn-tool">
              <i class="fas fa-times"></i>
            </a>
          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <a href="<?= base_url('leader/mutasi/add') ?>" class="btn btn-success btn-sm float-right mb-3">
                <li class="fa fa-plus"></li> Buat Mutasi
              </a>
            </div>
            <hr>
          </div>
          <!-- isi konten -->
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr class="text-center">
                <th>No</th>
                <th style="width: 14%;">Kode Mutasi</th>
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
                  <td class="text-center"><?= $no ?></td>
                  <td class="text-center"><?= $data->id ?></td>
                  <td>
                    <small><b>Asal :</b> <?= $data->asal ?> </small><br>
                    <small><b>Tujuan :</b> <?= $data->tujuan ?> </small>
                  </td>
                  <td class="text-center"><?= date("d F Y, H:i:s", strtotime($data->created_at));  ?></td>
                  <td class="text-center"><?= status_mutasi($data->status) ?></td>
                  <td>
                    <button type="button" class="btn btn-sm btn-danger float-right  <?= ($data->status != "0") ? 'disabled' : 'btn_hapus'; ?>" data-id="<?= $data->id ?>" title="Hapus Mutasi" style="margin-right: 3px;"><i class="fa fa-trash"></i></button>
                    <a type="button" class="btn btn-sm btn-default float-right <?= ($data->status != "1") ? 'disabled' : ''; ?>" title="Print Surat Jalan." target="_blank" href="<?= base_url('leader/Mutasi/mutasi_print/' . $data->id) ?>" style="margin-right: 3px;"><i class="fa fa-print" aria-hidden="true"></i></a>
                    <!-- <a href="<?= base_url('leader/Mutasi/edit/' . $data->id) ?>" class="btn btn-sm btn-warning float-right <?= ($data->status == "0") ? '' : 'd-none'; ?>" title="Edit Mutasi" style="margin-right: 3px;"><i class="fa fa-edit"></i></a>
                    <a href="<?= base_url('leader/Mutasi/bap/' . $data->id) ?>" class="btn btn-sm btn-warning float-right <?= ($data->status == "0" || $data->status == "1" || $data->status == "4" || $data->status == "5") ? 'd-none' : ''; ?>" title="Ajukan BAP Mutasi" style="margin-right: 3px;"><i class="fa fa-reply"></i></a> -->
                    <a href="<?= base_url('leader/Mutasi/detail/' . $data->id) ?>" class="btn btn-sm btn-info float-right " title="Detail Mutasi" style="margin-right: 3px;"><i class="fa fa-eye"></i></a>
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
    });


  })
</script>
<script>
  $('.btn_hapus').click(function(e) {
    const id = $(this).data('id');
    e.preventDefault();
    Swal.fire({
      title: 'Hapus Data',
      text: "Apakah anda yakin untuk Menghapusnya ?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        location.href = "<?php echo base_url('leader/Mutasi/hapus_data/') ?>" + id;
      }
    })
  })
</script>
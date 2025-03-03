<section class="content">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-cart-plus"></i> <?= $title ?></h3>
        <div class="card-tools">
          <a href="<?= base_url('spg/Dashboard') ?>" type="button" class="btn btn-tool">
            <i class="fas fa-times"></i>
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <a href="<?= base_url('spg/penjualan/tambah_penjualan') ?>" class="btn btn-sm btn-success ml-auto">
            <li class="fas fa-plus"></li> Input Penjualan
          </a>
        </div>
        <hr>
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th>No Penjualan</th>
              <th class="text-center">Menu</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            foreach ($list_penjualan as $row) {
              $no++ ?>
              <tr>
                <td class="text-center"><?= $no ?></td>
                <td>
                  <small>
                    <strong><?= $row->id ?></strong> <br>
                    <?= date("d F Y", strtotime($row->tanggal_penjualan)) ?>
                  </small>
                </td>
                <td class="text-center">
                  <a class="btn btn-primary btn-sm" href="<?= base_url('spg/Penjualan/detail/') . $row->id ?>" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                  <!-- <a class="btn btn-danger btn-sm btn_delete <?= date('m Y', strtotime($row->created_at)) != date('m Y') ? 'disabled' : '' ?>" href="#" data-id="<?= $row->id ?>" title="Hapus"><i class="fa fa-trash"></i></a> -->
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
</section>
<script>
  $('.btn_delete').click(function(e) {
    const id = $(this).data('id');
    e.preventDefault();
    Swal.fire({
      title: 'Apakah anda yakin ?',
      text: " Data yang dihapus tidak bisa di kembalikan lagi.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        location.href = "<?php echo base_url('spg/Penjualan/hapus_data/') ?>" + id;
      }
    })
  })
</script>
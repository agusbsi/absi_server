<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <?php if (($toko->status_so) == 1) { ?>
          <!-- jika toko belum so -->
          <!-- eror page -->
          <div class="error-page">
            <h2 class="headline text-success"> <i class="fas fa-check-circle"></i></h2>

            <div class="error-content">
              <h3><i class="fas fa-file-alt text-success"></i> STOK OPNAME BERHASIL !</h3>

              <p>
                Terima kasih, Anda telah melakukan Stok Opname di bulan ini ! Data sedang di proses oleh Admin Support Hicoop.
              </p>

              <form class="search-form">
                <div class="input-group text-center">
                  <a href="<?php echo base_url('spg/dashboard') ?>" class="btn btn-success"> Ke Beranda</a>
                </div>
                <!-- /.input-group -->
              </form>
            </div>
            <!-- /.error-content -->
          </div>
          <!-- end eror page -->
          <!-- end toko so -->

        <?php } else { ?>
          <form action="<?= base_url('spg/stok_opname/simpan_so') ?>" method="post" id="form-so">
            <div class="card card-info ">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-pie"></i> Stok Opname Artikel</b> </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Toko</label>
                      <input type="text" value="<?= $toko->nama_toko ?>" class="form-control form-control-sm" readonly>
                      <input type="hidden" name="id_toko" value="<?= $toko->id ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>PT</label>
                      <input type="text" value="<?= $this->session->userdata('pt') ?>" class="form-control form-control-sm" readonly>
                    </div>
                  </div>

                </div>
                <hr>
                <div class="form-group">
                  <label for="">Tanggal SO</label>
                  <input type="date" name="tgl_so" class="form-control form-control-sm" max="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d', strtotime('-26 days')) ?>" required>
                </div>
                <hr>
                <!-- list data produk di toko -->
                <table id="table_stok" class="table table-bordered table-striped">
                  <thead>
                    <tr class="text-center">
                      <th style="width:5%">No</th>
                      <th>Artikel</th>
                      <th>Hasil SO <small>(Stok di Toko)</small></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php
                      $no = 0;
                      foreach ($stok_produk as $stok) {
                        $no++
                      ?>
                        <td><?= $no ?></td>
                        <td>
                          <small>
                            <b><?= $stok->kode ?></b>
                            <br>
                            <?= $stok->nama_produk ?>
                          </small>
                          <input type="hidden" name="id_produk[]" value="<?= $stok->id_produk ?>">
                          <input type="hidden" name="qty_awal[]" value="<?php if (empty($stok->qty_awal)) {
                                                                          echo $stok->qty_awal = 0;
                                                                        } else {
                                                                          echo $stok->qty_awal;
                                                                        } ?>">
                        </td>
                        <td style="width:35%"> <input type="number" name="qty_input[]" min="0" class="form-control form-control-sm" required></td>
                    </tr>
                  <?php
                      } ?>

                  </tbody>
                </table>
                <div class="form-group">
                  <label for="">Catatan :</label>
                  <textarea name="keterangan" class="form-control form-control-sm" placeholder="Silahkan tambahkan keterangan jika ada"></textarea>
                </div>
                <hr>
                <div class="text-center p-3">
                  <button type="reset" class="btn btn-danger">
                    <li class="fa fa-times-circle"></li> Reset
                  </button>
                  <button type="submit" class="btn btn-success ml-3" id="btn-kirim"><i class="fa fa-paper-plane"></i> Kirim Data</button>
                </div>
              </div>
            </div>
      </div>
      </form>
    <?php } ?>
    </div>
  </div>
  </div>
</section>
<!-- jQuery -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    // table
    $('#tablestok').DataTable({
      order: [
        [1, 'asc']
      ],
      responsive: true,
      lengthChange: false,
      autoWidth: false,
    });
    // end tabel
  })
</script>
<script type="text/javascript">
  function validateForm() {
    let isValid = true;
    // Get all required input fields
    $('#form-so').find('input[required], select[required], textarea[required]').each(function() {
      if ($(this).val() === '') {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });
    return isValid;
  }
  $('#btn-kirim').click(function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data Stok Opname akan di proses. !",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {

        if (validateForm()) {
          document.getElementById("form-so").submit();
        } else {
          Swal.fire({
            title: 'Belum Lengkap',
            text: ' Semua kolom  harus di isi.',
            icon: 'error',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        }
      }
    })
  })
</script>
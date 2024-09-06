<style>
  .foto_so {
    width: 100%;
    max-width: 150px;
    height: auto;
  }

  .area-footer {
    text-align: center;
    margin-bottom: 5px;
  }

  .area-footer small {
    display: block;
  }

  .waktu {
    font-size: 16px;
    font-weight: 700;
    padding: 6px 20px;
    background-color: #3e007c;
    color: #ff9628;
    margin: 15px 30%;
    border-radius: 25px;
    letter-spacing: 2px;
  }

  .waktu-open {
    font-size: 16px;
    font-weight: 700;
    padding: 6px 20px;
    background-color: rgb(33, 136, 56);
    color: #ffffff;
    margin: 15px 30%;
    border-radius: 25px;
    letter-spacing: 2px;
  }
</style>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <?php if (($toko->status_so) == 1) { ?>
          <div class="row text-center">
            <div class="col-md-6">
              <img src="<?= base_url('assets/img/komplet.svg') ?>" alt="complete" class="foto_so">
            </div>
            <div class="col-md-6" style="padding-top: 30px;">
              <h3>Stok Opname Berhasil</h3>
              <p>Terima kasih, kamu telah selesai melakukan stok opname artikel di bulan ini.
                data akan di verifikasi oleh tim Operasional ABSI.</p>
            </div>
          </div>
          <hr>

          <div class="area-footer">
            <small>* Jika data SO belum sesuai, kamu bisa memperbaruinya selama waktu tersedia atau bisa hubungi tim operasional.</small>
            <input type="hidden" id="waktuSo" value="<?= $dataSo ? $dataSo->created_at : '' ?>">
            <?php if ($dataSo->status == 1) { ?>
              <div class="waktu-open">Terbuka</div>
              <a href="<?php echo base_url('spg/dashboard') ?>" class="btn btn-sm btn-success" title="Ke Beranda"> <i class="fas fa-home"></i> Beranda</a>
              <a href="<?php echo base_url('spg/Stok_opname/detail/' . $dataSo->id . '/edit') ?>" class="btn btn-sm btn-warning" title="Edit Data"> <i class="fas fa-edit"></i> Edit</a>
              <a href="<?php echo base_url('spg/Stok_opname/detail/' . $dataSo->id . '/tampil') ?>" class="btn btn-sm btn-primary" title="Lihat Detail"> Lihat <i class="fas fa-arrow-right"></i></a>
            <?php } else { ?>
              <div class="waktu" id="waktu"></div>
              <a href="<?php echo base_url('spg/dashboard') ?>" class="btn btn-sm btn-success" title="Ke Beranda"> <i class="fas fa-home"></i> Beranda</a>
              <a href="<?php echo base_url('spg/Stok_opname/detail/' . $dataSo->id . '/edit') ?>" class="btn btn-sm btn-warning" title="Edit Data" id="editButton"> <i class="fas fa-edit"></i> Edit</a>
              <a href="<?php echo base_url('spg/Stok_opname/detail/' . $dataSo->id . '/tampil') ?>" class="btn btn-sm btn-primary" title="Lihat Detail"> Lihat <i class="fas fa-arrow-right"></i></a>
            <?php } ?>
          </div>

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
                  <button type="reset" class="btn btn-sm btn-danger">
                    <li class="fa fa-times-circle"></li> Reset
                  </button>
                  <button type="submit" class="btn btn-sm btn-success ml-3" id="btn-kirim"><i class="fa fa-paper-plane"></i> Kirim Data</button>
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
<script>
  const waktuSo = new Date($('#waktuSo').val()).getTime();
  const targetTime = waktuSo + (23 * 60 * 60 * 1000);

  function updateCountdown() {
    const now = new Date().getTime();
    const distance = targetTime - now;
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    const formattedTime = `${String(hours).padStart(2, '0')} : ${String(minutes).padStart(2, '0')} : ${String(seconds).padStart(2, '0')}`;
    document.getElementById('waktu').textContent = formattedTime;
    const editButton = document.getElementById('editButton');
    if (distance < 0) {
      clearInterval(interval);
      document.getElementById('waktu').textContent = 'Terkunci';
      $('#editButton').addClass('disabled').attr('disabled', true);
      return;
    }
  }
  const interval = setInterval(updateCountdown, 1000);
  updateCountdown();
</script>
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
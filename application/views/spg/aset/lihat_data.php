<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <?php if (($toko->status_aset) == 1) { ?>
          <div class="error-page">
            <h2 class="headline text-success"> <i class="fas fa-check-circle"></i></h2>
            <div class="error-content">
              <h3> UPDATE ASET BERHASIL !</h3>
              <p>
                Terimakasih, Anda telah melakukan Update Aset Toko di bulan ini ! Data akan di proses oleh Admin Support Hicoop.
              </p>
              <hr>
              <div class="input-group text-center">
                <a href="<?php echo base_url('spg/Stok_opname') ?>" class="btn btn-success"> Lanjut Stok Opname <i class="fa fa-arrow-right"></i></a>
              </div>
            </div>
          </div>

        <?php } else { ?>
          <?php
          if (empty($list_aset)) {
          ?>
            <form action="<?= base_url('spg/Aset/update'); ?>" method="post">
              <div class="callout callout-danger">
                <div class="col-lg-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="fas fa-dolly"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">ASET KOSONG</span>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="form-group mb-0">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1" required>
                    <label class="custom-control-label" for="exampleCheck1">Saya memastikan di toko <span class="text-info"><?= $toko->nama_toko ?></span> tidak ada aset perusahaan.</label>
                  </div>
                </div>
              </div>
              <hr>
              <small>* Jika Nama aset tidak ada,silahkan hubungi tim Operasional ABSI .</small>
              <hr>
              <button type="submit" class="btn btn-sm btn-success mb-2 float-right"> <i class="fas fa-save"></i> Update Aset</button>
              <a href="<?= base_url('spg/Dashboard') ?>" class="btn btn-sm btn-danger mb-2 float-right mr-2"> <i class="fas fa-times"></i> Cancel</a>

            </form>
          <?php } else { ?>

            <form id="form_aset" action="<?= base_url('spg/Aset/updateFotoAset'); ?>" method="POST" enctype="multipart/form-data">
              <?php
              $no = 0;
              foreach ($list_aset as $row) :
                $no++ ?>
                <div class="card card-info card-outline ">
                  <div class="card-header">
                    <h6 class="card-title"><?= $no ?>). <?= $row->aset ?></h6>
                  </div>
                  <div class="card-body">
                    <div class="form-group mb-0">
                      <label style="font-size: small; margin-bottom:0px;">No Aset :</label>
                      <input type="hidden" name="id_aset_toko[]" class="form-control" value="<?= $row->id ?>">
                      <input type="text" class="form-control form-control-sm" value="<?= $row->no_aset ?>" readonly>
                    </div>
                    <div class="form-group mb-0">
                      <label style="font-size: small; margin-bottom:0px;">Foto Aset :</label>
                      <input type="file" name="foto_aset[]" class="form-control form-control-sm" accept="image/png, image/jpeg, image/jpg" required>
                      <small class="text-secondary">* Foto aset terbaru</small>
                    </div>
                    <div class="form-group mb-0">
                      <label style="font-size: small; margin-bottom:0px;">Jumlah :</label>
                      <input type="number" name="jumlah[]" class="form-control form-control-sm" placeholder="jumlah..." required>
                    </div>
                    <div class="form-group mb-0">
                      <label style="font-size: small; margin-bottom:0px;">Kondisi :</label>
                      <textarea name="keterangan[]" class="form-control form-control-sm" rows="2" placeholder="Kondisi..." required></textarea>
                    </div>
                  </div>
                </div>
              <?php endforeach
              ?>
              <hr>
              <small>* Jika Nama aset tidak ada,silahkan hubungi tim Operasional ABSI .</small>
              <hr>
              <button type="submit" id="btn_aset" class="btn btn-sm btn-success mb-2 float-right"> <i class="fas fa-save"></i> Update Aset</button>
              <a href="<?= base_url('spg/Dashboard') ?>" class="btn btn-sm btn-danger mb-2 float-right mr-2"> <i class="fas fa-times"></i> Cancel</a>
            </form>
          <?php }
          ?>
      </div>
    </div>
  </div>

<?php } ?>
</div>
</div>
</div>
</section>
<script>
  // Function to check if all required fields are filled
  function validateForm() {
    let isValid = true;
    // Get all required input fields
    $('#form_aset').find('input[required], select[required], textarea[required]').each(function() {
      if ($(this).val() === '') {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });
    return isValid;
  }

  $('#btn_aset').click(function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data aset Toko akan di update !",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        if (validateForm()) {
          document.getElementById("form_aset").submit();
        } else {
          Swal.fire({
            title: 'Belum Lengkap',
            text: ' Semua kolom foto, jumlah, & keterangan harus di isi.',
            icon: 'error',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        }
      }
    });
  });
</script>
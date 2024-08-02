<style>
  #signature-pad {
    border: 2px solid blue;
    border-radius: 5px;
    width: 250px;
    height: 200px;
    cursor: pointer;
    padding: 5px;
    margin: 5px;
  }

  .signature-pad canvas {
    width: 100%;
    height: 100%;
  }

  .ttd_img {
    width: 100%;
    height: auto;
    border: 2px solid blue;
    border-radius: 5px;
  }
</style>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <div class="card card-primary card-outline">
          <form action="<?= base_url('Profile/update_foto') ?>" method="post" enctype="multipart/form-data">
            <div class="card-header">
              Foto Profil
            </div>
            <div class="card-body box-profile">
              <div class="text-center">
                <?php if ($profil->foto_diri == null) { ?>
                  <img class="img-profil" style="width: 200px; height:auto; border-radius:5%" src="<?= base_url('assets/img/user.png') ?>" alt="User profile picture">
                <?php } else { ?>
                  <img class="img-profil" style="width: 200px; height:auto; border-radius:5%" src="<?= base_url('assets/img/user/') . $profil->foto_diri ?>" alt="User profile picture">
                <?php } ?>
              </div>
              <div class="form-group mt-2">
                <label for="">Ganti Foto</label>
                <input type="hidden" name="id" value="<?= $profil->id ?>">
                <input type="file" class="form-control form-control-sm" name="foto" multiple accept="image/png, image/jpeg, image/jpg" required>
              </div>
            </div>
            <div class="card-footer text-center">
              <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-9">
        <div class="card card-primary card-outline">
          <form method="POST" action="<?= base_url('profile/update') ?>">
            <div class="card-header">
              <h3 class="card-title">
                <li class="fas fa-file"></li> Biodata
              </h3>
            </div>
            <div class="card-body ">
              <div class="form-group mb-1">
                <label>Nama Lengkap *</label>
                <input class="form-control" type="hidden" name="id_user" value="<?= $profil->id ?>">
                <input type="text" name="nama" class="form-control form-control-sm" value="<?= $profil->nama_user ?>" placeholder="...." required>
              </div>
              <div class="form-group mb-1">
                <label>Telp *</label>
                <input type="number" name="telp" class="form-control form-control-sm" value="<?= $profil->no_telp ?>" placeholder="...." required>
              </div>
              <div class="form-group">
                <label for="">Alamat</label>
                <textarea name="alamat" class="form-control form-control-sm"><?= $profil->alamat ?></textarea>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-sm btn-primary float-right"><i class="fas fa-save"></i> Simpan</button>
            </div>
          </form>
        </div>
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">
              <li class="fas fa-signature"></li> Tanda Tangan
            </h3>
          </div>
          <div class="card-body ">
            <div class="row">
              <div class="col-md-5">

                <div id="signature-pad" class="signature-pad <?= (empty($profil->ttd)) ? '' : 'd-none' ?>">
                  <canvas></canvas>
                </div>
                <div id="area-img" class="text-center <?= (empty($profil->ttd)) ? 'd-none' : '' ?>">
                  TTD Saat ini :
                  <img src="<?= base_url('assets/img/ttd/' . $profil->ttd) . '?t=' . time(); ?>" class="ttd_img mb-1">
                  <button type="button" id="btn_edit_ttd" class="btn btn-sm btn-outline-primary "><i class="fas fa-edit"></i> Ganti</button>
                  <a href="<?= base_url('Profile/reset_ttd') ?>" class="btn btn-sm btn-outline-danger "><i class="fas fa-trash"></i> Kosongkan</a>
                </div>
              </div>
              <div class="col-md-1"></div>
              <div class="col-md-6">
                <strong># Cara Menggunakan :</strong>
                <li>Tekan & Tahan Kursor, Lalu gerakan sesuai Pola TTD Anda.</li>
                <li>Buat Pola di tengah agar rapi.</li>
                <li>Lalu klik Simpan.</li>
                <li>Selesai.</li>
                <br>
                <strong># Tanda Tangan ini akan otomatis di tempelkan ke :</strong>
                <li>Semua Surat/form yang anda buat.</li>
                <li>Semua Surat/form yang anda Setujui.</li>
              </div>
            </div>
          </div>
          <div id="menu_footer" class="card-footer <?= (empty($profil->ttd)) ? '' : 'd-none' ?>">
            <button type="submit" id="save_ttd" class="btn btn-sm btn-primary "><i class="fas fa-save"></i> Simpan</button>
            <button type="button" id="clear" class="btn btn-sm btn-warning "><i class="fas fa-magic"></i> Clear</button>
          </div>
        </div>
        <div class="card card-warning card-outline">
          <form method="POST" action="<?= base_url('profile/ganti_password') ?>">
            <div class="card-header">
              <h3 class="card-title">
                <li class="fas fa-key"></li> Ganti Password
              </h3>
            </div>
            <div class="card-body ">
              <div class="form-group mb-1">
                <label>Akses</label>
                <input class="form-control form-control-sm" type="text" value="<?= $lihat_role->nama ?>" readonly>
              </div>
              <div class="form-group mb-1">
                <label>Username</label>
                <input class="form-control" type="hidden" name="id_user" value="<?= $profil->id ?>">
                <input class="form-control form-control-sm" type="text" name="username" value="<?= $profil->username ?>" readonly>
              </div>
              <div class="form-group">
                <label>Password saat ini</label>
                <input class="form-control form-control-sm" type="password" name="pass_lama" placeholder="...." autocomplete="off" required>
              </div>
              <div class="form-group">
                <label>Password Baru</label>
                <input class="form-control form-control-sm" type="password" name="pass_baru" placeholder="...." autocomplete="off" required>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-sm btn-primary float-right"><i class="fas fa-save"></i> Ganti Password</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
  var canvas = document.querySelector("canvas");
  var signaturePad = new SignaturePad(canvas);

  document.getElementById('clear').addEventListener('click', function() {
    signaturePad.clear();
  });
  document.getElementById('btn_edit_ttd').addEventListener('click', function() {
    $('#area-img').addClass('d-none');
    $('#signature-pad').removeClass('d-none');
    $('#menu_footer').removeClass('d-none');
  });

  document.getElementById('save_ttd').addEventListener('click', function() {
    if (!signaturePad.isEmpty()) {
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Pola tanda tangan anda akan di simpan.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Yakin'
      }).then((result) => {
        if (result.isConfirmed) {
          var dataURL = signaturePad.toDataURL();
          fetch('<?= base_url('Profile/signature') ?>', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                image: dataURL
              })
            })
            .then(response => response.json())
            .then(data => {
              if (data.status === 'success') {
                Swal.fire({
                  title: 'BERHASIL',
                  text: 'Pola Tanda Tangan berhasil di simpan',
                  icon: 'success',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK'
                }).then(() => {
                  window.location.reload();
                });
              } else {
                Swal.fire({
                  title: 'GAGAL',
                  text: 'Pola Tanda Tangan Gagal di simpan',
                  icon: 'error',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK'
                });
              }
            })
            .catch(error => {
              console.error('Error:', error);
            });
        }
      })
    } else {
      Swal.fire({
        title: 'KOSONG',
        text: 'Pola Tanda Tangan masih kosong.',
        icon: 'error',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    }
  });
</script>
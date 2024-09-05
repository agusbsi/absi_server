<style>
  #signature {
    width: 330px;
    height: 250px;
    border: 1px solid #e8e8e8;
    background-color: #fff;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08) inset;
    border-radius: 4px;
  }

  .ttd_img {
    width: 330px;
    height: auto;
    border: 2px solid blue;
    border-radius: 5px;
    padding: 10px;
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
              <div class="col-md-6">
                <div id="signature" class="<?= (empty($profil->ttd)) ? '' : 'd-none' ?>"></div>
                <div id="area-img" class="text-center <?= (empty($profil->ttd)) ? 'd-none' : '' ?>">
                  TTD Saat ini :
                  <img src="<?= base_url('assets/img/ttd/' . $profil->ttd) . '?t=' . time(); ?>" class="ttd_img mb-1">
                  <button type="button" id="btn_edit_ttd" class="btn btn-sm btn-outline-primary "><i class="fas fa-edit"></i> Ganti</button>
                  <a href="<?= base_url('Profile/reset_ttd') ?>" class="btn btn-sm btn-outline-danger "><i class="fas fa-trash"></i> Hapus</a>
                </div>
                <small>
                  <strong># Cara Menggunakan :</strong>
                  <li>Tekan & Tahan Kursor, Lalu gerakan sesuai Pola TTD Anda.</li>
                  <li>Buat Pola di tengah agar rapi.</li>
                  <li>Lalu klik Simpan.</li>
                  <li>Selesai.</li>
                </small>
                <div id="menu_footer" class="card-footer text-center <?= (empty($profil->ttd)) ? '' : 'd-none' ?>">
                  <button type="button" id="save_ttd" class="btn btn-sm btn-primary "><i class="fas fa-save"></i> Simpan</button>
                  <button type="button" id="clear" class="btn btn-sm btn-warning "><i class="fas fa-magic"></i> Clear</button>
                </div>
              </div>
              <div class="col-md-1 text-center <?= (empty($profil->ttd)) ? '' : 'd-none' ?>" style="padding-top:15%">
                Atau
              </div>
              <div class="col-md-4 text-center <?= (empty($profil->ttd)) ? '' : 'd-none' ?>">
                <form action="<?= base_url('Profile/update_ttd') ?>" method="post" enctype="multipart/form-data">
                  <div class="form-group" style="padding-top: 30%; margin-bottom:120px;">
                    <label for="ttd">Upload foto TTD</label>
                    <input type="file" name="ttd" class="form-control form-control-sm" placeholder="pilih file" accept="image/png" required>
                  </div>
                  <hr>
                  <small class="text-left">
                    <li> Jenis foto : .PNG</li>
                    <li> pilih foto yg transparant</li>
                    <li> Maksimal 2mb</li>
                    <li> Ukuran : 330 x 250 pixel</li>
                  </small>
                  <div id="menu_footer" class="card-footer text-center <?= (empty($profil->ttd)) ? '' : 'd-none' ?>">
                    <button type="submit" class="btn btn-sm btn-primary "><i class="fas fa-save"></i> Simpan</button>
                  </div>
                </form>
              </div>
            </div>
            <hr>
            <strong># Tanda Tangan ini akan otomatis di tempelkan ke :</strong>
            <li>Semua Surat/form yang anda buat.</li>
            <li>Semua Surat/form yang anda Setujui.</li>
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
<script src="https://cdn.jsdelivr.net/npm/lemonadejs/dist/lemonade.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@lemonadejs/signature/dist/index.min.js"></script>

<script>
  const root = document.getElementById("signature");
  const component = Signature(root, {
    width: 330,
    height: 250,
  });

  document.getElementById('clear').addEventListener('click', function() {
    component.value = [];
  });

  document.getElementById('btn_edit_ttd').addEventListener('click', function() {
    document.getElementById('area-img').classList.add('d-none');
    document.getElementById('signature').classList.remove('d-none');
    document.getElementById('menu_footer').classList.remove('d-none');
  });

  document.getElementById('save_ttd').addEventListener('click', function() {
    if (component.value.length === 0) {
      Swal.fire({
        title: 'KOSONG',
        text: 'Pola Tanda Tangan masih kosong.',
        icon: 'error',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    } else {
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Pola tanda tangan anda akan disimpan.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Yakin'
      }).then((result) => {
        if (result.isConfirmed) {
          var dataURL = component.getImage();
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
                  text: 'Pola Tanda Tangan berhasil disimpan',
                  icon: 'success',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK'
                }).then(() => {
                  window.location.reload();
                });
              } else {
                Swal.fire({
                  title: 'GAGAL',
                  text: 'Pola Tanda Tangan gagal disimpan',
                  icon: 'error',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK'
                });
              }
            })
            .catch(error => {
              console.error('Error:', error);
              Swal.fire({
                title: 'GAGAL',
                text: 'Terjadi kesalahan saat menyimpan.',
                icon: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
              });
            });
        }
      });
    }
  });
</script>
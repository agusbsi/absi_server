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
                <input class="form-control form-control-sm" type="password" name="pass_lama" placeholder="...." required>
              </div>
              <div class="form-group">
                <label>Password Baru</label>
                <input class="form-control form-control-sm" type="password" name="pass_baru" placeholder="...." required>
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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <title>ABSI | Konsinyasi</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/dist/css/adminlte.min.css">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .toko {
      display: flex;
      align-items: flex-start;
      gap: 10px;
    }

    .toko i {
      font-size: 32px;
      margin-top: 7px;
    }

    .namaToko {
      display: flex;
      flex-direction: column;
    }
  </style>
</head>

<body class="hold-transition login-page">
  <?php
  if ($this->session->flashdata('type')) { ?>
    <script>
      var type = "<?= $this->session->flashdata('type'); ?>"
      var title = "<?= $this->session->flashdata('title'); ?>"
      var text = "<?= $this->session->flashdata('text'); ?>"
      Swal.fire(title, text, type)
    </script>
  <?php } ?>
  <div class="wrapper">
    <div class="container">
      <div class="card mt-5">
        <div class="card-body">
          <h3>Hai, <?= ucwords($nama_spg) ?></h3>
          <p>Anda memiliki <b><?= $jumlah_toko ?></b> toko yang bisa dikelola, silahkan pilih toko terlebih dahulu !</p>
          <hr>
          <div class="row mt-5">
            <?php foreach ($list_toko as $row) { ?>
              <div class="col-md-4">
                <div class="card card-primary card-outline">
                  <div class="card-body">
                    <div class="toko">
                      <i class="fas fa-store"></i>
                      <div class="namaToko">
                        <strong><?= $row->nama_toko ?></strong>
                        <small><?= $row->alamat ?></small>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer text-center">
                    <a href="<?= base_url('login/pilih_toko_act/') . $row->id_toko ?>" class="btn btn-sm btn-outline-primary"><strong>Pilih Toko</strong></a>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- jQuery -->
  <script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url() ?>/assets/dist/js/adminlte.min.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <title>ABSI | Konsinyasi</title>
  <link href="<?= base_url() ?>/assets/img/app/icon_absi.png" rel="icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/dist/css/adminlte.min.css">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <section>
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <img src="<?php base_url() ?>assets/img/app/Absi-Login.jpg">
        </div>
        <div class="card-body">
          <form>
            <div class="form-group">
              <label>Pilih Perusahaan</label>
              <select id="database" class="form-control">
                <option value="1">PT.VISTA</option>
                <option value="2">PT.PASIFIK</option>
                <option value="3">PT.ATOP</option>
                <option value="4">PT.MAP</option>
                <option value="5">PT.MIC</option>
              </select>
            </div>
            <div class="social-auth-links text-center mt-2 mb-3">
              <button type="button" class="btn btn-primary btn-block" id="btnPilih">Pilih</button>
            </div>
          </form>
          <!-- /.social-auth-links -->
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
  </div>
  <!-- /.login-box -->
  </section>
  <br>
  <br>
  <footer class="text-center">
    Copyright @ 2023, GlobalIndo group <br> <b>Version</b> 1.2
  </footer>

  <!-- jQuery -->
  <script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url() ?>/assets/dist/js/adminlte.min.js"></script>
</body>

</html>
<script type="text/javascript">
  $("#btnPilih").click(function() {
    var choose = $("#database").val();
    if (choose == 1) {
      window.location.href = "<?= base_url() ?>login";
    } else if (choose == 2) {
      window.location.href = "<?= base_url() ?>login";
    } else if (choose == 3) {
      window.location.href = "<?= base_url() ?>login";
    } else if (choose == 4) {
      window.location.href = "<?= base_url() ?>login";
    } else if (choose == 5) {
      window.location.href = "<?= base_url() ?>login";
    }
  })
</script>
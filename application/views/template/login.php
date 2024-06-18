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
  <?php
  if ($this->session->flashdata('type')) { ?>
    <script>
    var type = "<?= $this->session->flashdata('type'); ?>"
    var title = "<?= $this->session->flashdata('title'); ?>"
    var text = "<?= $this->session->flashdata('text'); ?>"
    Swal.fire(title,text,type)
    </script>
  <?php } ?>
<div class="login-box">

<section>
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <img src="<?php base_url() ?>assets/img/app/Absi-Login.jpg">
      <!-- <a href="#" class="h1"><b>ABSI</b></a> <br>
      <small>Aplikasi Bantuan Konsinyasi</small> -->
    </div>
    <div class="card-body">
      <p class="login-box-msg"><strong>- PT.VISTA -</strong></p>

      <form action="<?= base_url('login/proses_login') ?>" method="post">
        <div class="input-group mb-3">
          <input name="username" type="text" class="form-control" placeholder="Username" required="">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="password" type="password" class="form-control" placeholder="Password" required="">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="social-auth-links text-center mt-2 mb-3">
          <input id="longitude" name="longitude" type="hidden" class="form-control">
          <input id="latitude" name="latitude" type="hidden" class="form-control">
          <input type="hidden" name="token" value="<?= $token_generate ?>">
          <input class="btn btn-primary btn-block" type="submit" value="LOGIN">
          <hr>
          <a href="https://globalindo-group.com/absi/" class="btn btn-danger btn-block" ><i class="fas fa-arrow-left"></i> Kembali Pilih Perusahaan</a>
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

<!-- <script>
$(".alert-dismissible").fadeTo(2000, 500).slideUp(500, function(){
    $(".alert-dismissible").alert('close');
})
</script> -->

<script>
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(showPosition);
  }  else {
    $('#location').val('Geolocation is not supported by this browser.');
  }
}
function showPosition(position) {
  var longitude = position.coords.longitude;
  var latitude = position.coords.latitude;
  $('#longitude').val(longitude);
  $('#latitude').val(latitude);
}

getLocation()
</script>
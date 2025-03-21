<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta http-equiv="Content-Language" content="en">
  <title><?= $title ?></title>
  <link href="<?= base_url() ?>assets/img/app/icon_absi.png" rel="icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
  <style>
    .img-profil {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      border: 1px solid white;
      outline: 2px solid green;
      outline-offset: 1px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .popup {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .popup-card {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      width: 300px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .popup-card h3 {
      font-weight: bold;
      font-size: large;
    }

    .popup-card img {
      width: 80%;
      border-radius: 10px;
      margin-bottom: 5px;
    }

    .popup-card button {
      margin: 10px;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .popup-card .btn-lanjut {
      background-color: #4CAF50;
      color: white;
    }

    .popup-card .btn-close {
      background-color: #f44336;
      color: white;
    }

    .chat-button {
      background-color: #28a745;
      border-radius: 20px;
      padding: 5px 20px 5px 20px;
      color: #f4f6f9;
      font-size: 14px;
      font-weight: bold;
      position: relative;
      cursor: pointer;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      width: auto;
      height: 30px;
      top: 9px;
    }

    .chat-button a {
      color: #f4f6f9;
    }

    .chat-button::before {
      margin-right: 8px;
    }

    .chat-button a:hover {
      color: #f4f6f9;
    }

    .notification {
      position: absolute;
      top: -8px;
      right: -5px;
      background-color: #FF3B30;
      border-radius: 50%;
      padding: 2px 8px;
      font-size: 12px;
      font-weight: bold;
      border: 1px solid #f7f7f7;
      animation: bounce 1.5s infinite;
    }

    @media (max-width: 600px) {
      .chat-button a {
        justify-content: center;
      }

      .chat-button .desk {
        display: none;
      }

      .pt {
        font-size: 10px;
      }
    }

    @keyframes bounce {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-5px);
      }
    }

    .containerkartu {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 20px;
      margin-bottom: 30px;
    }

    .kartu {
      flex: 1 1 calc(33.333% - 20px);
      background-color: #343a40;
      border-radius: 10px;
      padding: 20px;
      color: white;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    .kartu-ikon {
      position: absolute;
      bottom: -30px;
      left: 10px;
      font-size: 60px;
    }

    .kartu-ikon i {
      color: #007bff;
    }

    .konten {
      text-align: center;
      margin-left: auto;
      margin-right: auto;
    }

    .konten p:first-child {
      font-size: 18px;
      margin: 0;
    }

    .konten h2 {
      font-size: 32px;
      margin: 5px 0;
      font-weight: bold;
    }

    .konten a {
      background-color: #007BFF;
      color: #fff;
      padding: 3px 5px;
      border-radius: 4px;
      text-decoration: none;
    }

    .konten p:last-child {
      font-size: 18px;
      margin: 0;
    }

    .img-dashboard {
      max-width: 200px;
      margin-bottom: 5px;
      position: absolute;
      top: -50px;
      left: 0;
    }

    @media (max-width: 768px) {
      .kartu {
        flex: 1 1 calc(50% - 10px);
      }

      .img-dashboard {
        max-width: 200px;
        margin-bottom: 5px;
        position: relative;
        top: 0;
        right: 0;
      }

    }

    @media (max-width: 480px) {
      .kartu {
        flex: 1 1 100%;
      }

      .img-dashboard {
        max-width: 200px;
        margin-bottom: 5px;
        position: relative;
        top: 0;
        right: 0;
      }
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <?php if ($this->session->flashdata('judul')) : ?>
    <div class="popup" id="popupOverlay">
      <div class="popup-card">
        <h3><?= $this->session->flashdata('judul'); ?></h3>
        <img src="<?= base_url('assets/img/saran.svg') ?>" alt="Gambar">
        <div class="konten">
          <?= $this->session->flashdata('pesan'); ?>
        </div>
        <hr>
        <a class="btn btn-sm btn-default" onclick="closePopup()">Nanti Saja</a>
        <a href="<?= base_url($this->session->flashdata('link')); ?>" class="btn btn-sm btn-success">Ok, Lanjut <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
  <?php endif; ?>
  <?php
  if ($this->session->flashdata('type')) { ?>
    <script>
      var type = "<?= $this->session->flashdata('type'); ?>"
      var title = "<?= $this->session->flashdata('title'); ?>"
      var text = "<?= $this->session->flashdata('text'); ?>"
      Swal.fire(title, text, type)
    </script>
  <?php } ?>

  <?php
  if ($this->session->userdata('id')) {
    set_online($this->session->userdata('id'));
    $id = $this->session->userdata('id');
    $foto = $this->db->query("SELECT foto_diri from tb_user where id ='$id'")->row()->foto_diri;
  }
  ?>
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light  fixed-top no-print">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <span class="pt"><?= $this->session->userdata('pt') ? $this->session->userdata('pt') : '' ?></span>
      <ul class="navbar-nav ml-auto mr-3 mb-1">
        <!-- <div class="chat-button" id="chat_notif">
          <a href="<?= base_url('Profile/chat') ?>">
            <i class="fas fa-comments"></i>
            <span class="desk">Chat</span>
          </a>
        </div> -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <?php if (!empty($foto)) { ?>
              <img src="<?= base_url('assets/img/user/' . $foto) ?>" alt="akun" class="img-profil" title="Akun Anda">
            <?php } else { ?>
              <img src="<?= base_url() ?>assets/img/user.png" alt="akun" class="img-profil" title="Akun Anda">
            <?php } ?>
            <i class="fas fa-caret-down ml-2"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right ">
            <span class="dropdown-item dropdown-header">Akun</span>
            <div class="dropdown-divider"></div>
            <a href="<?= base_url('profile') ?>" class="dropdown-item">
              <i class="fas fa-user mr-1"></i> Profil
            </a>
            <div class="dropdown-divider"></div>
            <a href="javascript:void(0)" class="dropdown-item" onclick="logout()">
              <i class="fas fa-sign-out-alt mr-1"></i> Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4 no-print">
      <a href="<?= base_url('') ?>" class="brand-link">
        <img src="<?= base_url() ?>assets/img/app/logo_a.png" alt="ABSI" class="brand-image">
        <span class="brand-text font-weight-light"><img src="<?= base_url() ?>assets/img/app/logo_b.png" class="brand-logo" style="width:40%;" alt="ABSI"></span>
      </a>
      <?php $this->load->view($sidebar) ?>
    </aside>
    <div class="content-wrapper">
      <section class="content-header mt-5 no-print">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= base_url() . $this->uri->segment('1') . "/" . $this->uri->segment('2') ?>"><?= ucwords(str_replace("_", " ", $this->uri->segment('2'))); ?></a></li>
                <?php if ($this->uri->segment('3')) { ?>
                  <li class="breadcrumb-item active"><?= ucwords(str_replace("_", " ", $this->uri->segment('3'))); ?></li>
                <?php } ?>
              </ol>
            </div>
          </div>
        </div>
      </section>
      <?= $contents ?>
    </div>
  </div>
  <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?= base_url(); ?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="<?= base_url(); ?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="<?php echo base_url() ?>assets/plugins/moment/moment.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/inputmask/jquery.inputmask.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/moment/moment.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/jszip/jszip.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["pdf", "print", "excel"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('.select2').select2()
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
      $('#reservation').daterangepicker({
        format: 'L'
      })
    });

    function closePopup() {
      document.getElementById('popupOverlay').style.visibility = 'hidden';
    }
    $('#calendar').datetimepicker({
      format: 'L',
      inline: true
    })

    function logout() {
      let timerInterval;
      Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah anda yakin ingin keluar aplikasi?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yakin',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.value) {
          Swal.fire({
            title: 'Berhasil!',
            text: 'Berhasil Logout!',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500,
          }).then(() => {
            window.location.href = '<?= base_url('profile/logout') ?>';

          })
        }
      })
    }
  </script>
  <!-- <script>
    let ws = new WebSocket("wss://absiwebsocket.pepri.site");

    function loadList(penerima) {
      fetch(`<?= base_url('Profile/notif'); ?>?penerima=${penerima}`)
        .then(response => response.json())
        .then(data => {
          data.forEach(notification => {
            listChat(notification.jmlPesan);
          });
        });
    }

    function listChat(notif) {
      let chatList = document.getElementById('chat_notif');
      let messageHtml = `
      <a href="<?= base_url('Profile/chat') ?>">
            <i class="fas fa-comments"></i>
            <span class="desk">Chat</span>
        <span class="notification ${notif > 0 ? '' : 'd-none'}">${notif}</span> </a>`;
      chatList.innerHTML = messageHtml;
    }

    function hideChatButton() {
      const chatButton = document.getElementById('chat_notif');
      chatButton.style.display = 'none';
    }
    ws.onmessage = function(event) {
      let data = JSON.parse(event.data);
      loadList(data.penerima);
    };
    ws.onerror = function(error) {
      console.error('WebSocket Error:', error);
    };
    ws.onclose = function() {
      console.log('WebSocket connection closed');
    };
    window.onload = function() {
      let penerima = <?= $this->session->userdata('id') ?>;
      loadList(penerima);
    };
  </script> -->
</body>

</html>
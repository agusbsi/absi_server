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
      width: 38px;
      height: 38px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #fff;
      box-shadow: 0 0 0 2px #dbeafe, 0 4px 10px rgba(15, 23, 42, .12);
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

    /* Modern application header */
    .app-header {
      min-height: 64px;
      padding: 0 18px;
      background: rgba(255, 255, 255, .97) !important;
      border-bottom: 1px solid #e7edf5;
      box-shadow: 0 4px 18px rgba(15, 23, 42, .055);
      backdrop-filter: blur(12px);
    }

    .app-header .sidebar-trigger,
    .app-header .header-action {
      display: inline-flex;
      width: 38px;
      height: 38px;
      align-items: center;
      justify-content: center;
      padding: 0 !important;
      color: #64748b !important;
      background: #f8fafc;
      border: 1px solid #e7edf5;
      border-radius: 10px;
      transition: .18s ease;
    }

    .app-header .sidebar-trigger:hover,
    .app-header .header-action:hover {
      color: #2563eb !important;
      background: #eff6ff;
      border-color: #bfdbfe;
      transform: translateY(-1px);
    }

    .menu-icon {
      position: relative;
      display: flex;
      width: 18px;
      height: 15px;
      flex-direction: column;
      justify-content: space-between;
    }

    .menu-icon span {
      display: block;
      height: 2px;
      background: currentColor;
      border-radius: 999px;
      transform-origin: center;
      transition: width .2s ease, transform .25s cubic-bezier(.4, 0, .2, 1), opacity .18s ease;
    }

    .menu-icon span:nth-child(1) { width: 18px; }
    .menu-icon span:nth-child(2) { width: 13px; }
    .menu-icon span:nth-child(3) { width: 16px; }

    .sidebar-trigger:hover .menu-icon span { width: 18px; }
    .sidebar-trigger:active .menu-icon { transform: scale(.88); }
    .sidebar-trigger .menu-icon { transition: transform .18s ease; }

    .sidebar-trigger.menu-pressed .menu-icon {
      animation: menuIconTap .38s cubic-bezier(.34, 1.56, .64, 1);
    }

    @keyframes menuIconTap {
      45% { transform: scale(.76) rotate(-8deg); }
      100% { transform: scale(1) rotate(0); }
    }

    .mobile-company-name { display: none; }

    .header-page-info {
      min-width: 0;
      margin-left: 13px;
      padding-left: 13px;
      border-left: 1px solid #e7edf5;
      line-height: 1.25;
    }

    .header-page-title {
      display: block;
      max-width: 320px;
      overflow: hidden;
      color: #172033;
      font-size: 14px;
      font-weight: 700;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .header-page-meta {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-top: 3px;
      color: #8492a6;
      font-size: 10px;
    }

    .header-page-meta .live-dot {
      width: 6px;
      height: 6px;
      background: #22c55e;
      border-radius: 50%;
      box-shadow: 0 0 0 3px #dcfce7;
    }

    .company-chip {
      display: inline-flex;
      max-width: 265px;
      height: 36px;
      align-items: center;
      gap: 8px;
      margin-right: 0;
      padding: 0 12px;
      color: #1e40af;
      background: #eff6ff;
      border: 1px solid #dbeafe;
      border-radius: 10px;
      font-size: 11px;
      font-weight: 700;
    }

    .header-action-fullscreen {
      margin-left: 22px !important;
    }

    .connection-status {
      display: inline-flex;
      position: relative;
      width: 38px;
      height: 38px;
      align-items: center;
      justify-content: center;
      flex: 0 0 38px;
      margin-left: 20px !important;
      padding: 0;
      color: #15803d;
      background: #f0fdf4;
      border: 1px solid #bbf7d0;
      border-radius: 11px;
      box-shadow: 0 3px 9px rgba(34, 197, 94, .08);
      font-size: 14px;
      cursor: default;
      transition: .2s ease;
    }

    .connection-status::before {
      position: absolute;
      right: 5px;
      bottom: 5px;
      width: 7px;
      height: 7px;
      content: '';
      background: #22c55e;
      border: 2px solid #f0fdf4;
      border-radius: 50%;
      box-sizing: content-box;
    }

    .connection-status.is-checking {
      color: #a16207;
      background: #fffbeb;
      border-color: #fde68a;
    }

    .connection-status.is-checking i {
      animation: connectionPulse 1s ease-in-out infinite;
    }

    .connection-status.is-checking::before { background: #f59e0b; border-color: #fffbeb; }

    .connection-status.is-medium {
      color: #a16207;
      background: #fffbeb;
      border-color: #fde68a;
      box-shadow: 0 3px 9px rgba(245, 158, 11, .08);
    }

    .connection-status.is-medium::before { background: #eab308; border-color: #fffbeb; }

    .connection-status.is-slow {
      color: #c2410c;
      background: #fff7ed;
      border-color: #fed7aa;
      box-shadow: 0 3px 9px rgba(249, 115, 22, .08);
    }

    .connection-status.is-slow::before { background: #f97316; border-color: #fff7ed; }

    .connection-status.is-offline {
      color: #b91c1c;
      background: #fef2f2;
      border-color: #fecaca;
    }

    .connection-status.is-offline::before { background: #ef4444; border-color: #fef2f2; }

    .connection-status.is-offline::after {
      position: absolute;
      width: 21px;
      height: 2px;
      content: '';
      background: #ef4444;
      border-radius: 2px;
      transform: rotate(45deg);
    }

    .connection-tooltip {
      position: absolute;
      z-index: 1080;
      top: calc(100% + 10px);
      right: -8px;
      width: 165px;
      padding: 11px 12px;
      color: #334155;
      background: #fff;
      border: 1px solid #e7edf5;
      border-radius: 10px;
      box-shadow: 0 12px 28px rgba(15, 23, 42, .15);
      line-height: 1.35;
      text-align: left;
      pointer-events: none;
      opacity: 0;
      transform: translateY(-4px);
      visibility: hidden;
      transition: .16s ease;
    }

    .connection-tooltip::before {
      position: absolute;
      top: -5px;
      right: 21px;
      width: 9px;
      height: 9px;
      content: '';
      background: #fff;
      border-top: 1px solid #e7edf5;
      border-left: 1px solid #e7edf5;
      transform: rotate(45deg);
    }

    .connection-tooltip strong,
    .connection-tooltip small { display: block; }
    .connection-tooltip strong { color: #172033; font-size: 11px; }
    .connection-tooltip small { margin-top: 3px; color: #64748b; font-size: 10px; font-weight: 400; }
    .connection-status:hover .connection-tooltip,
    .connection-status:focus .connection-tooltip { opacity: 1; transform: translateY(0); visibility: visible; }

    @keyframes connectionPulse {
      50% { opacity: .45; transform: scale(.8); }
    }

    .company-chip span {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .header-divider {
      width: 1px;
      height: 28px;
      margin: 0 11px;
      background: #e7edf5;
    }

    .account-toggle {
      display: flex !important;
      height: 52px;
      align-items: center;
      gap: 10px;
      padding: 5px 7px 5px 5px !important;
      color: #172033 !important;
      border-radius: 12px;
      transition: .18s ease;
    }

    .account-toggle:hover,
    .show > .account-toggle {
      background: #f8fafc;
    }

    .account-copy {
      max-width: 145px;
      line-height: 1.2;
    }

    .account-name,
    .account-role {
      display: block;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .account-name { color: #1f2937; font-size: 12px; font-weight: 700; }
    .account-role { margin-top: 3px; color: #8492a6; font-size: 10px; }

    .account-menu {
      width: 285px;
      overflow: hidden;
      margin-top: 7px;
      padding: 0;
      border: 1px solid #e7edf5;
      border-radius: 14px;
      box-shadow: 0 16px 38px rgba(15, 23, 42, .14);
    }

    .account-menu-head {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 17px;
      background: linear-gradient(135deg, #eff6ff, #f8fafc);
      border-bottom: 1px solid #e7edf5;
    }

    .account-menu-head .img-profil { width: 44px; height: 44px; flex: 0 0 44px; }
    .account-menu-name { margin: 0; color: #172033; font-size: 13px; font-weight: 700; }
    .account-menu-user { display: block; margin-top: 3px; color: #64748b; font-size: 10px; }
    .account-menu .dropdown-item { padding: 11px 16px; color: #475569; font-size: 12px; }
    .account-menu .dropdown-item i { width: 23px; color: #94a3b8; text-align: center; }
    .account-menu .dropdown-item:hover { color: #1d4ed8; background: #f8fbff; }
    .account-menu .logout-item { color: #dc2626; border-top: 1px solid #edf1f6; }
    .account-menu .logout-item i { color: #ef4444; }

    .content-header.app-breadcrumb { padding-top: 19px; padding-bottom: 4px; }
    .app-breadcrumb .breadcrumb { padding: 5px 10px; background: transparent; font-size: 11px; }
    .app-breadcrumb .breadcrumb-item a { color: #64748b; }
    .app-breadcrumb .breadcrumb-item.active { color: #2563eb; font-weight: 600; }

    @media (max-width: 991.98px) {
      .app-header { padding: 0 12px; }
      .company-chip, .header-action-fullscreen, .header-divider { display: none !important; }
      .connection-status { margin-right: 10px; margin-left: 0 !important; }
      .account-copy { display: none; }

      body.sidebar-open .menu-icon span:nth-child(1) {
        width: 18px;
        transform: translateY(6.5px) rotate(45deg);
      }
      body.sidebar-open .menu-icon span:nth-child(2) { opacity: 0; transform: scaleX(0); }
      body.sidebar-open .menu-icon span:nth-child(3) {
        width: 18px;
        transform: translateY(-6.5px) rotate(-45deg);
      }
    }

    @media (max-width: 575.98px) {
      .header-page-info { margin-left: 9px; padding-left: 9px; }
      .header-page-title { max-width: 145px; font-size: 12px; }
      .header-page-meta .welcome-copy,
      .header-page-meta .live-dot,
      .header-page-meta #headerClock { display: none; }
      .mobile-company-name {
        display: inline-flex;
        max-width: 155px;
        align-items: center;
        gap: 5px;
        overflow: hidden;
        color: #64748b;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
      .mobile-company-name i { color: #2563eb; font-size: 9px; }
      .app-header .navbar-nav.ml-auto { margin-right: 0 !important; }
      .account-toggle { gap: 5px; padding-right: 2px !important; }
      .account-toggle > .fas { display: none; }
      .connection-status { width: 34px; height: 34px; flex-basis: 34px; justify-content: center; margin-right: 7px; padding: 0; }
      .account-menu { position: fixed !important; top: 59px !important; right: 10px !important; left: auto !important; width: calc(100vw - 20px); transform: none !important; }
      .content-header.app-breadcrumb { padding-top: 17px; }
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
  $foto = '';
  $role_name = 'Pengguna';
  if ($this->session->userdata('id')) {
    set_online($this->session->userdata('id'));
    $id = $this->session->userdata('id');
    $account = $this->db->query(
      'SELECT u.foto_diri, r.nama AS role_name FROM tb_user u LEFT JOIN tb_user_role r ON r.id = u.role WHERE u.id = ?',
      array($id)
    )->row();
    $foto = $account ? $account->foto_diri : '';
    $role_name = ($account && !empty($account->role_name)) ? $account->role_name : 'Pengguna';
  }
  $display_name = $this->session->userdata('nama_user') ?: 'Pengguna ABSI';
  $username = $this->session->userdata('username') ?: '-';
  $company_name = $this->session->userdata('pt') ?: 'ABSI';
  $page_title = !empty($title) ? $title : ucwords(str_replace('_', ' ', $this->uri->segment(2)));
  $avatar_url = !empty($foto) ? base_url('assets/img/user/' . rawurlencode($foto)) : base_url('assets/img/user.png');
  ?>
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top no-print app-header" aria-label="Navigasi utama">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link sidebar-trigger" data-widget="pushmenu" href="#" role="button" aria-label="Buka atau tutup menu" title="Menu utama"><span class="menu-icon" aria-hidden="true"><span></span><span></span><span></span></span></a>
        </li>
      </ul>
      <div class="header-page-info">
        <span class="header-page-title"><?= html_escape($page_title) ?></span>
        <span class="header-page-meta"><i class="live-dot"></i><span id="headerClock">Memuat waktu...</span><span class="welcome-copy">&bull; Selamat bekerja</span><span class="mobile-company-name"><i class="far fa-building"></i><?= html_escape($company_name) ?></span></span>
      </div>
      <ul class="navbar-nav ml-auto mr-1 align-items-center">
        <li class="nav-item company-chip" title="Perusahaan aktif"><i class="far fa-building"></i><span><?= html_escape($company_name) ?></span></li>
        <li class="nav-item connection-status is-checking" id="connectionStatus" aria-label="Memeriksa koneksi ke server" aria-live="polite" tabindex="0">
          <i class="fas fa-wifi" aria-hidden="true"></i><span class="connection-label sr-only">Memeriksa</span>
          <span class="connection-tooltip" aria-hidden="true"><strong class="connection-quality">Memeriksa koneksi</strong><small class="connection-detail">Menghubungi server...</small></span>
        </li>
        <li class="nav-item header-action-fullscreen">
          <a class="nav-link header-action" data-widget="fullscreen" href="#" role="button" aria-label="Layar penuh" title="Layar penuh"><i class="fas fa-expand-arrows-alt"></i></a>
        </li>
        <li class="header-divider" aria-hidden="true"></li>
        <li class="nav-item dropdown">
          <a class="nav-link account-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
            <img src="<?= $avatar_url ?>" alt="Foto profil <?= html_escape($display_name) ?>" class="img-profil" onerror="this.src='<?= base_url('assets/img/user.png') ?>'">
            <span class="account-copy"><span class="account-name"><?= html_escape($display_name) ?></span><span class="account-role"><?= html_escape($role_name) ?></span></span>
            <i class="fas fa-chevron-down text-muted" style="font-size:9px"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right account-menu">
            <div class="account-menu-head">
              <img src="<?= $avatar_url ?>" alt="" class="img-profil" onerror="this.src='<?= base_url('assets/img/user.png') ?>'">
              <div><p class="account-menu-name"><?= html_escape($display_name) ?></p><span class="account-menu-user">@<?= html_escape($username) ?> &bull; <?= html_escape($role_name) ?></span></div>
            </div>
            <a href="<?= base_url('profile') ?>" class="dropdown-item">
              <i class="far fa-user"></i> Lihat &amp; kelola profil
            </a>
            <a href="javascript:void(0)" class="dropdown-item logout-item" onclick="logout()">
              <i class="fas fa-sign-out-alt"></i> Keluar dari aplikasi
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
      <section class="content-header mt-5 no-print app-breadcrumb">
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
  <script>
    (function() {
      var connectionCheckUrl = <?= json_encode(base_url()) ?>;
      var connectionTimer = null;

      function setConnectionStatus(state, latency) {
        var status = document.getElementById('connectionStatus');
        if (!status) return;
        var label = status.querySelector('.connection-label');
        var quality = status.querySelector('.connection-quality');
        var detail = status.querySelector('.connection-detail');
        var offline = state === 'offline';
        var checking = state === 'checking';
        var statusLabel = checking ? 'Memeriksa' : (offline ? 'Terputus' : (state === 'slow' ? 'Lemot' : (state === 'medium' ? 'Sedang' : 'Bagus')));

        status.classList.toggle('is-offline', offline);
        status.classList.toggle('is-checking', checking);
        status.classList.toggle('is-medium', state === 'medium');
        status.classList.toggle('is-slow', state === 'slow');
        label.textContent = statusLabel;
        quality.textContent = 'Koneksi ' + statusLabel;
        detail.textContent = checking
          ? 'Menghubungi server...'
          : (offline ? 'Server tidak dapat dijangkau' : 'Respons server ' + latency + ' ms');
        status.setAttribute('aria-label', checking
          ? 'Memeriksa koneksi ke server'
          : (offline ? 'Koneksi terputus' : 'Koneksi ' + statusLabel.toLowerCase() + ' - ' + latency + ' milidetik'));
      }

      function checkServerConnection(showChecking) {
        if (!navigator.onLine) {
          setConnectionStatus('offline');
          return;
        }

        if (showChecking) setConnectionStatus('checking');
        var startedAt = window.performance && performance.now ? performance.now() : Date.now();
        var controller = typeof AbortController !== 'undefined' ? new AbortController() : null;
        var timeout = controller ? window.setTimeout(function() { controller.abort(); }, 8000) : null;
        var separator = connectionCheckUrl.indexOf('?') === -1 ? '?' : '&';

        fetch(connectionCheckUrl + separator + '_connection_check=' + Date.now(), {
          method: 'HEAD',
          cache: 'no-store',
          credentials: 'same-origin',
          signal: controller ? controller.signal : undefined
        }).then(function(response) {
          if (!response.ok) {
            setConnectionStatus('offline');
            return;
          }
          var endedAt = window.performance && performance.now ? performance.now() : Date.now();
          var latency = Math.max(1, Math.round(endedAt - startedAt));
          var quality = latency < 500 ? 'good' : (latency < 1500 ? 'medium' : 'slow');
          setConnectionStatus(quality, latency);
        }).catch(function() {
          setConnectionStatus('offline');
        }).then(function() {
          if (timeout) window.clearTimeout(timeout);
        });
      }

      function updateHeaderClock() {
        var clock = document.getElementById('headerClock');
        if (!clock) return;
        var now = new Date();
        clock.textContent = new Intl.DateTimeFormat('id-ID', {
          weekday: 'short', day: '2-digit', month: 'short',
          hour: '2-digit', minute: '2-digit', hour12: false
        }).format(now).replace('.', ':');
      }

      updateHeaderClock();
      window.setInterval(updateHeaderClock, 30000);

      var sidebarTrigger = document.querySelector('.sidebar-trigger');
      if (sidebarTrigger) {
        sidebarTrigger.addEventListener('click', function() {
          sidebarTrigger.classList.remove('menu-pressed');
          void sidebarTrigger.offsetWidth;
          sidebarTrigger.classList.add('menu-pressed');
          window.setTimeout(function() { sidebarTrigger.classList.remove('menu-pressed'); }, 420);
        });
      }

      checkServerConnection(true);
      connectionTimer = window.setInterval(function() { checkServerConnection(false); }, 60000);
      window.addEventListener('online', function() { checkServerConnection(true); });
      window.addEventListener('offline', function() { setConnectionStatus('offline'); });
      document.addEventListener('visibilitychange', function() {
        if (!document.hidden) checkServerConnection(true);
      });

      function scrollActiveSidebarMenu() {
        var sidebar = document.querySelector('.main-sidebar .sidebar');

        if (!sidebar) {
          return;
        }

        var activeLinks = sidebar.querySelectorAll('.nav-link.active');
        var activeLink = activeLinks.length ? activeLinks[activeLinks.length - 1] : null;

        if (!activeLink) {
          return;
        }

        // AdminLTE menjadikan viewport OverlayScrollbars sebagai area scroll.
        var scrollContainer = sidebar.querySelector('.os-viewport') || sidebar;
        var containerRect = scrollContainer.getBoundingClientRect();
        var activeRect = activeLink.getBoundingClientRect();

        scrollContainer.scrollTo({
          top: Math.max(0, scrollContainer.scrollTop + activeRect.top - containerRect.top - 16),
          behavior: 'smooth'
        });
      }

      window.addEventListener('load', function() {
        // Beri waktu kepada Layout AdminLTE untuk membuat OverlayScrollbars.
        window.setTimeout(scrollActiveSidebarMenu, 400);
      });

      window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
          window.setTimeout(scrollActiveSidebarMenu, 100);
        }
      });
    })();
  </script>
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

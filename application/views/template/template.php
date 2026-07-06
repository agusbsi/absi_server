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
    }

    /* Premium workspace layer — keeps AdminLTE behavior, replaces its visual skin */
    :root {
      --app-bg: #f3f6fb;
      --app-surface: rgba(255, 255, 255, .92);
      --app-ink: #182230;
      --app-muted: #667085;
      --app-line: #e6eaf0;
      --app-brand: #0f9f92;
      --app-brand-soft: #e8f8f5;
      --app-radius: 10px;
      --app-shadow: 0 12px 36px rgba(16, 24, 40, .07);
    }

    html { background: var(--app-bg); }

    body {
      color: var(--app-ink);
      background: var(--app-bg);
      font-family: Inter, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      -webkit-font-smoothing: antialiased;
      text-rendering: optimizeLegibility;
    }

    .content-wrapper {
      position: relative;
      min-height: 100vh;
      padding-top: 80px;
      background:
        radial-gradient(circle at 84% 4%, rgba(45, 212, 191, .075), transparent 24rem),
        radial-gradient(circle at 18% 28%, rgba(59, 130, 246, .045), transparent 28rem),
        var(--app-bg);
    }

    .content-wrapper::before {
      position: fixed;
      z-index: 0;
      top: 0;
      right: 0;
      bottom: 0;
      left: 250px;
      content: "";
      opacity: .28;
      pointer-events: none;
      background-image: radial-gradient(rgba(100, 116, 139, .18) .55px, transparent .55px);
      background-size: 18px 18px;
      -webkit-mask-image: linear-gradient(to bottom, #000, transparent 38%);
      mask-image: linear-gradient(to bottom, #000, transparent 38%);
    }

    /* Jangan membuat stacking context di area konten: modal Bootstrap harus
       dapat berada di atas backdrop yang ditempel langsung ke body. */
    .content-wrapper > * { position: relative; }

    .app-header {
      top: 8px;
      right: 10px;
      min-height: 62px;
      margin-left: 264px !important;
      padding: 0 14px;
      background: rgba(255, 255, 255, .82) !important;
      border: 1px solid rgba(255, 255, 255, .88);
      border-radius: 10px;
      box-shadow: 0 10px 34px rgba(16, 24, 40, .09), inset 0 1px 0 rgba(255, 255, 255, .88);
      backdrop-filter: blur(18px) saturate(145%);
      -webkit-backdrop-filter: blur(18px) saturate(145%);
    }

    .app-header .sidebar-trigger,
    .app-header .header-action {
      color: #475467 !important;
      background: rgba(248, 250, 252, .88);
      border-color: #e4e7ec;
      border-radius: 12px;
      box-shadow: 0 2px 5px rgba(16, 24, 40, .035);
    }

    .app-header .sidebar-trigger:hover,
    .app-header .header-action:hover {
      color: #087f75 !important;
      background: var(--app-brand-soft);
      border-color: #b9e8df;
      box-shadow: 0 5px 14px rgba(15, 159, 146, .12);
    }

    .header-page-info { border-color: #e4e7ec; }
    .header-page-title { color: #101828; font-size: 13px; font-weight: 750; letter-spacing: -.01em; }
    .header-page-meta { color: #98a2b3; }

    .company-chip {
      color: #087f75;
      background: rgba(232, 248, 245, .9);
      border-color: #c8ede6;
      border-radius: 999px;
    }

    .account-toggle:hover,
    .show > .account-toggle { background: #f2f4f7; }
    .account-name { color: #1d2939; }

    .content { padding: 0 10px 20px !important; }
    .content > .container-fluid {
      padding-right: 0;
      padding-left: 0;
    }

    .card {
      overflow: hidden;
      background: var(--app-surface);
      border: 1px solid rgba(230, 234, 240, .92);
      border-radius: var(--app-radius);
      box-shadow: var(--app-shadow);
      backdrop-filter: blur(8px);
      transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
    }

    .card:hover { border-color: #d7dde6; box-shadow: 0 16px 42px rgba(16, 24, 40, .09); }
    .card-header { min-height: 54px; padding: 14px 18px; background: rgba(255, 255, 255, .68); border-bottom: 1px solid var(--app-line); }
    .card-title { color: #1d2939; font-size: 14px; font-weight: 750; letter-spacing: -.01em; }
    .card-body { padding: 18px; }
    .card-footer { padding: 13px 18px; background: #fcfcfd; border-top: 1px solid var(--app-line); }

    .btn {
      border-radius: 10px;
      font-weight: 600;
      box-shadow: 0 2px 5px rgba(16, 24, 40, .05);
      transition: transform .16s ease, box-shadow .16s ease, background-color .16s ease;
    }
    .btn:hover { transform: translateY(-1px); box-shadow: 0 6px 14px rgba(16, 24, 40, .10); }
    .btn:active { transform: translateY(0); }
    .btn-primary { background: linear-gradient(135deg, #12a89a, #087f75); border-color: #087f75; }
    .btn-primary:hover { background: linear-gradient(135deg, #0f978b, #066b63); border-color: #066b63; }
    .btn-default, .btn-light { color: #475467; background: #fff; border-color: #dfe3e8; }

    .form-control,
    .custom-select,
    .select2-container--bootstrap4 .select2-selection {
      min-height: 40px;
      color: #344054;
      background-color: rgba(255, 255, 255, .92);
      border-color: #dfe3e8;
      border-radius: 10px;
      box-shadow: 0 1px 2px rgba(16, 24, 40, .025);
      transition: border-color .18s ease, box-shadow .18s ease;
    }
    .form-control:focus,
    .custom-select:focus,
    .select2-container--bootstrap4.select2-container--focus .select2-selection {
      border-color: #67d4c8;
      box-shadow: 0 0 0 3px rgba(15, 159, 146, .11);
    }
    label { color: #475467; font-size: 12px; font-weight: 650; }

    .table { color: #344054; }
    .table thead th { padding: 12px; color: #667085; background: #f8fafc; border-top: 0; border-bottom: 1px solid #e4e7ec; font-size: 11px; font-weight: 750; letter-spacing: .035em; text-transform: uppercase; }
    .table td { padding: 12px; border-color: #edf0f3; vertical-align: middle; }
    .table-hover tbody tr { transition: background-color .15s ease; }
    .table-hover tbody tr:hover { color: #1d2939; background: #f7fbfa; }

    .modal-content,
    .dropdown-menu {
      border: 1px solid rgba(230, 234, 240, .95);
      border-radius: 15px;
      box-shadow: 0 22px 54px rgba(16, 24, 40, .16);
    }
    .modal-header { border-bottom-color: var(--app-line); }
    .modal-footer { border-top-color: var(--app-line); }
    .modal { z-index: 1060; }
    .modal-backdrop { z-index: 1050; }
    body.modal-open .app-header,
    body.modal-open .main-sidebar { z-index: 1030; }
    .badge { border-radius: 999px; font-weight: 700; }

    .pagination .page-link { margin: 0 2px; color: #475467; border-color: #e4e7ec; border-radius: 8px !important; }
    .pagination .page-item.active .page-link { background: var(--app-brand); border-color: var(--app-brand); }

    @media (min-width: 992px) {
      .layout-fixed .main-sidebar {
        top: 8px !important;
        bottom: 5px !important;
        left: 8px;
        width: 250px;
        height: calc(100vh - 10px) !important;
        min-height: 0 !important;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 12px;
        box-shadow: 0 20px 55px rgba(15, 23, 42, .22) !important;
      }
      .main-sidebar .brand-link { width: 250px; }
      .content-wrapper, .main-footer { margin-left: 258px !important; }
      .sidebar-collapse .content-wrapper,
      .sidebar-collapse .main-footer { margin-left: 4.6rem !important; }
      .app-header { margin-left: 268px !important; }
      .sidebar-collapse .app-header { margin-left: calc(4.6rem + 10px) !important; }
      .content-wrapper::before { left: 258px; }
      .sidebar-collapse .content-wrapper::before { left: 4.6rem; }

      .sidebar-collapse .main-sidebar:not(:hover) {
        left: 7px;
        width: 60px;
        border-radius: 10px;
      }
      .sidebar-collapse .main-sidebar:not(:hover) .brand-link { width: 60px; }
    }

    @media (max-width: 991.98px) {
      .app-header { top: 7px; right: 14px; left: 14px; margin-left: 0 !important; border-radius: 10px; }
      .content-wrapper { padding-top: 82px; }
      .content { padding: 0 14px 28px !important; }
      .content-wrapper::before { left: 0; }
    }

    @media (prefers-reduced-motion: reduce) {
      .card, .btn, .form-control, .custom-select { transition: none !important; }
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
      <a href="<?= base_url('') ?>" class="brand-link adm-brand" aria-label="Kembali ke halaman utama ABSI">
        <span class="adm-brand-monogram" aria-hidden="true">
          <svg viewBox="0 0 48 48" focusable="false">
            <path class="adm-logo-box" d="M12 15.5 24 9l12 6.5-12 6.6z" />
            <path class="adm-logo-side" d="M12 15.5v13L24 35V22.1z" />
            <path class="adm-logo-face" d="M36 15.5v13L24 35V22.1z" />
            <path class="adm-logo-pulse" d="M8 35h7l2.7-5.2 4.1 10.1 3.6-7.2 2 3.1H40" />
          </svg>
        </span>
        <span class="brand-text adm-brand-copy">
          <strong><span class="adm-brand-name">ABSI</span><span class="adm-brand-tag">Ver 1.2.0</span></strong>
          <small><i></i> Consignment Monitor</small>
        </span>
        <span class="adm-brand-shine" aria-hidden="true"></span>
      </a>
      <?php $this->load->view($sidebar) ?>
      <style id="absi-shared-sidebar-skin">
        /* Shared visual skin: applies to every role sidebar without changing its menu. */
        .main-sidebar {
          display: flex;
          flex-direction: column;
          overflow: hidden;
          background: linear-gradient(180deg, #0e1723 0%, #101927 52%, #0b141f 100%) !important;
        }

        .main-sidebar .adm-brand {
          position: relative;
          display: flex !important;
          height: 70px;
          width: 100% !important;
          flex: 0 0 70px;
          flex-direction: row !important;
          align-items: center !important;
          justify-content: flex-start !important;
          gap: 10px;
          padding: 12px 14px;
          overflow: hidden;
          background: rgba(14, 23, 35, .97) !important;
          border-bottom: 1px solid rgba(148, 163, 184, .10) !important;
          box-shadow: none !important;
        }

        .main-sidebar .adm-brand-monogram {
          position: relative;
          display: grid;
          width: 46px;
          height: 46px;
          flex: 0 0 46px;
          overflow: hidden;
          place-items: center;
          border: 1px solid rgba(94, 234, 212, .30);
          border-radius: 12px;
          background: linear-gradient(145deg, #153642, #0c202a 72%);
          box-shadow: 0 8px 20px rgba(2, 6, 23, .30), inset 0 1px 0 rgba(255, 255, 255, .10);
        }

        .main-sidebar .adm-brand-monogram svg { position: relative; z-index: 1; width: 36px; height: 36px; }
        .main-sidebar .adm-logo-box { fill: #99f6e4; }
        .main-sidebar .adm-logo-side { fill: #2dd4bf; }
        .main-sidebar .adm-logo-face { fill: #0f9f92; }
        .main-sidebar .adm-logo-pulse { fill: none; stroke: #e6fffb; stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round; }
        .main-sidebar .adm-brand-copy { display: flex !important; min-width: 0; flex-direction: column !important; align-items: flex-start !important; line-height: 1; }
        .main-sidebar .adm-brand-copy strong { display: flex; align-items: center; gap: 7px; }
        .main-sidebar .adm-brand-name { color: #f8fafc; font-size: 22px; font-weight: 850; letter-spacing: .08em; }
        .main-sidebar .adm-brand-tag { padding: 3px 5px 2px; color: #5eead4; background: rgba(45, 212, 191, .10); border: 1px solid rgba(94, 234, 212, .16); border-radius: 4px; font-size: 7px; font-weight: 800; letter-spacing: .09em; text-transform: uppercase; }
        .main-sidebar .adm-brand-copy small { display: flex; align-items: center; gap: 5px; margin-top: 4px; color: #8291a5; font-size: 8px; font-weight: 650; letter-spacing: .10em; text-transform: uppercase; }
        .main-sidebar .adm-brand-copy small i { width: 5px; height: 5px; border-radius: 50%; background: #2dd4bf; box-shadow: 0 0 0 3px rgba(45, 212, 191, .10); }

        .main-sidebar > .adm-sidebar-intro {
          position: relative;
          z-index: 20;
          flex: 0 0 auto;
          padding: 1px 12px 11px;
          background: #0e1723;
        }
        .main-sidebar .adm-status-row { display: flex; min-height: 28px; align-items: center; padding: 4px 3px; color: #94a3b8; font-size: 10px; }
        .main-sidebar .adm-status-row strong { margin-right: 3px; color: #fbbf24; font-size: 11px; }
        .main-sidebar .adm-menu-search { display: flex; min-height: 40px; align-items: center; gap: 9px; margin: 0; padding: 0 10px; color: #64748b; background: rgba(4, 10, 18, .34); border: 1px solid rgba(148, 163, 184, .12); border-radius: 10px; box-shadow: inset 0 1px 3px rgba(2, 6, 23, .15); }
        .main-sidebar .adm-menu-search:focus-within { color: #5eead4; background: rgba(15, 23, 42, .86); border-color: rgba(45, 212, 191, .48); box-shadow: 0 0 0 3px rgba(20, 184, 166, .10); }
        .main-sidebar .adm-menu-search input { min-width: 0; flex: 1; padding: 0; color: #e2e8f0; background: transparent; border: 0; outline: 0; font-size: 12px; }
        .main-sidebar .adm-menu-search input::placeholder { color: #64748b; }
        .main-sidebar .adm-menu-search kbd { padding: 1px 6px; color: #94a3b8; background: rgba(148, 163, 184, .10); border: 1px solid rgba(148, 163, 184, .15); border-radius: 5px; font: 10px/16px inherit; }
        .main-sidebar .adm-search-empty { display: none; margin: 12px 4px 2px; color: #94a3b8; font-size: 11px; text-align: center; }

        .main-sidebar > .sidebar {
          height: auto !important;
          min-height: 0;
          flex: 1 1 auto;
          padding: 8px 7px 18px !important;
          overflow-y: auto;
          background: transparent !important;
          scrollbar-width: thin;
          scrollbar-color: rgba(148, 163, 184, .28) transparent;
        }

        .main-sidebar .nav-sidebar { gap: 3px; padding: 0 2px; }
        .main-sidebar .nav-sidebar > .nav-header {
          display: flex;
          align-items: center;
          gap: 8px;
          margin: 17px 9px 7px;
          padding: 0;
          color: #64748b !important;
          font-size: 9px;
          font-weight: 700;
          letter-spacing: .14em;
          text-transform: uppercase;
        }
        .main-sidebar .nav-sidebar > .nav-header::after { height: 1px; flex: 1; content: ""; background: linear-gradient(90deg, rgba(148, 163, 184, .17), transparent); }
        .main-sidebar .nav-sidebar .nav-item { margin: 0; }
        .main-sidebar .nav-sidebar .nav-link {
          display: flex;
          min-height: 46px;
          align-items: center;
          margin: 2px 0 !important;
          padding: 7px 9px !important;
          color: #aebaca !important;
          background: transparent !important;
          border: 1px solid transparent !important;
          border-radius: 10px !important;
          box-shadow: none !important;
          transition: color .18s ease, background .18s ease, transform .18s ease;
        }
        .main-sidebar .nav-sidebar .nav-link:hover { color: #f8fafc !important; background: rgba(255, 255, 255, .055) !important; transform: translateX(2px); }
        .main-sidebar .nav-sidebar .nav-link .nav-icon {
          display: inline-grid;
          width: 32px !important;
          height: 32px;
          flex: 0 0 32px;
          margin: 0 10px 0 0 !important;
          place-items: center;
          color: #8291a5 !important;
          background: rgba(255, 255, 255, .045) !important;
          border: 1px solid rgba(255, 255, 255, .055);
          border-radius: 9px;
          font-size: 13px !important;
        }
        .main-sidebar .nav-sidebar .nav-link.active,
        .main-sidebar .nav-sidebar .menu-open > .nav-link { color: #ecfdfb !important; background: linear-gradient(105deg, rgba(15, 159, 146, .25), rgba(15, 159, 146, .10)) !important; border-color: rgba(94, 234, 212, .15) !important; box-shadow: inset 0 1px 0 rgba(255, 255, 255, .06), 0 7px 18px rgba(2, 6, 23, .13) !important; }
        .main-sidebar .nav-sidebar .nav-link.active .nav-icon,
        .main-sidebar .nav-sidebar .menu-open > .nav-link .nav-icon { color: #062b29 !important; background: linear-gradient(145deg, #76eadc, #2dd4bf) !important; border-color: rgba(153, 246, 228, .55); box-shadow: 0 5px 13px rgba(20, 184, 166, .22); }
        .main-sidebar .nav-sidebar .nav-link p { margin: 0; font-size: 13px; font-weight: 550; }
        .main-sidebar .nav-treeview { margin: 3px 0 7px 21px !important; padding: 5px 5px 5px 14px !important; background: rgba(2, 6, 23, .17) !important; border-radius: 0 0 10px 10px !important; }
        .main-sidebar .nav-treeview .nav-link { min-height: 36px; padding: 6px 9px !important; border-radius: 8px !important; }

        @media (min-width: 992px) {
          .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .adm-brand-copy,
          .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .adm-brand-shine { display: none; }
          .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .adm-brand { justify-content: center; padding: 8px; }
          .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .adm-brand-monogram { width: 38px; height: 38px; flex-basis: 38px; }
          .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .nav-sidebar .nav-link { justify-content: center; padding-right: 6px !important; padding-left: 6px !important; }
          .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .nav-sidebar .nav-icon { margin-right: 0 !important; }
        }
      </style>
      <script>
        (function() {
          var aside = document.currentScript.closest('.main-sidebar');
          if (!aside || aside.querySelector(':scope > .adm-sidebar-intro')) return;

          var sidebar = aside.querySelector(':scope > .sidebar');
          var nav = sidebar ? sidebar.querySelector('.nav-sidebar') : null;
          if (!sidebar || !nav) return;

          var reviewCount = 0;
          nav.querySelectorAll('.badge').forEach(function(badge) {
            var value = parseInt((badge.textContent || '').replace(/[^0-9]/g, ''), 10);
            if (!isNaN(value)) reviewCount += value;
          });

          var tools = document.createElement('div');
          tools.className = 'adm-sidebar-intro';
          tools.innerHTML = '<div class="adm-status-row" aria-label="Ringkasan pekerjaan"><span><strong>' + reviewCount + '</strong> perlu ditinjau</span></div>' +
            '<label class="adm-menu-search"><i class="fas fa-search" aria-hidden="true"></i><input type="search" placeholder="Cari menu..." autocomplete="off" aria-label="Cari menu sidebar"><kbd>/</kbd></label>' +
            '<p class="adm-search-empty" role="status">Menu tidak ditemukan</p>';
          aside.insertBefore(tools, sidebar);

          var input = tools.querySelector('input');
          var empty = tools.querySelector('.adm-search-empty');
          var items = Array.prototype.filter.call(nav.children, function(child) { return child.classList.contains('nav-item'); });

          function filterMenu() {
            var keyword = input.value.toLocaleLowerCase('id-ID').trim();
            items.forEach(function(item) {
              var label = (item.textContent || '').replace(/\s+/g, ' ').toLocaleLowerCase('id-ID');
              item.style.display = keyword && label.indexOf(keyword) === -1 ? 'none' : '';
            });
            var hasResult = items.some(function(item) { return item.style.display !== 'none'; });
            empty.style.display = keyword && !hasResult ? 'block' : 'none';
          }

          input.addEventListener('input', filterMenu);
          input.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') { input.value = ''; filterMenu(); input.blur(); }
          });
          document.addEventListener('keydown', function(event) {
            var target = event.target;
            var typing = target && (target.tagName === 'INPUT' || target.tagName === 'TEXTAREA' || target.isContentEditable);
            if (event.key === '/' && !typing) { event.preventDefault(); input.focus(); }
          });
        })();
      </script>
    </aside>
    <div class="content-wrapper">
      <?= $contents ?>
    </div>
  </div>
  <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
  <script>
    // Modal pada beberapa halaman berada di dalam card/content yang memiliki
    // overflow atau backdrop-filter. Pindahkan ke body agar posisi fixed,
    // backdrop, fokus, dan perhitungan ukuran Bootstrap tetap normal.
    $(document).on('show.bs.modal', '.modal', function() {
      if (this.parentNode !== document.body) {
        document.body.appendChild(this);
      }
    });
  </script>
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

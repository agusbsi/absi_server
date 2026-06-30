<?php
$id = $this->session->userdata('id');
$Permintaan = $this->db->query("SELECT * FROM tb_permintaan JOIN tb_toko ON tb_permintaan.id_toko = tb_toko.id JOIN tb_user ON tb_user.id = tb_toko.id_leader WHERE tb_permintaan.status = '0' AND tb_toko.id_leader ='$id'")->num_rows();
$Retur = $this->db->query("SELECT * FROM tb_retur JOIN tb_toko ON tb_retur.id_toko = tb_toko.id JOIN tb_user ON tb_user.id = tb_toko.id_leader WHERE tb_retur.status = '0' AND tb_toko.id_leader ='$id'")->num_rows();
$Bap = $this->db->query("SELECT * FROM tb_bap 
  JOIN tb_toko ON tb_bap.id_toko = tb_toko.id 
  JOIN tb_user ON tb_user.id = tb_toko.id_leader 
  WHERE tb_bap.status = '0' AND tb_toko.id_leader ='$id'")->num_rows();
?>
<!-- Sidebar -->
<div class="sidebar tl-sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column tl-nav" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="<?= base_url('leader/Dashboard') ?>" class="nav-link <?= ($title == 'Dashboard') ? "active" : "" ?>">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-header">Master Data</li>
      <li class="nav-item <?= ($title == 'Kelola Toko' || $title == 'List Toko Tutup') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Kelola Toko' || $title == 'List Toko Tutup') ? "active" : "" ?>">
          <i class="nav-icon fas fa-store"></i>
          <p>
            Toko
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('leader/Toko') ?>" class="nav-link <?= ($title == 'Kelola Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Toko Aktif</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('spv/Toko/toko_tutup') ?>" class="nav-link <?= ($title == 'List Toko Tutup') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Toko Tutup</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('leader/spg') ?>" class="nav-link <?= ($title == 'Kelola User') ? "active" : "" ?>">
          <i class="nav-icon fas fa-users"></i>
          <p>
            Kelola SPG
          </p>
        </a>
      </li>
      <li class="nav-header">Menu Utama</li>
      <li class="nav-item <?= ($title == 'Management Aset' || $title == 'Histori Aset' || $title == 'Detail Aset') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Management Aset' || $title == 'Histori ASET' || $title == 'Detail Aset') ? "active" : "" ?>">
          <i class="nav-icon fas fa-dolly"></i>
          <p>
            Management Aset Toko
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('hrd/Aset/list_aset') ?>" class="nav-link <?= ($title == 'Management Aset') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Bulan ini
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/So/histori_aset') ?>" class="nav-link <?= ($title == 'Histori Aset') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Histori</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item <?= ($title == 'Management Stock Opname' || $title == 'Histori SO' || $title == 'Detail SO') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Management Stock Opname' || $title == 'Histori SO' || $title == 'Detail SO') ? "active" : "" ?>">
          <i class="nav-icon fas fa-file"></i>
          <p>
            Management SO Toko
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('sup/So') ?>" class="nav-link <?= ($title == 'Management Stock Opname') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Bulan ini
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('sup/So/Riwayat_so') ?>" class="nav-link <?= ($title == 'Histori SO') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Histori</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Analist') ?>" class="nav-link <?= ($title == 'Marketing Analist') ? "active" : "" ?>">
          <i class="nav-icon fas fa-flask"></i>
          <p>
            Marketing Analist
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('leader/Permintaan') ?>" class="nav-link <?= ($title == 'Permintaan') ? "active" : "" ?>">
          <i class="nav-icon fas fa-file-alt"></i>
          <p>
            Permintaan
            <?php if ($Permintaan == 0) { ?>
            <?php } else { ?>
              <span class="right badge badge-danger"><?= $Permintaan ?></span>
            <?php } ?>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('leader/Pengiriman') ?>" class="nav-link <?= ($title == 'Pengiriman') ? "active" : "" ?>">
          <i class="nav-icon fas fa-truck"></i>
          <p>
            Pengiriman
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('leader/Mutasi') ?>" class="nav-link <?= ($title == 'Mutasi Barang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-copy"></i>
          <p>
            Mutasi Barang
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('leader/Retur') ?>" class="nav-link <?= ($title == 'Retur') ? "active" : "" ?>">
          <i class="nav-icon fas fa-exchange-alt"></i>
          <p>
            Retur
            <?php if ($Retur == 0) { ?>
            <?php } else { ?>
              <span class="right badge badge-danger"><?= $Retur ?></span>
            <?php } ?>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('leader/Bap') ?>" class="nav-link <?= ($title == 'Bap') ? "active" : "" ?>">
          <i class="nav-icon fas fa-envelope"></i>
          <p>
            B.A.P
            <?php if ($Bap == 0) { ?>
            <?php } else { ?>
              <span class="right badge badge-danger"><?= $Bap ?></span>
            <?php } ?>
          </p>
        </a>
      </li>
      <li class="nav-header">Laporan</li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Stok/stok_gudang') ?>" class="nav-link <?= ($title == 'Stok Gudang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-warehouse"></i>
          <p>
            Stok Gudang
          </p>
        </a>
      </li>
      <li class="nav-item <?= ($title == 'Stok Artikel' || $title == 'Laporan Stok Customer' || $title == 'Kartu Stok') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Stok Artikel' || $title == 'Laporan Stok Customer' || $title == 'Kartu Stok') ? "active" : "" ?>">
          <i class="nav-icon fas fa-chart-pie"></i>
          <p>
            Stok
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('leader/Stok') ?>" class="nav-link <?= ($title == 'Stok Artikel') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Artikel
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/Stok/s_customer') ?>" class="nav-link <?= ($title == 'Laporan Stok Customer') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Customer
              </p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item <?= ($title == 'Penjualan Artikel' || $title == 'Penjualan Toko' || $title == 'Penjualan Customer' || $title == 'Penjualan Periode' || $title == 'Penjualan Area') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Penjualan Artikel' || $title == 'Penjualan Toko' || $title == 'Penjualan Customer' || $title == 'Penjualan Periode' || $title == 'Penjualan Area') ? "active" : "" ?>">
          <i class="nav-icon fas fa-cart-plus"></i>
          <p>
            Penjualan
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('leader/Penjualan/lap_artikel') ?>" class="nav-link <?= ($title == 'Penjualan Artikel') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Artikel
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('leader/Penjualan/lap_toko') ?>" class="nav-link <?= ($title == 'Penjualan Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Toko
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/Penjualan/lap_periode') ?>" class="nav-link <?= ($title == 'Penjualan Periode') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Periode
              </p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-header">Akun</li>
      <li class="nav-item">
        <a href="<?= base_url('Profile') ?>" class="nav-link <?= ($title == 'Profile') ? "active" : "" ?>">
          <i class="nav-icon fas fa-user"></i>
          <p>
            Profil
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="javascript:void(0)" class="nav-link" onclick="logout()">
          <i class="nav-icon fas fa-sign-out-alt"></i>
          <p>
            Logout
          </p>
        </a>
      </li>
      <br>
      <br>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->

<style>
  .tl-bottom-nav {
    display: none;
  }

  .tl-sidebar {
    background:
      radial-gradient(circle at top left, rgba(20, 184, 166, 0.18), transparent 34%),
      linear-gradient(180deg, #17202a 0%, #111827 52%, #0f172a 100%);
    padding: 10px 0 18px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(148, 163, 184, 0.45) transparent;
    scroll-behavior: smooth;
  }

  .tl-sidebar::-webkit-scrollbar {
    width: 6px;
  }

  .tl-sidebar::-webkit-scrollbar-track {
    background: transparent;
  }

  .tl-sidebar::-webkit-scrollbar-thumb {
    background: rgba(148, 163, 184, 0.38);
    border-radius: 999px;
  }

  .tl-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(148, 163, 184, 0.62);
  }

  .tl-nav {
    gap: 2px;
  }

  .tl-nav .nav-header {
    color: rgba(203, 213, 225, 0.78);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.08em;
    margin: 16px 14px 7px;
    padding: 0 4px 8px;
    text-transform: uppercase;
    border-bottom: 1px solid rgba(148, 163, 184, 0.14);
  }

  .tl-nav .nav-header:first-of-type {
    margin-top: 6px;
  }

  .tl-nav .nav-item {
    margin: 1px 0;
  }

  .tl-nav .nav-link {
    position: relative;
    display: flex;
    align-items: center;
    min-height: 42px;
    margin: 2px 10px;
    padding: 10px 12px;
    color: rgba(226, 232, 240, 0.88);
    border-radius: 8px;
    border: 1px solid transparent;
    transition: background-color 220ms ease, border-color 220ms ease, color 220ms ease, transform 220ms ease, box-shadow 220ms ease;
  }

  .tl-nav .nav-link::before {
    content: "";
    position: absolute;
    left: 6px;
    top: 10px;
    bottom: 10px;
    width: 3px;
    border-radius: 99px;
    background: transparent;
    transition: background-color 220ms ease, transform 220ms ease;
    transform: scaleY(0.45);
  }

  .tl-nav .nav-link:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.075);
    border-color: rgba(148, 163, 184, 0.14);
    transform: translateX(3px);
  }

  .tl-nav .nav-link:hover::before {
    background: rgba(20, 184, 166, 0.72);
    transform: scaleY(1);
  }

  .tl-nav .nav-link.active,
  .tl-nav .menu-open > .nav-link {
    color: #ffffff;
    background: rgba(20, 184, 166, 0.16);
    border-color: rgba(45, 212, 191, 0.22);
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.18);
  }

  .tl-nav .nav-link.active::before,
  .tl-nav .menu-open > .nav-link::before {
    background: #2dd4bf;
    transform: scaleY(1);
  }

  .tl-nav .nav-link .nav-icon {
    width: 28px;
    margin: 0 11px 0 0;
    color: rgba(125, 211, 252, 0.82);
    font-size: 15px;
    text-align: center;
    transition: color 220ms ease, transform 220ms ease;
  }

  .tl-nav .nav-link:hover .nav-icon,
  .tl-nav .nav-link.active .nav-icon,
  .tl-nav .menu-open > .nav-link .nav-icon {
    color: #5eead4;
    transform: translateY(-1px);
  }

  .tl-nav .nav-link p {
    display: flex;
    align-items: center;
    flex: 1;
    min-width: 0;
    margin: 0;
    gap: 8px;
    font-size: 14px;
    line-height: 1.25;
    white-space: normal;
  }

  .tl-nav .right {
    margin-left: auto;
  }

  .tl-nav .nav-link .fa-angle-left {
    color: rgba(203, 213, 225, 0.72);
    transition: transform 240ms ease, color 220ms ease;
  }

  .tl-nav .menu-open > .nav-link .fa-angle-left {
    color: #99f6e4;
    transform: rotate(-90deg);
  }

  .tl-nav .badge {
    min-width: 22px;
    height: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 7px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12);
    animation: tlBadgePulse 2.4s ease-in-out infinite;
  }

  .tl-nav .nav-treeview {
    margin: 2px 10px 7px 26px;
    padding: 4px 0 4px 9px;
    border-left: 1px solid rgba(148, 163, 184, 0.16);
    animation: tlTreeIn 220ms ease;
  }

  .tl-nav .nav-treeview .nav-link {
    min-height: 36px;
    margin: 1px 0 1px 8px;
    padding: 8px 10px;
    color: rgba(203, 213, 225, 0.86);
    background: transparent;
    box-shadow: none;
  }

  .tl-nav .nav-treeview .nav-link::before {
    left: -12px;
    top: 15px;
    bottom: auto;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(148, 163, 184, 0.38);
    transform: none;
  }

  .tl-nav .nav-treeview .nav-link.active::before,
  .tl-nav .nav-treeview .nav-link:hover::before {
    background: #2dd4bf;
  }

  .tl-nav .nav-treeview .nav-icon {
    display: none;
  }

  .tl-nav .nav-treeview .nav-link p {
    font-size: 13px;
  }

  @keyframes tlTreeIn {
    from {
      opacity: 0;
      transform: translateY(-4px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes tlBadgePulse {
    0%,
    100% {
      transform: scale(1);
    }

    50% {
      transform: scale(1.06);
    }
  }

  @media (prefers-reduced-motion: reduce) {
    .tl-sidebar,
    .tl-nav .nav-link,
    .tl-nav .nav-link::before,
    .tl-nav .nav-link .nav-icon,
    .tl-nav .nav-link .fa-angle-left,
    .tl-nav .badge,
    .tl-nav .nav-treeview {
      animation: none;
      scroll-behavior: auto;
      transition: none;
    }
  }

  @media (max-width: 767.98px) {
    .content-wrapper {
      padding-bottom: calc(82px + env(safe-area-inset-bottom));
    }

    .tl-bottom-nav {
      position: fixed;
      right: 0;
      bottom: calc(8px + env(safe-area-inset-bottom));
      left: 0;
      z-index: 1040;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      align-items: end;
      width: calc(100% - 40px);
      max-width: 330px;
      height: 58px;
      margin: 0 auto;
      padding: 0 6px;
      background: rgba(255, 255, 255, .97);
      border: 1px solid rgba(15, 23, 42, .08);
      border-radius: 18px;
      box-shadow: 0 8px 24px rgba(15, 23, 42, .16);
      -webkit-backdrop-filter: blur(12px);
      backdrop-filter: blur(12px);
    }

    .tl-bottom-nav__item {
      position: relative;
      display: flex;
      min-width: 0;
      height: 54px;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 3px;
      color: #8a94a6;
      font-size: 10px;
      font-weight: 600;
      line-height: 1;
      text-decoration: none !important;
      transition: color .2s ease, transform .2s ease;
      -webkit-tap-highlight-color: transparent;
    }

    .tl-bottom-nav__item > i {
      font-size: 17px;
    }

    .tl-bottom-nav__item:hover,
    .tl-bottom-nav__item:focus,
    .tl-bottom-nav__item.active {
      color: #1677ff;
    }

    .tl-bottom-nav__item.active::after {
      position: absolute;
      bottom: 2px;
      width: 4px;
      height: 4px;
      content: '';
      background: #1677ff;
      border-radius: 50%;
    }

    .tl-bottom-nav__item--po {
      align-self: start;
      height: 73px;
      margin-top: -23px;
      color: #526070;
    }

    .tl-bottom-nav__po-icon {
      display: flex;
      width: 50px;
      height: 50px;
      align-items: center;
      justify-content: center;
      color: #fff;
      background: linear-gradient(135deg, #1677ff 0%, #00b8d9 100%);
      border: 4px solid #fff;
      border-radius: 50%;
      box-shadow: 0 6px 16px rgba(22, 119, 255, .32);
      transition: transform .2s ease, box-shadow .2s ease;
    }

    .tl-bottom-nav__po-icon i {
      font-size: 18px;
    }

    .tl-bottom-nav__item--po:hover .tl-bottom-nav__po-icon,
    .tl-bottom-nav__item--po:focus .tl-bottom-nav__po-icon,
    .tl-bottom-nav__item--po.active .tl-bottom-nav__po-icon {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(22, 119, 255, .42);
    }

    .tl-bottom-nav__item--po.active::after {
      display: none;
    }

    .tl-bottom-nav__item--po.active .tl-bottom-nav__label {
      color: #1677ff;
    }

    .tl-nav .nav-link {
      margin-left: 8px;
      margin-right: 8px;
      padding-right: 10px;
    }

    .tl-nav .nav-treeview {
      margin-left: 22px;
      margin-right: 8px;
    }
  }
</style>

<nav class="tl-bottom-nav no-print" aria-label="Navigasi utama Team Leader">
  <a
    href="<?= base_url('leader/Dashboard') ?>"
    class="tl-bottom-nav__item <?= ($title == 'Dashboard') ? 'active' : '' ?>"
    <?= ($title == 'Dashboard') ? 'aria-current="page"' : '' ?>>
    <i class="fas fa-home" aria-hidden="true"></i>
    <span class="tl-bottom-nav__label">Home</span>
  </a>

  <a
    href="<?= base_url('leader/Permintaan') ?>"
    class="tl-bottom-nav__item tl-bottom-nav__item--po <?= ($title == 'Permintaan') ? 'active' : '' ?>"
    <?= ($title == 'Permintaan') ? 'aria-current="page"' : '' ?>>
    <span class="tl-bottom-nav__po-icon">
      <i class="fas fa-file-alt" aria-hidden="true"></i>
    </span>
    <span class="tl-bottom-nav__label">PO</span>
  </a>

  <a
    href="<?= base_url('Profile') ?>"
    class="tl-bottom-nav__item <?= ($title == 'Profile') ? 'active' : '' ?>"
    <?= ($title == 'Profile') ? 'aria-current="page"' : '' ?>>
    <i class="fas fa-user" aria-hidden="true"></i>
    <span class="tl-bottom-nav__label">Profil</span>
  </a>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.querySelector('.tl-sidebar');
    var activeLink = document.querySelector('.tl-nav .nav-link.active');

    if (sidebar && activeLink) {
      window.setTimeout(function() {
        sidebar.scrollTo({
          top: Math.max(0, activeLink.offsetTop - 96),
          behavior: 'smooth'
        });
      }, 260);
    }

    document.querySelectorAll('.tl-nav .nav-item > .nav-link[href="#"]').forEach(function(link) {
      link.addEventListener('click', function() {
        var item = link.closest('.nav-item');

        window.setTimeout(function() {
          if (sidebar && item && item.classList.contains('menu-open')) {
            sidebar.scrollTo({
              top: Math.max(0, item.offsetTop - 72),
              behavior: 'smooth'
            });
          }
        }, 180);
      });
    });
  });
</script>

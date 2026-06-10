<?php
$id = $this->session->userdata('id');
$Artikel = $this->db->query("SELECT id FROM tb_stok WHERE status = '2'")->num_rows();
$Toko = $this->db->query("SELECT id FROM tb_pengajuan_toko WHERE status = '0'")->num_rows();
$Retur = $this->db->query("SELECT id FROM tb_retur WHERE status = '2'")->num_rows();
$Mutasi = $this->db->query("SELECT id FROM tb_mutasi WHERE status = '6'")->num_rows();
?>
<!-- Sidebar -->
<div class="sidebar mngmkt-sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column mngmkt-nav" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="<?= base_url('mng_mkt/Dashboard') ?>" class="nav-link <?= ($title == 'Dashboard') ? "active" : "" ?>">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-header">Master Data</li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Customer') ?>" class="nav-link <?= ($title == 'Kelola Customer') ? "active" : "" ?>">
          <i class="nav-icon fas fa-hotel"></i>
          <p>
            Customer
          </p>
        </a>
      </li>
      <li class="nav-item <?= ($title == 'Toko' || $title == 'List Toko Tutup' || $title == 'Pengajuan Toko') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Toko' || $title == 'List Toko Tutup' || $title == 'Pengajuan Toko') ? "active" : "" ?>">
          <i class="nav-icon fas fa-store"></i>
          <p>
            Toko
            <i class="right fas fa-angle-left"></i>
            <?php if ($Toko != 0) { ?>
              <span class="right badge badge-danger"><?= $Toko ?></span>
            <?php } ?>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('mng_mkt/Toko/pengajuanToko') ?>" class="nav-link <?= ($title == 'Pengajuan Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Pengajuan Toko
                <?php if ($Toko != 0) { ?>
                  <span class="right badge badge-danger"><?= $Toko ?></span>
                <?php } ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/toko') ?>" class="nav-link <?= ($title == 'Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Toko Aktif</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('mng_mkt/Toko/toko_tutup') ?>" class="nav-link <?= ($title == 'List Toko Tutup') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Toko Tutup
              </p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Area') ?>" class="nav-link <?= ($title == 'Area') ? "active" : "" ?>">
          <i class="nav-icon fas fa-map"></i>
          <p>
            Area
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('mng_mkt/user') ?>" class="nav-link <?= ($title == 'User') ? "active" : "" ?>">
          <i class="nav-icon fas fa-user"></i>
          <p>
            User
          </p>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a href="<?= base_url('mng_mkt/promo') ?>" class="nav-link <?= ($title == 'Management Promo') ? "active" : "" ?>">
          <i class="nav-icon fas fa-percent"></i>
          <p>
            Promo
          </p>
        </a>
      </li> -->
      <li class="nav-header">Menu Utama</li>
      <li class="nav-item">
        <a href="<?= base_url('mng_mkt/Artikel') ?>" class="nav-link <?= ($title == 'Artikel Baru') ? "active" : "" ?>">
          <i class="nav-icon fas fa-box"></i>
          <p>
            Pengajuan Artikel
            <?php if ($Artikel == 0) { ?>
            <?php } else { ?>
              <span class="right badge badge-danger"><?= $Artikel ?></span>
            <?php } ?>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('mng_mkt/Retur/retur') ?>" class="nav-link <?= ($title == 'Retur Barang') ? "active" : "" ?>">
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
        <a href="<?= base_url('mng_mkt/Mutasi') ?>" class="nav-link <?= ($title == 'Mutasi Barang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-copy"></i>
          <p>
            Mutasi
            <?php if ($Mutasi == 0) { ?>
            <?php } else { ?>
              <span class="right badge badge-danger"><?= $Mutasi ?></span>
            <?php } ?>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Analist') ?>" class="nav-link <?= ($title == 'Marketing Analist') ? "active" : "" ?>">
          <i class="nav-icon fas fa-flask"></i>
          <p>
            Marketing Analist
          </p>
        </a>
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

      <li class="nav-header">Laporan</li>
      <li class="nav-item">
        <a href="<?= base_url('adm/Stok/stok_gudang') ?>" class="nav-link <?= ($title == 'Stok Gudang') ? "active" : "" ?>">
          <i class="nav-icon fas fa-warehouse"></i>
          <p>
            Stok Gudang
          </p>
        </a>
      </li>
      <li class="nav-item <?= ($title == 'Stok Artikel' || $title == 'Laporan Stok Customer' || $title == 'Kartu Stok' || $title == 'Stok per Toko') ? "menu-open" : "" ?>">
        <a href="#" class="nav-link <?= ($title == 'Stok Artikel' || $title == 'Laporan Stok Customer' || $title == 'Kartu Stok' || $title == 'Stok per Toko') ? "active" : "" ?>">
          <i class="nav-icon fas fa-chart-pie"></i>
          <p>
            Stok
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url('adm/Stok') ?>" class="nav-link <?= ($title == 'Stok Artikel') ? "active" : "" ?>">
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
          <li class="nav-item">
            <a href="<?= base_url('adm/Stok/s_toko') ?>" class="nav-link <?= ($title == 'Stok per Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Toko
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/Stok/kartu_stok') ?>" class="nav-link <?= ($title == 'Kartu Stok') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Kartu Stok
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
            <a href="<?= base_url('adm/Penjualan/lap_artikel') ?>" class="nav-link <?= ($title == 'Penjualan Artikel') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Artikel
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/Penjualan/lap_toko') ?>" class="nav-link <?= ($title == 'Penjualan Toko') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Toko
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/Penjualan/lap_cust') ?>" class="nav-link <?= ($title == 'Penjualan Customer') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Customer
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('adm/Penjualan/lap_area') ?>" class="nav-link <?= ($title == 'Penjualan Area') ? "active" : "" ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Per Area
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
</div>

<style>
  .mngmkt-sidebar {
    background:
      radial-gradient(circle at top left, rgba(20, 184, 166, 0.18), transparent 34%),
      linear-gradient(180deg, #17202a 0%, #111827 52%, #0f172a 100%);
    padding: 10px 0 18px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(148, 163, 184, 0.45) transparent;
    scroll-behavior: smooth;
  }

  .mngmkt-sidebar::-webkit-scrollbar {
    width: 6px;
  }

  .mngmkt-sidebar::-webkit-scrollbar-track {
    background: transparent;
  }

  .mngmkt-sidebar::-webkit-scrollbar-thumb {
    background: rgba(148, 163, 184, 0.38);
    border-radius: 999px;
  }

  .mngmkt-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(148, 163, 184, 0.62);
  }

  .mngmkt-nav {
    gap: 2px;
  }

  .mngmkt-nav .nav-header {
    color: rgba(203, 213, 225, 0.78);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.08em;
    margin: 16px 14px 7px;
    padding: 0 4px 8px;
    text-transform: uppercase;
    border-bottom: 1px solid rgba(148, 163, 184, 0.14);
  }

  .mngmkt-nav .nav-header:first-of-type {
    margin-top: 6px;
  }

  .mngmkt-nav .nav-item {
    margin: 1px 0;
  }

  .mngmkt-nav .nav-link {
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

  .mngmkt-nav .nav-link::before {
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

  .mngmkt-nav .nav-link:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.075);
    border-color: rgba(148, 163, 184, 0.14);
    transform: translateX(3px);
  }

  .mngmkt-nav .nav-link:hover::before {
    background: rgba(20, 184, 166, 0.72);
    transform: scaleY(1);
  }

  .mngmkt-nav .nav-link.active,
  .mngmkt-nav .menu-open > .nav-link {
    color: #ffffff;
    background: rgba(20, 184, 166, 0.16);
    border-color: rgba(45, 212, 191, 0.22);
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.18);
  }

  .mngmkt-nav .nav-link.active::before,
  .mngmkt-nav .menu-open > .nav-link::before {
    background: #2dd4bf;
    transform: scaleY(1);
  }

  .mngmkt-nav .nav-link .nav-icon {
    width: 28px;
    margin: 0 11px 0 0;
    color: rgba(125, 211, 252, 0.82);
    font-size: 15px;
    text-align: center;
    transition: color 220ms ease, transform 220ms ease;
  }

  .mngmkt-nav .nav-link:hover .nav-icon,
  .mngmkt-nav .nav-link.active .nav-icon,
  .mngmkt-nav .menu-open > .nav-link .nav-icon {
    color: #5eead4;
    transform: translateY(-1px);
  }

  .mngmkt-nav .nav-link p {
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

  .mngmkt-nav .right {
    margin-left: auto;
  }

  .mngmkt-nav .nav-link .fa-angle-left {
    color: rgba(203, 213, 225, 0.72);
    transition: transform 240ms ease, color 220ms ease;
  }

  .mngmkt-nav .menu-open > .nav-link .fa-angle-left {
    color: #99f6e4;
    transform: rotate(-90deg);
  }

  .mngmkt-nav .badge {
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
    animation: mngmktBadgePulse 2.4s ease-in-out infinite;
  }

  .mngmkt-nav .nav-treeview {
    margin: 2px 10px 7px 26px;
    padding: 4px 0 4px 9px;
    border-left: 1px solid rgba(148, 163, 184, 0.16);
    animation: mngmktTreeIn 220ms ease;
  }

  .mngmkt-nav .nav-treeview .nav-link {
    min-height: 36px;
    margin: 1px 0 1px 8px;
    padding: 8px 10px;
    color: rgba(203, 213, 225, 0.86);
    background: transparent;
    box-shadow: none;
  }

  .mngmkt-nav .nav-treeview .nav-link::before {
    left: -12px;
    top: 15px;
    bottom: auto;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(148, 163, 184, 0.38);
    transform: none;
  }

  .mngmkt-nav .nav-treeview .nav-link.active::before,
  .mngmkt-nav .nav-treeview .nav-link:hover::before {
    background: #2dd4bf;
  }

  .mngmkt-nav .nav-treeview .nav-icon {
    display: none;
  }

  .mngmkt-nav .nav-treeview .nav-link p {
    font-size: 13px;
  }

  @keyframes mngmktTreeIn {
    from {
      opacity: 0;
      transform: translateY(-4px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes mngmktBadgePulse {
    0%,
    100% {
      transform: scale(1);
    }

    50% {
      transform: scale(1.06);
    }
  }

  @media (prefers-reduced-motion: reduce) {
    .mngmkt-sidebar,
    .mngmkt-nav .nav-link,
    .mngmkt-nav .nav-link::before,
    .mngmkt-nav .nav-link .nav-icon,
    .mngmkt-nav .nav-link .fa-angle-left,
    .mngmkt-nav .badge,
    .mngmkt-nav .nav-treeview {
      animation: none;
      scroll-behavior: auto;
      transition: none;
    }
  }

  @media (max-width: 767.98px) {
    .mngmkt-nav .nav-link {
      margin-left: 8px;
      margin-right: 8px;
      padding-right: 10px;
    }

    .mngmkt-nav .nav-treeview {
      margin-left: 22px;
      margin-right: 8px;
    }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.querySelector('.mngmkt-sidebar');
    var activeLink = document.querySelector('.mngmkt-nav .nav-link.active');

    if (sidebar && activeLink) {
      window.setTimeout(function() {
        sidebar.scrollTo({
          top: Math.max(0, activeLink.offsetTop - 96),
          behavior: 'smooth'
        });
      }, 260);
    }

    document.querySelectorAll('.mngmkt-nav .nav-item > .nav-link[href="#"]').forEach(function(link) {
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
